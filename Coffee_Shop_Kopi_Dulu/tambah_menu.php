<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'mitra') {
    echo "Akses ditolak.";
    exit;
}

$username = $_SESSION['user'];
$menuFile = 'menu_' . $username . '.json';

$nama = trim($_POST['nama_menu']);
$harga = (int) $_POST['harga'];
$gambarPath = '';

// Proses upload gambar
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Buat folder jika belum ada
    }

    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid('kopi_') . '.' . strtolower($ext);
    $targetFile = $uploadDir . $newFileName;

    // ⚠️ Vulnerable: tidak ada validasi mime type
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        $gambarPath = $targetFile;
    }
}

$menu = [
    "nama" => $nama,
    "harga" => $harga,
    "gambar" => $gambarPath
];

$menus = [];
if (file_exists($menuFile)) {
    $menus = json_decode(file_get_contents($menuFile), true);
}

$menus[] = $menu;
file_put_contents($menuFile, json_encode($menus, JSON_PRETTY_PRINT));

header("Location: mitra.php");
exit;
?>
