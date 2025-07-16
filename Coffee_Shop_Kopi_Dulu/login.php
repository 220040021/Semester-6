<?php
session_start();
include "db_config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ⚠️ Untuk production, gunakan password_hash & prepared statement
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['user'] = $user['username'];
        $_SESSION['user_role'] = $user['role']; // bisa 'admin', 'mitra', atau 'user'

        // Arahkan sesuai role
        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } elseif ($user['role'] === 'mitra') {
            header("Location: mitra.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        echo "<p>Login gagal. Username atau password salah.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login Pengguna</title>
  <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
  <h2>Login</h2>
  <form method="POST">
    <div class="form-group">
      <label>Username:</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Password:</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>
</body>
</html>
