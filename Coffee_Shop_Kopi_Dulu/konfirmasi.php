<?php
session_start();
$pesanan = $_SESSION['pesanan'] ?? null;

if (!$pesanan) {
    echo "Tidak ada data pemesanan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Konfirmasi Pemesanan</title>
  <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
  <div class="container mt-5">
    <div class="alert alert-success">
      <h4 class="alert-heading">✅ Pemesanan Berhasil!</h4>
      <p>Terima kasih <strong><?= htmlspecialchars($pesanan['nama']) ?></strong> telah melakukan pemesanan di <strong><?= htmlspecialchars($pesanan['kafe']) ?></strong>.</p>
      <hr>
      <p class="mb-0">
        <strong>Menu:</strong> <?= htmlspecialchars($pesanan['menu']) ?><br>
        <strong>Jumlah:</strong> <?= htmlspecialchars($pesanan['jumlah']) ?><br>
      </p>
    </div>

    <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
  </div>
</body>
</html>
