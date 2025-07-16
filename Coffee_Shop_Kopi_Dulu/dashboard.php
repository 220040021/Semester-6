<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit;
}
echo "Selamat datang, " . $_SESSION["user"];
?>