<?php
session_start();
$kafe = isset($_GET['kafe']) ? $_GET['kafe'] : 'Tidak diketahui';
$menu = isset($_GET['menu']) ? $_GET['menu'] : 'Tidak diketahui';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Pesan <?= htmlspecialchars($menu) ?> - <?= htmlspecialchars($kafe) ?></title>
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
    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid #d6a076;
    }
    .btn-primary {
      background-color: #a65c38;
      border: none;
      border-radius: 8px;
    }
    .btn-primary:hover {
      background-color: #8e4d2c;
    }
    .qris-img {
      width: 200px;
      border-radius: 8px;
      border: 1px solid #ddd;
    }
    label {
      margin-top: 1rem;
    }
  </style>
</head>
<body>
<div class="container d-flex justify-content-center">
  <div class="card w-100" style="max-width: 500px;">
    <h3 class="mb-3">Pemesanan Kopi</h3>
    <p><strong>Kafe:</strong> <?= htmlspecialchars($kafe) ?></p>
    <p><strong>Menu:</strong> <?= htmlspecialchars($menu) ?></p>

    <form action="proses_order.php" method="POST">
      <input type="hidden" name="kafe" value="<?= htmlspecialchars($kafe) ?>">
      <input type="hidden" name="menu" value="<?= htmlspecialchars($menu) ?>">

      <label>Nama Pemesan:</label>
      <input type="text" name="nama" class="form-control" required>

      <label>Jumlah:</label>
      <input type="number" name="jumlah" class="form-control" required min="1">

      <label>Metode Pembayaran:</label>
      <select name="metode" class="form-select" id="metodePembayaran" required onchange="toggleQR()">
        <option value="">-- Pilih --</option>
        <option value="qris">QRIS (Scan QR)</option>
        <option value="transfer">Transfer Bank</option>
        <option value="cod">Bayar di Tempat</option>
      </select>

      <div class="mt-3" id="qrisSection" style="display:none;">
        <label>Scan QR Code:</label><br>
        <img src="img/qris_dummy.jpeg" alt="QRIS" class="qris-img">
        <p class="text-muted"><small>Scan dengan aplikasi e-wallet Anda.</small></p>
      </div>

      <button type="submit" class="btn btn-primary w-100 mt-4">Lanjutkan Pemesanan</button>
    </form>
  </div>
</div>

<script>
function toggleQR() {
  const metode = document.getElementById("metodePembayaran").value;
  document.getElementById("qrisSection").style.display = (metode === 'qris') ? 'block' : 'none';
}
</script>
</body>
</html>
