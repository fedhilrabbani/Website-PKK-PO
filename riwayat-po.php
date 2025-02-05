<?php
include "CODES/BACKEND/db.php";
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'] ?? 'Guest';

// Fungsi untuk mengambil riwayat pre-order berdasarkan username
function getRiwayatPreOrder($db, $username) {
    $riwayat = [];
    
    $sql = "SELECT 
                id_pre_order, 
                nama_product, 
                status, 
                order_date, 
                quantity, 
                total_price, 
                keterangan,
                kelas
            FROM pre_orders 
            WHERE username = ? 
            ORDER BY order_date DESC";
    
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $riwayat[] = $row;
    }

    return $riwayat;
}

// Ambil riwayat pre-order
$riwayatPreOrder = getRiwayatPreOrder($db, $username);

// Fungsi untuk mendapatkan status dengan warna yang sesuai
function getStatusClass($status) {
    switch ($status) {
        case 'pending':
            return 'status-pending';
        case 'confirmed':
            return 'status-confirmed';
        case 'canceled':
            return 'status-canceled';
        default:
            return 'status-default';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pre-Order</title>
    <link rel="stylesheet" href="CODES/CSS/riwayat-preorder-styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
</head>
<body>
        <header class="header">
            <div class="logo-container">
                <img src="assets/images/icon.png" alt="Logo" class="logo">
                <h1 class="logo-text">Marketopia !</h1>
            </div>
            <nav class="menu">
                <a href="dashboard.php" class="menu-link"><i class="fas fa-home"></i></a>
                <a href="carts-pages.php" class="menu-link"><i class="fas fa-shopping-cart"></i></a>
            </nav>
        </header>
    <div class="container">
        <header>
            <div class="kontainer-header">
            </div>
        </header>

        <div class="riwayat-preorder-container">
            <div class="header-riwayat">
                <h2>Riwayat Pre-Order</h2>
                <p style="font-size:1.15rem;">Selamat datang, <?= htmlspecialchars($username) ?></p>
            </div>

            <?php if (empty($riwayatPreOrder)): ?>
                <div class="pesan-kosong">
                    <p >Anda belum memiliki riwayat pre-order.</p>
                </div>
            <?php else: ?>
                <div class="daftar-riwayat">
                    <?php foreach ($riwayatPreOrder as $preOrder): ?>
                        <div class="kartu-riwayat">
                            <div class="header-pesanan">
                                <h3>Pre-Order #<?= $preOrder['id_pre_order'] ?></h3>
                            </div>

                            <div class="detail-pesanan">
                                <div class="informasi-produk">
                                    <p><strong>Produk:</strong> <?= htmlspecialchars($preOrder['nama_product']) ?></p>
                                    <p><strong>Jumlah:</strong> <?= $preOrder['keterangan'] ?></p>
                                    <p><strong>Total Harga:</strong> Rp. <?= number_format($preOrder['total_price'], 0, ',', '.') ?></p>
                                    <p><strong>Kelas:</strong> <?= htmlspecialchars($preOrder['kelas'] ?? 'Tidak Diketahui') ?></p>
                                </div>

                            </div>
                        </div>
                        <hr><hr>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    function lihatDetailPreOrder(idPreOrder) {
        // Redirect atau tampilkan modal detail pre-order
        window.location.href = `detail-preorder.php?id=${idPreOrder}`;
    }
    </script>
</body>
</html>