<?php
echo "<h2>Riwayat Pemesanan Kopi</h2>";

if (file_exists("pesanan.txt")) {
    $pesanan = file("pesanan.txt");
    echo "<ul>";
    foreach ($pesanan as $item) {
        echo "<li>" . htmlspecialchars($item) . "</li>";
    }
    echo "</ul>";
} else {
    echo "Belum ada pesanan yang tercatat.";
}

echo "<p><a href='index.php'>Kembali ke beranda</a></p>";
?>
