<?php
include "CODES/BACKEND/db.php";
session_start();

// Pastikan pengguna login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Ambil data pengguna berdasarkan ID
    $query = "SELECT username, kelas FROM users WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $userData = $stmt->get_result()->fetch_assoc();

    // Debug data untuk memastikan konsistensi
} else {
    echo "Pengguna belum login!";
    header('location: login.php'); // Redirect ke halaman login
    exit;
}
?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('order-summary-name').textContent = '<?php echo $userData["username"] ?? ""; ?>';
    document.getElementById('order-summary-kelas').textContent = '<?php echo $userData["kelas"] ?? ""; ?>';
});
</script>
?>

<script>

</script>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-Order - Jajan Yuk!</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="ASSETS/IMAGES/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="CODES/CSS/pre-order-pages-styles.css">
    <script src="CODES/JS/pre-order-pages-scripts.js" defer></script>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="logo-container">
                <img src="ASSETS/IMAGES/icon.png" alt="Logo" class="logo">
                <h1 class="logo-text">Jajan Yuk !</h1>
            </div>
            <nav class="menu">
                <a href="dashboard.php" class="menu-link"><i class="fas fa-home"></i></a>
                <a href="carts-pages.php" class="menu-link"><i class="fas fa-shopping-cart"></i></a>
                <a href="info-produk-pages.php" class="menu-link"><i class="fas fa-info-circle"></i></a>
            </nav>
        </header>

            <div id="order-summary" class="order-summary hidden">
                <h2>Rincian Pesanan</h2>
                <p><strong>Nama :</strong> <span id="order-summary-name"></span></p>
                <p><strong>Kelas :</strong> <span id="order-summary-kelas"></span></p>
                <div class="product-item">
                    <ul>
                        <li><strong>Produk Minuman :</strong> Rp 25,000</li>
                        <li><strong>Produk Makanan :</strong> Rp 50,000</li>
                    </ul>
                </div>
                <div class="total-harga">
                    <span>Total Harga : <strong>Rp 75,000</strong></span>
                </div>
                <button id="proceed-to-transaction" class="pay-button">Lanjutkan ke Transaksi</button>
</div>

            <div id="receipt" class="receipt hidden">
                <h2>Struk Pembayaran</h2>
                <p><strong>Nama :</strong> <span id="receipt-name"><?php echo htmlspecialchars($username); ?></span></p>
                <p><strong>Nomor Transaksi :</strong> <span id="receipt-transaction"></span></p>
                <p><strong>Tanggal :</strong> <span id="receipt-date"></span></p>
                <p><strong>Total Harga :</strong> Rp 75,000</p>
                <p><strong>Status :</strong> Lunas</p>
                <button id="new-order" class="new-order-button">Pesan Lagi</button>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; 2025 Jajan Yuk! All Rights Reserved.</p>
        </footer>
    </div>
</body>

</html>