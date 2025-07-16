<?php
include "db_config.php";
session_start();

// Validasi admin
if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'admin') {
    echo "Akses ditolak. Halaman ini hanya untuk admin.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <style>
    body {
      background: #fdf8f4;
      font-family: 'Poppins', sans-serif;
      color: #4b2e2e;
      padding: 2rem;
    }
    h2 {
      margin-top: 2rem;
    }
    .table img {
      border-radius: 8px;
    }
    .form-section {
      background: #fff;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 3rem;
    }
    .btn-primary {
      background-color: #a65c38;
      border: none;
    }
    .btn-primary:hover {
      background-color: #8e4d2c;
    }
  </style>
</head>
<body>

  <h2>Panel Admin - Data Pengguna</h2>
  <?php
  $result = mysqli_query($conn, "SELECT * FROM users");
  if ($result): ?>
    <table class="table table-bordered table-striped">
      <thead class="table-light">
        <tr><th>ID</th><th>Username</th><th>Password</th><th>Role</th></tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['password']) ?></td>
          <td><?= htmlspecialchars($row['role']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-danger">❌ Gagal mengambil data pengguna.</p>
  <?php endif; ?>

  <hr>
  <h2>Tambah Kafe Baru + Akun Mitra</h2>
  <div class="form-section">
    <form action="tambah_kafe.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Nama Kafe:</label>
        <input type="text" name="nama_kafe" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Logo Kafe (Upload Gambar):</label>
        <input type="file" name="logo_kafe" class="form-control" accept="image/*" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Username Mitra:</label>
        <input type="text" name="username_kafe" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password Mitra:</label>
        <input type="text" name="password_kafe" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">➕ Tambah Kafe + Akun Mitra</button>
    </form>
  </div>

  <?php if (file_exists('kafe.json')): ?>
    <hr>
    <h2>Daftar Kafe Mitra</h2>
    <?php $dataKafe = json_decode(file_get_contents('kafe.json'), true); ?>
    <table class="table table-bordered">
      <thead class="table-light">
        <tr><th>Nama Kafe</th><th>Logo</th><th>Username</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($dataKafe as $i => $kafe): ?>
          <tr>
            <td><?= htmlspecialchars($kafe['nama']) ?></td>
            <td><img src="<?= htmlspecialchars($kafe['logo']) ?>" width="80"></td>
            <td><?= htmlspecialchars($kafe['username']) ?></td>
            <td><a href="edit_kafe.php?index=<?= $i ?>" class="btn btn-sm btn-outline-secondary">✏️ Edit</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <a href="index.php" class="btn btn-link mt-4">← Kembali ke Beranda</a>
</body>
</html>
