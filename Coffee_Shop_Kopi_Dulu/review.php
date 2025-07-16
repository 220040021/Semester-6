<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $pesan = $_POST['pesan'];

    $baris = "<strong>$nama:</strong> $pesan\n";

    file_put_contents("reviews.txt", $baris, FILE_APPEND);

    header("Location: review.html");
    exit;
}
?>
