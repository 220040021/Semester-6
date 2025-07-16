<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'admin') {
    echo "Akses ditolak.";
    exit;
}

$index = isset($_GET['index']) ? (int)$_GET['index'] : -1;
$kafeFile = 'kafe.json';

if (!file_exists($kafeFile)) {
    echo "Data kafe tidak ditemukan.";
    exit;
}

$dataKafe = json_decode(file_get_contents($kafeFile), true);

if (!isset($dataKafe[$index])) {
    echo "Index tidak valid.";
    exit;
}

$kafe = $dataKafe[$index];

// Hapus mitra jika diminta
if (isset($_GET['hapus']) && $_GET['hapus'] === '1') {
    // Hapus gambar
    if (!empty($kafe['logo']) && file_exists($kafe['logo'])) {
        unlink($kafe['logo']);
    }

    // Hapus dari database (opsional - sesuaikan nama kolom di database jika diperlukan)
    include "db_config.php";
    $username = mysqli_real_escape_string($conn, $kafe['username']);
    mysqli_query($conn, "DELETE FROM users WHERE username='$username'");

    // Hapus dari JSON
    array_splice($dataKafe, $index, 1);
    file_put_contents($kafeFile, json_encode($dataKafe, JSON_PRETTY_PRINT));

    header("Location: admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kafe = $_POST['nama_kafe'];
    $username = $_POST['username_kafe'];
    $logoLama = $kafe['logo'];
    $logoBaru = $logoLama;

    if (isset($_FILES['logo_kafe']) && $_FILES['logo_kafe']['error'] === UPLOAD_ERR_OK) {
        $target_dir = 'img/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $ext = pathinfo($_FILES['logo_kafe']['name'], PATHINFO_EXTENSION);
        $newFile = uniqid('logo_') . '.' . $ext;
        $target_file = $target_dir . $newFile;

        if (move_uploaded_file($_FILES['logo_kafe']['tmp_name'], $target_file)) {
            if (file_exists($logoLama)) unlink($logoLama);
            $logoBaru = $target_file;
        }
    }

    $dataKafe[$index] = [
        'nama' => $nama_kafe,
        'username' => $username,
        'logo' => $logoBaru
    ];
    file_put_contents($kafeFile, json_encode($dataKafe, JSON_PRETTY_PRINT));
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Kafe</title>
  <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Kafe</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label>Nama Kafe:</label>
      <input type="text" name="nama_kafe" class="form-control" value="<?= htmlspecialchars($kafe['nama']) ?>" required>
    </div>
    <div class="form-group">
      <label>Username Mitra:</label>
      <input type="text" name="username_kafe" class="form-control" value="<?= htmlspecialchars($kafe['username']) ?>" required>
    </div>
    <div class="form-group">
      <label>Logo Saat Ini:</label><br>
      <img src="<?= htmlspecialchars($kafe['logo']) ?>" width="100" alt="Logo">
    </div>
    <div class="form-group">
      <label>Ganti Logo (opsional):</label>
      <input type="file" name="logo_kafe" class="form-control-file" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="admin.php" class="btn btn-secondary">Batal</a>
    <a href="edit_kafe.php?index=<?= $index ?>&hapus=1" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus mitra ini?')">🗑 Hapus Mitra</a>
  </form>
</div>
</body>
</html>
