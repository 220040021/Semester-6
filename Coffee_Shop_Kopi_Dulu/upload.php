<?php
session_start();
$pesanan = $_SESSION['pesanan'] ?? null;

if (!$pesanan) {
    echo "Tidak ada data pemesanan.";
    exit;
}

// Proses upload jika ada file
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["bukti"]["name"]);

    // ⚠️ Rentan - Tidak ada validasi MIME, ukuran, nama file
    if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
        $_SESSION['pesanan']['bukti'] = $target_file;
        header("Location: konfirmasi.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Upload Bukti Pembayaran</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <style>
    body {
      background: #fdf8f4;
      font-family: 'Poppins', sans-serif;
      color: #4b2e2e;
    }
    .card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      padding: 2rem;
      margin-top: 5vh;
    }
    label {
      margin-top: 1rem;
    }
    .btn-warning {
      background-color: #e5a100;
      border: none;
      border-radius: 8px;
    }
    .btn-warning:hover {
      background-color: #d18f00;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center">
    <div class="card w-100" style="max-width: 500px;">
      <h3 class="mb-3">Upload Bukti Pembayaran</h3>

      <p><strong>Nama:</strong> <?= htmlspecialchars($pesanan['nama']) ?></p>
      <p><strong>Kafe:</strong> <?= htmlspecialchars($pesanan['kafe']) ?></p>
      <p><strong>Menu:</strong> <?= htmlspecialchars($pesanan['menu']) ?></p>
      <p><strong>Jumlah:</strong> <?= htmlspecialchars($pesanan['jumlah']) ?></p>
      <p><strong>Metode:</strong>
        <?= isset($pesanan['metode']) ? htmlspecialchars($pesanan['metode']) : '<i>(tidak tersedia)</i>' ?>
      </p>

      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="bukti">Upload Bukti (gambar/file apapun):</label>
          <input type="file" name="bukti" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning w-100 mt-4">Upload Tanpa Validasi</button>
      </form>
    </div>
  </div>
</body>
</html>
