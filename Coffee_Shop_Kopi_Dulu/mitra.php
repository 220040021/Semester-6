<?php
session_start();
include "db_config.php";

if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'mitra') {
    echo "Akses ditolak. Halaman ini hanya untuk mitra.";
    exit;
}

$username = $_SESSION['user'];
$menuFile = 'menu_' . $username . '.json';
$reviewFile = 'review_' . $username . '.json';

// Hapus menu jika diminta
if (isset($_GET['hapus'])) {
    $hapusIndex = (int)$_GET['hapus'];
    if (file_exists($menuFile)) {
        $menus = json_decode(file_get_contents($menuFile), true);
        if (isset($menus[$hapusIndex])) {
            array_splice($menus, $hapusIndex, 1);
            file_put_contents($menuFile, json_encode($menus, JSON_PRETTY_PRINT));
        }
    }
    header("Location: mitra.php");
    exit;
}

// Hapus review jika diminta
if (isset($_GET['hapus_review'])) {
    $hapusReviewIndex = (int)$_GET['hapus_review'];
    if (file_exists($reviewFile)) {
        $reviews = json_decode(file_get_contents($reviewFile), true);
        if (isset($reviews[$hapusReviewIndex])) {
            array_splice($reviews, $hapusReviewIndex, 1);
            file_put_contents($reviewFile, json_encode($reviews, JSON_PRETTY_PRINT));
        }
    }
    header("Location: mitra.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard Mitra</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <style>
    body {
      background-color: #fdf8f4;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 2rem;
    }
    h2, h4 {
      color: #4b2e2e;
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
<div class="container mt-5">
  <div class="card">
    <h2>Selamat Datang, <?= htmlspecialchars($username) ?>!</h2>
    <p>Gunakan form di bawah untuk menambahkan menu kopi baru.</p>

    <form action="tambah_menu.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Nama Menu:</label>
        <input type="text" name="nama_menu" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Harga:</label>
        <input type="number" name="harga" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Upload Gambar:</label>
        <input type="file" name="gambar" accept="image/*" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Tambah Menu</button>
    </form>
  </div>

  <div class="card">
    <h4>Menu Anda</h4>
    <?php
    if (file_exists($menuFile)) {
        $menus = json_decode(file_get_contents($menuFile), true);
        if (!empty($menus)) {
            echo "<ul class='list-group'>";
            foreach ($menus as $i => $menu) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                echo htmlspecialchars($menu['nama']) . " - Rp" . number_format($menu['harga']);
                echo "<span>";
                echo "<a href='edit_menu.php?index=$i' class='btn btn-warning btn-sm me-2'>Edit</a>";
                echo "<a href='mitra.php?hapus=$i' onclick=\"return confirm('Hapus menu ini?')\" class='btn btn-danger btn-sm'>Hapus</a>";
                echo "</span></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Belum ada menu.</p>";
        }
    } else {
        echo "<p>Belum ada menu.</p>";
    }
    ?>
  </div>

  <div class="card">
    <h4>Review dari Pelanggan</h4>
    <?php
    if (file_exists($reviewFile)) {
        $reviews = json_decode(file_get_contents($reviewFile), true);
        if (!empty($reviews)) {
            echo "<ul class='list-group'>";
            foreach ($reviews as $i => $r) {
                echo "<li class='list-group-item'>";
                echo "<strong>Menu:</strong> " . htmlspecialchars($r['menu']) . "<br>";
                echo "<strong>User:</strong> " . htmlspecialchars($r['user']) . "<br>";
                echo "<strong>Komentar:</strong><br>" . htmlspecialchars($r['komentar']) . "<br>";
                echo "<small>Waktu: " . htmlspecialchars($r['waktu']) . "</small><br>";
                echo "<a href='mitra.php?hapus_review=$i' class='btn btn-sm btn-danger mt-1'>Hapus</a>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Belum ada komentar/review.</p>";
        }
    } else {
        echo "<p>Belum ada komentar/review.</p>";
    }
    ?>
    <a href="semua_review.php" class="btn btn-outline-primary mt-3">📋 Lihat Semua Komentar</a>
  </div>
</div>
</body>
</html>
