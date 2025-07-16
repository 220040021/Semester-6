<?php
session_start();
$username = isset($_SESSION["user"]) ? $_SESSION["user"] : "Guest";

// Ambil daftar kafe dari kafe.json
$kafeData = [];
if (file_exists('kafe.json')) {
  $kafeData = json_decode(file_get_contents('kafe.json'), true);
}
?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="UTF-8">
  <title>Dashboard KopiDulu</title>
  <link rel="shortcut icon" href="img/fav.png">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
  <link rel="stylesheet" href="css/linearicons.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/nice-select.css">
  <link rel="stylesheet" href="css/animate.min.css">
  <link rel="stylesheet" href="css/owl.carousel.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>

<!-- Header -->
<header id="header" id="home">
  <div class="header-top">
    <div class="container">
      <div class="row justify-content-end">
        <div class="col-lg-8 col-sm-4 col-8 header-top-right no-padding">
          <ul>
            <li>Mon-Fri: 8am to 2pm</li>
            <li>Sat-Sun: 11am to 4pm</li>
            <li><a href="tel:(012) 6985 236 7512">(012) 6985 236 7512</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row align-items-center justify-content-between d-flex">
      <div class="d-flex align-items-center">
        <p style="margin: 0; font-weight: bold; color: #fff; margin-right: 15px;">👤 <?= htmlspecialchars($username) ?></p>
        <div id="logo"><a href="index.php"><img src="img/logo.png" alt="Logo" title="" /></a></div>
      </div>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#home">Home</a></li>
          <li><a href="#kafe">Kafe</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#review">Review</a></li>
          <li><a href="#blog">Blog</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.html">Register</a></li>
        </ul>
      </nav>
    </div>
  </div>
</header>

<!-- Banner -->
<section class="banner-area" id="home">
  <div class="container">
    <div class="row fullscreen d-flex align-items-center justify-content-start">
      <div class="banner-content col-lg-7">
        <h6 class="text-white text-uppercase">Now you can feel the Energy</h6>
        <h1>Start your day with <br>a black Coffee</h1>
        <a href="#kafe" class="primary-btn text-uppercase">Pilih Kafe</a>
      </div>
    </div>
  </div>
</section>

<!-- START SECTION: Kafe Dinamis dari kafe.json -->
<section class="menu-area section-gap" id="kafe">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="menu-content pb-40 col-lg-10">
        <div class="title text-center">
          <h1 class="mb-10">☕ Pilih Brand Kopi Favoritmu</h1>
          <p>Temukan kafe terbaik untuk pesan kopi favoritmu</p>
        </div>
      </div>
    </div>

    <div class="row">
      <?php if (empty($kafeData)): ?>
        <div class="col-12"><p>Belum ada kafe yang terdaftar.</p></div>
      <?php else: ?>
        <?php foreach ($kafeData as $kafe): ?>
          <div class="col-md-4 mb-4">
            <div class="text-center p-3" style="background: #fff; border-radius: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
              <a href="menu.php?kafe=<?= urlencode($kafe['nama']) ?>">
                <img src="<?= htmlspecialchars($kafe['logo']) ?>" alt="<?= htmlspecialchars($kafe['nama']) ?>" style="width: 120px; height: 120px; object-fit: contain; border-radius: 12px;">
                <p class="mt-2" style="font-weight: 600;"><?= htmlspecialchars($kafe['nama']) ?></p>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
<!-- END SECTION -->

<!-- Footer -->
<footer class="footer-area section-gap">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-md-6 col-sm-6">
        <div class="single-footer-widget">
          <h6>About Us</h6>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
      </div>
      <div class="col-lg-5 col-md-6 col-sm-6">
        <div class="single-footer-widget">
          <h6>Newsletter</h6>
          <p>Stay update with our latest</p>
          <form class="form-inline">
            <input class="form-control" name="EMAIL" placeholder="Enter Email" required type="email">
            <button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right"></i></button>
          </form>
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-6 social-widget">
        <div class="single-footer-widget">
          <h6>Follow Us</h6>
          <div class="footer-social d-flex align-items-center">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-dribbble"></i></a>
            <a href="#"><i class="fa fa-behance"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="js/vendor/jquery-2.2.4.min.js"></script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>