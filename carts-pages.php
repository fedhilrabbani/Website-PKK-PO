<?php
// include "CODES/BACKEND/db.php";

// if (isset($_GET['idproduk'])) {
//     $id = intval($_GET['idproduk']);

//     $sql = "SELECT * FROM foods WHERE foods_id = ?";
//     $stmt = $db->prepare($sql);
//     $stmt->bind_param("i",$id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $produk = $result->fetch_assoc();

//     if ($produk) {
//         $sql_check = "SELECT * FROM cart WHERE id_product = ?";
//         $stmt_check = $db->prepare($sql_check);
//         $stmt_check->bind_param("i", $id);
//         $stmt_check->execute();
//         $result_check = $stmt_check->get_result();

//         if ($result_check->num_rows > 0) {
//             echo "Produk sudah ada di keranjang.";
//         } else {
//             $sql_cart = "INSERT INTO cart (id_product, nama_product, harga, gambar, nama_gambar) VALUES (?, ?, ?, ?, ?)";
//             $stmt_cart = $db->prepare($sql_cart);
//             $stmt_cart->bind_param("issss", $id, $produk['nama'], $produk['harga'], $produk['gambar'], $produk['nama_gambar']);
//             $stmt_cart->execute();
//         }
//     }
// }

// $sql2 = "SELECT * FROM cart";
// $result2 = $db->query($sql2);
// if ($result2->num_rows > 0) {
//     while ($row2 = $result2->fetch_assoc()) {
//         $dataproduk[] = [
//             'nama' => $row2['nama_product'],
//             'harga' => $row2['harga'],
//             // 'id' => $row2['drinks_id'],
//             'url_gambar' => $row2['gambar'],
//             'nama_gambar' => $row2['nama_gambar'],
//         ];
//     }
//     //$_SESSION['list_minuman'] = $dataminuman;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CODES/CSS/carts-pages-styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Keranjang Jajan Yuk !</title>
</head>

<body>
    <div class="container">
        <header>
            <div class="kontainer-header">
                <img class="logo" src="ASSETS/IMAGES/icon.png" alt="Logo">
                <div class="menu-icons">
                    <a href="#" class="menu-link">
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
                <p>Total Item : <span id="totalItems">5</span></p>
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
                        <div class="product-quantity">
                            <div class="quantity-control">
                                <button class="minus-btn" data-id="1">-</button>
                                <input type="number" value="2" class="quantity-input" data-id="1">
                                <button class="plus-btn" data-id="1">+</button>
                            </div>
                        </div>
                        <div class="product-price">
                            <p>Rp. <span class="unit-price"><?php echo number_format($produk['harga'], 2, ',', '.') . '-.'; ?>
                            </span></p>
                        </div>
                        <div class="product-subtotal">
                            <p>Rp <span class="subtotal-price"><?php echo number_format(100000, 2, ',', '.'), '-.'; ?></span></p>
                        </div>
                        <div class="product-actions">
                            <button class="remove-btn" data-id="1">Hapus</button>
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
                    <div class="product-quantity">
                        <div class="quantity-control">
                            <button class="minus-btn" data-id="2">-</button>
                            <input type="number" value="1" class="quantity-input" data-id="2">
                            <button class="plus-btn" data-id="2">+</button>
                        </div>
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
    <script src="CODES/JS/carts-pages.js"></script>
</body>

</html>