<?php
session_start();

if (!isset($_POST['kafe']) || !isset($_POST['menu']) || !isset($_POST['komentar'])) {
    echo "Data tidak lengkap.";
    exit;
}

$kafe = $_POST['kafe'];
$menu = $_POST['menu'];
$komentar = trim($_POST['komentar']);
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0; // Tambahkan rating
$user = isset($_SESSION['user']) ? $_SESSION['user'] : 'Anonim';
$waktu = date('Y-m-d H:i:s');

$mitra = '';
if (file_exists('kafe.json')) {
    $kafeData = json_decode(file_get_contents('kafe.json'), true);
    foreach ($kafeData as $item) {
        if ($item['nama'] === $kafe) {
            $mitra = $item['username'];
            break;
        }
    }
}

if (!$mitra) {
    echo "Kafe tidak ditemukan.";
    exit;
}

$reviewFile = 'review_' . $mitra . '.json';
$reviews = file_exists($reviewFile) ? json_decode(file_get_contents($reviewFile), true) : [];

$reviews[] = [
    'menu' => $menu,
    'user' => $user,
    'komentar' => $komentar,
    'rating' => $rating,
    'waktu' => $waktu
];

file_put_contents($reviewFile, json_encode($reviews, JSON_PRETTY_PRINT));

header("Location: menu.php?kafe=" . urlencode($kafe));
exit;
