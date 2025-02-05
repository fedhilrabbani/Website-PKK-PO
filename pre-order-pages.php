<?php
include "CODES/BACKEND/db.php";
session_start();

if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true) {
    header("Location: index.php");
    exit;
    }

// Pastikan pengguna login
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
        
        // Fetch user details
        $sql_user = "SELECT kelas FROM users WHERE username = ?";
        $stmt_user = $db->prepare($sql_user);
        $stmt_user->bind_param("s", $username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $kelas = $user['kelas'];
        } else {
            $kelas = 'Tidak Diketahui';
        }

        // Proses kuantitas sebelumnya
        $previous_quantities = [];
        $product_names = explode(', ', $preorder['nama_product']);

        // Siapkan string keterangan dengan format baru
        $keterangan_parts = [];
        
        foreach ($product_names as $product_name) {
            $trimmed_product_name = trim($product_name);

            // Cari ID produk di tabel foods
            $sql_product = "SELECT foods_id FROM foods WHERE nama = ?";
            $stmt_product = $db->prepare($sql_product);
            $stmt_product->bind_param("s", $trimmed_product_name);
            $stmt_product->execute();
            $result_product = $stmt_product->get_result();

            if ($result_product->num_rows > 0) {
                $product_data = $result_product->fetch_assoc();
                $product_id = $product_data['foods_id'];

                // Cari kuantitas di session
                $previous_quantity = 0;
                if (isset($_SESSION['previous_cart_quantities'][$product_id])) {
                    $previous_quantity = $_SESSION['previous_cart_quantities'][$product_id]['quantity_total'];
                }

                // Tambahkan ke array keterangan dengan format baru
                $keterangan_parts[] = $trimmed_product_name . "(" . $previous_quantity . ")";

                $previous_quantities[$trimmed_product_name] = $previous_quantity;
            } else {
                $previous_quantities[$trimmed_product_name] = 'Produk Tidak Ditemukan';
                $keterangan_parts[] = $trimmed_product_name . "(Tidak Diketahui)";
            }
        }

        // Gabungkan bagian keterangan
        $keterangan = implode(', ', $keterangan_parts);

        // Update pre_order dengan keterangan
        $sql_update = "UPDATE pre_orders SET keterangan = ? WHERE id_pre_order = ?";
        $stmt_update = $db->prepare($sql_update);
        $stmt_update->bind_param("si", $keterangan, $preorder_id);
        $stmt_update->execute();

        // Refresh data preorder setelah update
        $result_preorder = $db->query("SELECT * FROM pre_orders WHERE id_pre_order = $preorder_id");
        $preorder = $result_preorder->fetch_assoc();
    } else {
        die("Pre-order not found");
    }
} else {
    die("No pre-order ID provided");
}

// Untuk menampilkan di halaman
$previous_quantities_display = [];
$sql_previous = "SELECT product_name, previous_quantity, username, kelas 
                 FROM pre_order_detail 
                 WHERE pre_order_id = ?";
$stmt_previous = $db->prepare($sql_previous);
$stmt_previous->bind_param("i", $preorder_id);
$stmt_previous->execute();
$result_previous = $stmt_previous->get_result();

$display_data = [];
while ($row = $result_previous->fetch_assoc()) {
    $display_data = [
        'username' => $row['username'],
        'kelas' => $row['kelas'],
        'previous_quantities' => []
    ];
    $display_data['previous_quantities'][$row['product_name']] = $row['previous_quantity'];
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-Order - Marketopia!</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
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
                <img src="assets/images/icon.png" alt="Logo" class="logo">
                <h1 class="logo-text">Marketopia !</h1>
            </div>
            <nav class="menu">
                <a href="dashboard.php" class="menu-link"><i class="fas fa-home"></i></a>
                <a href="carts-pages.php" class="menu-link"><i class="fas fa-shopping-cart"></i></a>
            </nav>
        </header>

        <div id="order-summary" class="order-summary">
    <h2>Rincian Pesanan</h2>
    <p><strong>Nama :</strong> <?php echo htmlspecialchars($display_data['username'] ?? $username); ?></p>
    <p><strong>Kelas :</strong> <?php echo htmlspecialchars($display_data['kelas'] ?? $kelas); ?></p>

    <div class="product-item">
    <ul>
        <li><strong>ID Pesanan :</strong> <?php echo htmlspecialchars($preorder['id_pre_order']); ?></li>
        <li><strong>Produk :</strong> 
            <?php 
            // Menampilkan nama produk dan kuantitas
            echo htmlspecialchars($preorder['nama_product']) . " (" . intval($preorder['quantity']) . ")"; 
            ?>
        </li>
        <?php 
        // Tampilkan kuantitas sebelumnya
        foreach ($previous_quantities as $product_name => $quantity) {
            echo "<li><strong>Jumlah (" . htmlspecialchars($product_name) . "):</strong> " . $quantity . "</li>";
        }
        ?>
    </ul>
</div>

    <div class="total-harga">
        <span>Total Harga : <strong>Rp <?php echo number_format($preorder['total_price'], 0, ',', '.'); ?></strong></span>
    </div>
    <button id="proceed-to-transaction" class="pay-button">Silahkan Datang ke ruang D1 pada 30 Januari 2025</button>
</div>
</div>
        </main>

        <footer class="footer">
            <p>&copy; 2025 Marketopia! All Rights Reserved.</p>
        </footer>
    </div>
</body>

</html>