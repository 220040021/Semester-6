<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'mitra') {
    echo "Akses ditolak. Hanya mitra yang dapat mengedit menu.";
    exit;
}

$username = $_SESSION['user'];
$menuFile = 'menu_' . $username . '.json';
$index = isset($_GET['index']) ? (int)$_GET['index'] : -1;

if (!file_exists($menuFile)) {
    echo "Menu tidak ditemukan.";
    exit;
}

$menus = json_decode(file_get_contents($menuFile), true);

if (!isset($menus[$index])) {
    echo "Index menu tidak valid.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_menu']);
    $harga = trim($_POST['harga']);
    $gambarLama = $menus[$index]['gambar'] ?? '';
    $gambarBaru = $gambarLama;

    // Proses upload gambar baru (jika ada)
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('kopi_') . '.' . strtolower($ext);
        $targetFile = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            // Hapus gambar lama jika ada
            if (!empty($gambarLama) && file_exists($gambarLama)) {
                unlink($gambarLama);
            }
            $gambarBaru = $targetFile;
        }
    }

    if ($nama && $harga) {
        $menus[$index]['nama'] = $nama;
        $menus[$index]['harga'] = (int)$harga;
        $menus[$index]['gambar'] = $gambarBaru;
        file_put_contents($menuFile, json_encode($menus, JSON_PRETTY_PRINT));
        header("Location: mitra.php");
        exit;
    } else {
        echo "<p>Semua field wajib diisi.</p>";
    }
}

$menu = $menus[$index];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Menu</title>
  <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Menu</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label>Nama Menu:</label>
      <input type="text" name="nama_menu" class="form-control" value="<?= htmlspecialchars($menu['nama']) ?>" required>
    </div>
    <div class="form-group">
      <label>Harga:</label>
      <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($menu['harga']) ?>" required>
    </div>
    <div class="form-group">
      <label>Gambar Saat Ini:</label><br>
      <?php if (!empty($menu['gambar']) && file_exists($menu['gambar'])): ?>
        <img src="<?= htmlspecialchars($menu['gambar']) ?>" width="150" class="mb-2"><br>
      <?php endif; ?>
      <label>Ganti Gambar (opsional):</label>
      <input type="file" name="gambar" class="form-control-file" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="mitra.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</body>
</html>
