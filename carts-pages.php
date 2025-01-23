
<?php
include "CODES/BACKEND/db.php";
session_start();

if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true) {
    header("Location: index.php");
    exit;
    }
    
$jumlahprodukcart;

if (isset($_GET['idproduk'])) {
    $id = intval($_GET['idproduk']);

    $sql = "SELECT * FROM foods WHERE foods_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();

    if ($produk) {
        $sql_check = "SELECT * FROM cart WHERE id_product = ?";
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // echo "Produk sudah ada di keranjang.";
        } else {
            $sql_cart = "INSERT INTO cart (id_product, nama_product, harga, gambar, nama_gambar) VALUES (?, ?, ?, ?, ?)";
            $stmt_cart = $db->prepare($sql_cart);
            $stmt_cart->bind_param("issss", $id, $produk['nama'], $produk['harga'], $produk['gambar'], $produk['nama_gambar']);
            $stmt_cart->execute();
        }
    }
}

$dataproduk = []; // Inisialisasi array kosong

$sql2 = "SELECT * FROM cart";
$result2 = $db->query($sql2);

if (!$result2) {
    // Jika query gagal
    echo "Error: " . $db->error;
} elseif ($result2->num_rows > 0) {
    // Jika ada data dalam tabel cart
    while ($row2 = $result2->fetch_assoc()) {
        $dataproduk[] = [
            'id' => $row2['id_product'],
            'nama' => $row2['nama_product'],
            'harga' => $row2['harga'],
            'url_gambar' => $row2['gambar'],
            'nama_gambar' => $row2['nama_gambar'],
        ];
    }
} else {
    // Jika tabel cart kosong
    echo "<p>Keranjang kosong.</p>";
}


if (!empty($dataproduk)) {
    foreach ($dataproduk as $produk) {
        // Render item cart
    }
} else {
    echo "<p>Keranjang kosong</p>";
}

$sqljumlah = "SELECT COUNT(id_cart) AS id FROM cart";
$resultjumlah = $db->query($sqljumlah);

if ($resultjumlah->num_rows > 0) {
    $row = $resultjumlah->fetch_assoc();
    $jumlahprodukcart = $row['id']; // Simpan jumlah ID ke dalam variabel
} else {
    $jumlahprodukcart = 0; // Jika tabel kosong, jumlah ID adalah 0
}

if (isset($_GET['iddelete'])) {
    $id_delete = intval($_GET['iddelete']);
    $sqldelete = "DELETE FROM cart WHERE id_product = ?";
    $stmt_delete = $db->prepare($sqldelete);
    $stmt_delete->bind_param("i", $id_delete);
    $stmt_delete->execute();
    $stmt_delete->close();
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();

}

function processPreOrder($db, $username = null) {
    // Debugging: Check database connection
    if (!$db) {
        echo "Database connection error!";
        return;
    }

    // Retrieve cart items
    $sql_cart = "SELECT * FROM cart";
    $result_cart = $db->query($sql_cart);
    
    if (!$result_cart) {
        echo "Error fetching cart items: " . $db->error;
        return;
    }

    if ($result_cart->num_rows > 0) {
        $total_price = 0;
        $product_names = [];
        $total_quantity = 0;

        try {
            // Prepare the pre-order insertion using the correct table name
            $sql_preorder = "INSERT INTO pre_orders (username, nama_product, quantity, total_price) VALUES (?, ?, ?, ?)";
            $stmt_preorder = $db->prepare($sql_preorder);

            if (!$stmt_preorder) {
                echo "Prepare failed: " . $db->error;
                return;
            }

            // Calculate total price and collect product names
            while ($row = $result_cart->fetch_assoc()) {
                $total_price += $row['harga'];
                $product_names[] = $row['nama_product'];
                $total_quantity++;
            }

            $kelas = 'Tidak Diketahui';
            if ($username !== 'Guest') {
                $sql_user = "SELECT kelas FROM users WHERE username = ?";
                $stmt_user = $db->prepare($sql_user);
                $stmt_user->bind_param("s", $username);
                $stmt_user->execute();
                $result_user = $stmt_user->get_result();
                if ($result_user->num_rows > 0) {
                    $user = $result_user->fetch_assoc();
                    $kelas = $user['kelas'];
                }
            }

            // Convert product names to a comma-separated string
            $product_name_string = implode(', ', $product_names);

            // Execute pre-order insertion
            $sql_preorder = "INSERT INTO pre_orders (username, nama_product, quantity, total_price, kelas) VALUES (?, ?, ?, ?, ?)";
            $stmt_preorder = $db->prepare($sql_preorder);
            $stmt_preorder->bind_param("ssids", $username, $product_name_string, $total_quantity, $total_price, $kelas);
            $result = $stmt_preorder->execute();
            

            if (!$result) {
                echo "Execute failed: " . $stmt_preorder->error;
                return;
            }

            $preorder_id = $db->insert_id;

            // Clear cart after successful pre-order
            $db->query("DELETE FROM cart");

            // Redirect to pre-order page with pre-order ID
            header("Location: pre-order-pages.php?id=" . $preorder_id);
            exit();

        } catch (Exception $e) {
            echo "Pre-order failed: " . $e->getMessage();
        }
    } else {
        echo "Keranjang kosong. Tidak dapat melakukan pre-order.";
    }
}

// Check if session is started, if not start it
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Trigger pre-order process
if (isset($_POST['submit_preorder'])) {
    // Use username from session or as guest
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
    processPreOrder($db, $username);
}
?>



<form id="preOrderForm" method="POST">
    <input type="hidden" name="submit_preorder" value="1">
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const preOrderButton = document.getElementById('preOrder');
    const preOrderForm = document.getElementById('preOrderForm');
    
    if (preOrderButton && preOrderForm) {
        preOrderButton.addEventListener('click', function(e) {
            e.preventDefault();
            preOrderForm.submit();
        });
    }
});

</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CODES/CSS/carts-pages-styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="CODES/JS/carts-pages.js"></script>
    <title>Keranjang Jajan Yuk !</title>
</head>

<body>
    <div class="container">
        <header>
            <div class="kontainer-header">
                <img class="logo" src="ASSETS/IMAGES/icon.png" alt="Logo">
                <div class="menu-icons">
                    <a href="dashboard.php" class="menu-link">
                        <i class="fas fa-home"></i>
                    </a>
                    <a href="#" class="menu-link">
                        <i class="fas fa-info"></i>
                    </a>
                </div>
            </div>
        </header>
        <div class="cart-container">
            <div class="cart-header">
                <h2>Keranjang</h2>
                <p>Total Item : <?=$jumlahprodukcart?><span id="totalItems"></span></p>
            </div>

            <div class="cart-item-list">
                <?php foreach ($dataproduk as $produk) {  ?>
                    <div class="cart-item">
                        <div class="product-image">
                            <img src="<?=$produk['url_gambar']?>" alt="<?=$produk['nama_gambar']?>">
                        </div>
                        <div class="product-details">
                            <h3 class="nama-produk"><?=$produk['nama']?></h3>
                            <p class="deskripsi-produk">Deskripsi singkat produk minuman</p>
                            <p class="ukuran-porsi">Ukuran : [Ukuran]</p>
                            <p class="tingkat-pedas">Suhu : [Suhu]</p>
                            <p class="volume">Volume : [Volume]</p>
                            <p class="tersedia">Tersedia : [Tersedia]</p>
                            <p class="deskripsi-rasa">Deskripsi Rasa : [Deskripsi Rasa]</p>
                            <p class="deskripsi-gizi">Deskripsi Gizi : [Deskripsi Gizi]</p>
                            <p class="waktu-penyajian">Waktu Penyajian : [Waktu Penyajian]</p>
                        </div>
                        <div class="product-price">
                            <p>Rp. <span class="unit-price"><?php echo number_format($produk['harga'], 2, ',', '.') . '-.'; ?>
                            </span></p>
                        </div>
                        <div class="product-subtotal">
                            <p>Rp <span class="subtotal-price"><?php echo number_format(100000, 2, ',', '.'), '-.'; ?></span></p>
                        </div>
                        <div class="product-actions">
                            <a href="carts-pages.php?iddelete=<?=$produk['id']?>"><button class="remove-btn" data-id="1">Hapus</button></a>
                            <label>
                                <input type="checkbox" class="wishlist-checkbox" data-id="1"> Simpan ke Wishlist
                            </label>
                        </div>
                    </div>
                <?php } ?>

                <!-- <div class="cart-item">
                    <div class="product-image">
                        <img src="assets/images/product2.jpg" alt="Nama Produk 2">
                    </div>
                    <div class="product-details">
                        <h3 class="nama-produk">Produk Makanan</h3>
                        <p class="deskripsi-produk">Deskripsi singkat produk makanan</p>
                        <p class="ukuran-porsi">Ukuran Porsi : [Ukuran Porsi]</p>
                        <p class="tingkat-pedas">Tingkat Pedas : [Tingkat Pedas]</p>
                        <p class="tersedia">Tersedia : [Tersedia]</p>
                        <p class="deskripsi-rasa">Deskripsi Rasa : [Deskripsi Rasa]</p>
                        <p class="deskripsi-gizi">Deskripsi Gizi : [Deskripsi Gizi]</p>
                        <p class="waktu-penyajian">Waktu Penyajian : [Waktu Penyajian]</p>
                    </div>
                    <div class="product-price">
                        <p>Rp. <span class="unit-price"><?php echo number_format(75000, 2, ',', '.'), '-.'; ?></span></p>
                    </div>
                    <div class="product-subtotal">
                        <p>Rp. <span class="subtotal-price"><?php echo number_format(75000, 2, ',', '.'), '-.'; ?></span></p>
                    </div>
                    <div class="product-actions">
                        <button class="remove-btn" data-id="2">Hapus</button>
                        <label>
                            <input type="checkbox" class="wishlist-checkbox" data-id="2"> Simpan ke Wishlist
                        </label>
                    </div>
                </div> -->
            </div>

            <div class="ringkasan-pesanan">
                <h3>Ringkasan Pesanan</h3>
                <table>
                    <tr>
                        <td>Total Harga Barang</td>
                        <td>Rp. <span id="totalPrice"><?php echo number_format(120000, 2, ',', '.'), '-.'; ?></span></td>
                    </tr>
                    <tr>
                        <td>Biaya Pengiriman</td>
                        <td>Rp. <span id="shippingFee"><?php echo number_format(20000, 2, ',', '.'), '-.'; ?></span></td>
                    </tr>
                    <tr>
                        <td>Diskon</td>
                        <td>Rp. <span id="discount"><?php echo number_format(10000, 2, ',', '.'), '-.'; ?></span></td>
                    </tr>
                    <tr>
                        <td><b><i>Total Pembayaran</i></b></th>
                        <td><b><i>Rp. <span id="grandTotal"><?php echo number_format(100000, 2, ',', '.'), '-.'; ?></span></i></b></th>
                    </tr>
                </table>
                <button class="checkout-btn">Lanjutkan ke Pembayaran</button>
            </div>
            <footer>
                <div class="total">
                    <input type="checkbox" name="pilihSemua">
                    <label for="pilihSemua" class="font-biasa">Pilih Semua</label>
                    <table>
                        <tr>
                            <!-- total harga keranjang -->
                            <td>Total :</td>
                            <td>Rp. <?php echo number_format(150000, 2, ',', '.'), '-.'; ?></td>
                        </tr>
                    </table>
                </div>
                <button id="preOrder">Pre Order</button>
            </footer>
        </div>
    </div>
</body>

</html>