<?php
session_start();

$username = isset($_SESSION["user"]) ? $_SESSION["user"] : "Guest";
$kafe = isset($_GET['kafe']) ? $_GET['kafe'] : null;

if (!$kafe) {
  echo "<p>Kafe tidak ditemukan.</p>";
  exit;
}

$mitra_username = '';
if (file_exists('kafe.json')) {
  $kafeData = json_decode(file_get_contents('kafe.json'), true);
  foreach ($kafeData as $data) {
    if ($data['nama'] === $kafe) {
      $mitra_username = $data['username'];
      break;
    }
  }
}

$menu_kafe = [];
if ($mitra_username) {
  $menu_file = 'menu_' . $mitra_username . '.json';
  if (file_exists($menu_file)) {
    $menu_kafe = json_decode(file_get_contents($menu_file), true);
  }
}

$review_file = 'review_' . $mitra_username . '.json';
$all_reviews = file_exists($review_file) ? json_decode(file_get_contents($review_file), true) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Menu <?= htmlspecialchars($kafe) ?></title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <style>
    body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #fdf8f4; color: #4b2e2e; }
    .navbar { background-color: #f7e6dc; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0cfc2; }
    .navbar a { margin-left: 1rem; text-decoration: none; color: #4b2e2e; font-weight: 500; }
    .hero { background: #392a1d url('img/hero.jpg') no-repeat center; background-size: cover; color: white; text-align: center; padding: 80px 30px 60px; border-bottom-left-radius: 80px; border-bottom-right-radius: 80px; }
    .container { padding: 2rem; }
    .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; }
    .menu-card { background: #fff; border-radius: 16px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); height: 100%; display: flex; flex-direction: column; }
    .menu-img { width: 100%; height: 140px; object-fit: cover; border-radius: 10px; margin-bottom: 10px; }
    .rating-stars span { font-size: 1.2em; color: gold; }
    .rating-stars span.gray { color: #ccc; }
    .bg-light { background-color: #f9ece6 !important; border-left: 4px solid #d6a076; border-radius: 8px; padding: 10px; }
  </style>
</head>
<body>
  <div class="navbar">
    <div><strong>KopiDulu</strong></div>
    <div><a href="#">Home</a> <a href="#">Menu</a> <a href="#">Blog</a> <a href="#">Media</a> <a href="#">Contact</a></div>
  </div>
  <div class="hero">
    <h1>Freshly Roasted Coffee</h1>
    <p>Nikmati pilihan kopi terbaik dari <?= htmlspecialchars($kafe) ?></p>
  </div>
  <div class="container">
    <h4 class="mb-4">👤 Anda login sebagai: <strong><?= htmlspecialchars($username) ?></strong></h4>
    <div class="menu-grid">
      <?php foreach ($menu_kafe as $item): ?>
        <div class="menu-card">
          <?php if (!empty($item['gambar'])): ?>
            <img src="<?= htmlspecialchars($item['gambar']) ?>" class="menu-img" alt="Gambar Menu">
          <?php endif; ?>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5><?= htmlspecialchars($item['nama']) ?></h5>
            <span>Rp<?= number_format($item['harga'], 0, ',', '.') ?></span>
          </div>
          <div class="rating-stars mb-2">
            <?php
            $ratings = array_column(array_filter($all_reviews, fn($r) => isset($r['menu'], $r['rating']) && $r['menu'] === $item['nama']), 'rating');
            $avg = $ratings ? round(array_sum($ratings) / count($ratings)) : 0;
            for ($i = 1; $i <= 5; $i++) {
              echo '<span class="' . ($i <= $avg ? '' : 'gray') . '">★</span>';
            }
            ?>
          </div>
          <form action="order.php" method="GET">
            <input type="hidden" name="kafe" value="<?= htmlspecialchars($kafe) ?>">
            <input type="hidden" name="menu" value="<?= htmlspecialchars($item['nama']) ?>">
            <button type="submit" class="btn btn-success btn-sm">Pesan Sekarang</button>
          </form>

          <?php
          $firstReview = null;
          foreach ($all_reviews as $r) {
            if (isset($r['menu'], $r['komentar']) && $r['menu'] === $item['nama']) {
              $firstReview = $r;
              break;
            }
          }
          ?>
          <?php if ($firstReview): ?>
            <div class="bg-light mt-2">
              <strong><?= htmlspecialchars($firstReview['user'] ?? 'Anonim') ?>:</strong><br>
              <?= htmlspecialchars($firstReview['komentar']) ?><br>
              <small><?= htmlspecialchars($firstReview['waktu'] ?? '') ?></small>
            </div>
          <?php endif; ?>

          <button type="button" class="btn btn-link text-primary p-0 mt-2" data-bs-toggle="modal" data-bs-target="#reviewModal" onclick='loadReview(<?= json_encode(array_values(array_filter($all_reviews, fn($r) => isset($r["menu"]) && $r["menu"] === $item["nama"]))) ?>, <?= json_encode($item["nama"]) ?>)'>
            💬 Lihat semua review
          </button>

          <form method="POST" action="review_handler.php" class="mt-2">
            <input type="hidden" name="kafe" value="<?= htmlspecialchars($kafe) ?>">
            <input type="hidden" name="menu" value="<?= htmlspecialchars($item['nama']) ?>">
            <div class="form-group">
              <label>Rating:</label><br>
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <label><input type="radio" name="rating" value="<?= $i ?>" required> <?= $i ?></label>
              <?php endfor; ?>
            </div>
            <div class="form-group">
              <label>Komentar:</label>
              <textarea name="komentar" class="form-control" rows="2" required></textarea>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-sm mt-2">Kirim Review</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Modal Review -->
  <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reviewModalLabel">Semua Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body" id="modalReviewContent">
          <p>Memuat review...</p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function loadReview(reviews, menu) {
      const container = document.getElementById("modalReviewContent");
      let html = `<h6>Review untuk: <strong>${menu}</strong></h6><hr>`;
      if (reviews.length === 0) {
        html += "<p>Belum ada review untuk menu ini.</p>";
      } else {
        reviews.forEach(r => {
          const bintang = "⭐".repeat(parseInt(r.rating || 0));
          html += `<div style="border-bottom:1px solid #ddd;padding:8px 0">
            <strong>${r.user || "Anonim"}</strong> <span style="color:gold">${bintang}</span><br>
            <div>${r.komentar || "-"}</div>
            <small class="text-muted">${r.waktu || ""}</small>
          </div>`;
        });
      }
      container.innerHTML = html;
    }
  </script>
</body>
</html>
