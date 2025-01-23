<?php
include "CODES/BACKEND/db.php";
session_start();

if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true) {
    header("Location: index.php");
    exit;
    }

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

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Retrieve pre-order details
if (isset($_GET['id'])) {
    $preorder_id = intval($_GET['id']);
    
    // Fetch pre-order details
    $sql_preorder = "SELECT * FROM pre_orders WHERE id_pre_order = ?";
    $stmt_preorder = $db->prepare($sql_preorder);
    $stmt_preorder->bind_param("i", $preorder_id);
    $stmt_preorder->execute();
    $result_preorder = $stmt_preorder->get_result();
    
    if ($result_preorder->num_rows > 0) {
        $preorder = $result_preorder->fetch_assoc();
        
        // Gunakan username dari tabel pre_orders
        $username = $preorder['username'];
        
        // Fetch user details (misalkan ada relasi user dengan username)
        $sql_user = "SELECT kelas FROM users WHERE username = ?";
        $stmt_user = $db->prepare($sql_user);
        $stmt_user->bind_param("s", $username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
        } else {
            $user = ['kelas' => 'Tidak Diketahui'];
        }
    } else {
        die("Pre-order not found");
    }
} else {
    die("No pre-order ID provided");
}

?>



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

    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('order-summary-name').textContent = '<?php echo $userData["username"] ?? ""; ?>';
    document.getElementById('order-summary-kelas').textContent = '<?php echo $userData["kelas"] ?? ""; ?>';
});
</script>
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
            </nav>
        </header>

        <div id="order-summary" class="order-summary">
    <h2>Rincian Pesanan</h2>
    <p><strong>Nama :</strong> <?php echo htmlspecialchars($username); ?></p>
    <p><strong>Kelas :</strong> <?php echo htmlspecialchars($user['kelas']); ?></p>


      <div class="product-item">
        <ul>
            <li><strong>Produk :</strong> <?php echo htmlspecialchars($preorder['nama_product']); ?></li>
            <li><strong>Jumlah :</strong> <?php echo intval($preorder['quantity']); ?></li>
        </ul>
    </div>
    <div class="total-harga">
        <span>Total Harga : <strong>Rp <?php echo number_format($preorder['total_price'], 0, ',', '.'); ?></strong></span>
    </div>
    <button id="proceed-to-transaction" class="pay-button">Silahkan Datang ke ruang D1 pada 30 Januari 2025</button>
</div>
        </main>

        <footer class="footer">
            <p>&copy; 2025 Jajan Yuk! All Rights Reserved.</p>
        </footer>
    </div>
</body>

</html>