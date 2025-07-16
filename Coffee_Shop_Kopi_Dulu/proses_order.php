<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kafe = $_POST['kafe'] ?? '';
    $menu = $_POST['menu'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $jumlah = $_POST['jumlah'] ?? 1;
    $metode = $_POST['metode'] ?? '';

    $_SESSION['pesanan'] = [
        'kafe' => $kafe,
        'menu' => $menu,
        'nama' => $nama,
        'jumlah' => $jumlah,
        'metode' => $metode,
        'waktu' => date("Y-m-d H:i:s")
    ];

    // Arahkan sesuai metode
    if ($metode === 'transfer') {
        header("Location: upload.php");
    } else {
        header("Location: konfirmasi.php");
    }
    exit;
} else {
    echo "Akses tidak valid.";
}
