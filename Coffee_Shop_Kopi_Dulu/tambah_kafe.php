<?php
session_start();
include "db_config.php";

// Validasi admin
if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'admin') {
    echo "Akses ditolak.";
    exit;
}

// Validasi input
if (
    empty($_POST['nama_kafe']) ||
    empty($_POST['username_kafe']) ||
    empty($_POST['password_kafe']) ||
    !isset($_FILES['logo_kafe'])
) {
    echo "Data tidak lengkap.";
    exit;
}

// Ambil input
$nama_kafe = $_POST['nama_kafe'];
$username_kafe = $_POST['username_kafe'];
$password_kafe = $_POST['password_kafe'];

// Handle upload logo
$target_dir = "img/";
$target_file = $target_dir . basename($_FILES["logo_kafe"]["name"]);
$upload_ok = true;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Validasi gambar sederhana
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($imageFileType, $allowed)) {
    echo "❌ File harus berupa gambar (jpg, jpeg, png, gif).";
    $upload_ok = false;
}

if ($upload_ok && move_uploaded_file($_FILES["logo_kafe"]["tmp_name"], $target_file)) {
    // Tambahkan ke database
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username_kafe', '$password_kafe', 'mitra')";
    mysqli_query($conn, $sql);

    // Tambahkan ke file JSON
    $kafeData = file_exists("kafe.json") ? json_decode(file_get_contents("kafe.json"), true) : [];
    $kafeData[] = [
        "nama" => $nama_kafe,
        "logo" => $target_file,
        "username" => $username_kafe
    ];
    file_put_contents("kafe.json", json_encode($kafeData, JSON_PRETTY_PRINT));

    echo "✅ Kafe dan akun mitra berhasil ditambahkan.<br><a href='admin.php'>← Kembali ke admin</a>";
} else {
    echo "❌ Gagal mengupload logo.";
}
?>
