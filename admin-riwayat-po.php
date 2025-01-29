<?php
include "CODES/BACKEND/db.php";
session_start();

// Periksa apakah pengguna sudah login dan memiliki hak akses admin
if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true || $_SESSION["role"] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Fungsi untuk mengambil semua riwayat pre-order
// Fungsi untuk mengambil semua riwayat pre-order
function getAllRiwayatPreOrder($db) {
    $riwayat = [];
    
    $sql = "SELECT 
                id_pre_order, 
                username,
                nama_product, 
                status, 
                order_date, 
                quantity, 
                total_price, 
                keterangan,
                kelas
            FROM pre_orders 
            ORDER BY 
                CASE 
                    WHEN status = 'confirmed' THEN 1 
                    ELSE 0 
                END, 
                order_date DESC";
    
    $result = $db->query($sql);

    while ($row = $result->fetch_assoc()) {
        $riwayat[] = $row;
    }

    return $riwayat;
}

// Ambil semua riwayat pre-order
$riwayatPreOrder = getAllRiwayatPreOrder($db);

// Fungsi untuk mendapatkan status dengan warna yang sesuai
function getStatusClass($status) {
    switch ($status) {
        case 'pending':
            return 'status-pending';
        case 'confirmed':
            return 'status-confirmed';
        default:
            return 'status-default';
    }
}

// Proses konfirmasi status jika ada permintaan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pre_order'])) {
    $idPreOrder = $_POST['id_pre_order'];
    
    // Cek apakah status yang ingin diubah adalah 'pending' atau 'confirmed'
    if (isset($_POST['action']) && $_POST['action'] === 'confirm') {
        $newStatus = 'confirmed'; // Status baru yang ingin diatur
    } elseif (isset($_POST['action']) && $_POST['action'] === 'pending') {
        $newStatus = 'pending'; // Kembali ke status pending
    }

    // Update status di database
    $updateSql = "UPDATE pre_orders SET status = ? WHERE id_pre_order = ?";
    $stmt = $db->prepare($updateSql);
    $stmt->bind_param("si", $newStatus, $idPreOrder);
    $stmt->execute();

    // Redirect kembali ke halaman ini
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pre-Order Admin</title>
    <link rel="stylesheet" href="CODES/CSS/admin-riwayat-preorder-styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
    <style>
        html {
            scroll-behavior: smooth;
        }
        .search-container {
            margin: 20px 0;
        }
        .search-container input {
            padding: 10px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-confirm, .btn-pending {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            margin-top: 5px;
        }
        .btn-confirm:hover, .btn-pending:hover {
            background-color: #218838;
        }
        .btn-pending {
            background-color: #ffc107;
        }
        .btn-pending:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <a href="admin-dashboard.php"><img src="assets/images/icon.png" alt="Logo" class="logo"></a>
            <h1 class="logo-text">Marketopia Admin</h1>
        </div>
    </header>
    <div class="container">
        <div class="riwayat-preorder-container">
            <div class="header-riwayat">
                <h2>Riwayat Pre-Order</h2>
                <p style="font-size:1.15rem;">Selamat datang, Admin</p>
                
                <!-- Form Pencarian -->
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan produk, username, atau status" onkeyup="filterResults()">
                </div>
                <a href="#bottom" id="top" style="border: 2px solid gray;padding: 5px;border-radius:10px;text-decoration:none;color:grey">Ke Bawah</a>
            </div>

            <?php if (empty($riwayatPreOrder)): ?>
    <div class="pesan-kosong">
        <p>Belum ada riwayat pre-order.</p>
    </div>
<?php else: ?>
    <div class="daftar-riwayat" id="riwayatList">
        <?php foreach ($riwayatPreOrder as $preOrder): ?>
            <div class="kartu-riwayat">
                <div class="header-pesanan">
                    <h3>Pre-Order #<?= $preOrder['id_pre_order'] ?></h3>
                    <p><strong>Username:</strong> <?= htmlspecialchars($preOrder['username']) ?></p>
                </div>

                <div class="detail-pesanan">
                    <div class="informasi-produk">
                        <p><strong>Produk:</strong> <?= htmlspecialchars($preOrder['nama_product']) ?></p>
                        <p><strong>Status:</strong> <span class="<?= getStatusClass($preOrder['status']) ?>"><?= htmlspecialchars($preOrder['status']) ?></span></p>
                        <p><strong>Jumlah:</strong> <?= htmlspecialchars($preOrder['keterangan']) ?></p>
                        <p><strong>Total Harga:</strong> Rp. <?= number_format($preOrder['total_price'], 0, ',', '.') ?></p>
                        <p><strong>Kelas:</strong> <?= htmlspecialchars($preOrder['kelas'] ?? 'Tidak Diketahui') ?></p>
                    </div>
                </div>
                <!-- Tombol Konfirmasi dan Kembali ke Pending -->
                <form method="POST" action="">
                    <input type="hidden" name="id_pre_order" value="<?= $preOrder['id_pre_order'] ?>">
                    <?php if ($preOrder['status'] === 'pending'): ?>
                        <button type="submit" name="action" value="confirm" class="btn-confirm">Konfirmasi</button>
                    <?php elseif ($preOrder['status'] === 'confirmed'): ?>
                        <button type="submit" name="action" value="pending" class="btn-pending">Kembali ke Pending</button>
                    <?php endif; ?>
                </form>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
        <a href="#top" id="bottom" style="border: 2px solid gray;padding: 5px;border-radius:10px;text-decoration:none;color:grey;position:relative;bottom:-15px;">Ke Atas</a>
        </div>
    </div>

    <script>
    function filterResults() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const riwayatList = document.getElementById('riwayatList');
        const kartuRiwayat = riwayatList.getElementsByClassName('kartu-riwayat');

        for (let i = 0; i < kartuRiwayat.length; i++) {
            const header = kartuRiwayat[i].getElementsByClassName('header-pesanan')[0];
            const produk = kartuRiwayat[i].getElementsByClassName('informasi-produk')[0];
            const username = header.getElementsByTagName('p')[0].innerText.toLowerCase();
            const namaProduct = produk.getElementsByTagName('p')[0].innerText.toLowerCase();
            const status = produk.getElementsByTagName('p')[1].innerText.toLowerCase();

            if (username.includes(filter) || namaProduct.includes(filter) || status.includes(filter)) {
                kartuRiwayat[i].style.display = "";
            } else {
                kartuRiwayat[i].style.display = "none";
            }
        }
    }
    </script>
</body>
</html>