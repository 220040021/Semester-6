<?php
include "db_config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ⚠️ Menyimpan password secara plaintext (vulnerable - untuk uji pentest)
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<p>Pendaftaran berhasil. <a href='login.html'>Login sekarang</a>.</p>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
