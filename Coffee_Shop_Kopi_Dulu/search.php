<?php
$q = $_GET['q'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Hasil Pencarian</title>
</head>
<body>
  <h2>Hasil Pencarian Menu</h2>

  <p>Anda mencari: <strong><?= $q ?></strong></p>

  <p><a href="index.php">Kembali ke Beranda</a></p>
</body>
</html>
