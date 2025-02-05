<?php
include "CODES/BACKEND/db.php";
session_start();

if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true) {
    header("Location: index.php");
    exit;
    }

$message;

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = intval($_GET['id']);
    $type = $_GET['type'];

    if ($type === 'foods' || $type === 'drinks') {
        $table = $type;

        $sql = "SELECT * FROM $table WHERE " . ($type === 'foods' ? 'foods_id' : 'drinks_id') . " = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produk = $result->fetch_assoc();

        if ($produk) {
            $nama = $produk['nama'];
            $harga = $produk['harga'];
            $deskripsi = $produk['deskripsi'];
            $stock = $produk['quantity'];
            $url_gambar = $produk['gambar'];

            if ($stock < 1) {
                $message = "Habis";
            } else {
                $message = "Tersedia: " . $stock . " unit"; // Mengambil stok dari kolom quantity
            }

            // if ($type === 'foods') {
            //     $ukuran_porsi = $produk['ukuran_porsi'];
            //     $tingkat_pedas = $produk['tingkat_pedas'];
            //     $deskripsi_rasa = $produk['deskripsi_rasa'];
            //     $deskripsi_gizi = $produk['deskripsi_gizi'];
            //     $waktu_penyajian = $produk['waktu_penyajian'];
            // }

            // if ($type === 'drinks') {
            //     $suhu = $produk['suhu'];
            //     $rasa = $produk['rasa'];
            //     $volume = $produk['volume'];
            //     $deskripsi_gizi = $produk['deskripsi_gizi'];
            //     $waktu_penyajian = $produk['waktu_penyajian'];
            // }
        } else {
            $error = "Produk tidak ditemukan.";
        }
    } else {
        $error = "Tipe produk tidak valid.";
    }
} else {
    $error = "Parameter tidak lengkap.";
}

if (isset($error)) {
    echo "<p>Error: $error</p>";
    exit;
}

// if (isset($_GET['id'])) {
//     $id = intval($_GET['id']);

//     $sql = "SELECT * FROM foods WHERE foods_id = ?";
//     $stmt = $db->prepare($sql);
//     $stmt->bind_param("i",$id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $produk = $result->fetch_assoc();

//     if ($produk) {
//         $sql_cart = "INSERT INTO cart (id_product, nama_product, harga) VALUES (?, ?, ?)";
//         $stmt_cart = $db->prepare($sql_cart);
//         $stmt_cart->bind_param("iss", $id, $produk['nama'], $produk['harga']);
//         $stmt_cart->execute();
//         header("Location: carts-pages.php");
//     }
// }

function processPreOrderDirect($db, $username, $product_id) {
    // Debugging: Check database connection
    if (!$db) {
        die("Database connection error!");
    }

    // Debug: Pastikan parameter product_id diterima
    if (empty($product_id)) {
        die("Parameter tidak lengkap. Harap pilih produk.");
    }

    // Default kelas
    $kelas = 'Tidak Diketahui';

    // Cek kelas user jika bukan Guest
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

    // Ambil detail produk dari database
    $sql_product = "SELECT * FROM foods WHERE foods_id = ?";
    $stmt_product = $db->prepare($sql_product);
    $stmt_product->bind_param("i", $product_id);
    $stmt_product->execute();
    $result_product = $stmt_product->get_result();

    if ($result_product->num_rows > 0) {
        $product = $result_product->fetch_assoc();
        $nama_product = $product['nama'];
        $harga = $product['harga'];

        // Masukkan data ke tabel pre_orders
        $sql_preorder = "INSERT INTO pre_orders (username, nama_product, quantity, total_price, kelas) VALUES (?, ?, ?, ?, ?)";
        $stmt_preorder = $db->prepare($sql_preorder);
        $quantity = 1; // Jumlah default untuk Pre Order langsung
        $total_price = $harga * $quantity;

        $stmt_preorder->bind_param("ssids", $username, $nama_product, $quantity, $total_price, $kelas);

        if ($stmt_preorder->execute()) {
            $preorder_id = $db->insert_id;

            // Redirect ke halaman pre-order
            header("Location: pre-order-pages.php?id=" . $preorder_id);
            exit();
        } else {
            die("Error: " . $stmt_preorder->error);
        }
    } else {
        die("Produk tidak ditemukan.");
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Jajan Yuk !</title>
    <link rel="stylesheet" href="CODES/CSS/info-produk-styles.css">
    <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="CODES/JS/info-produk-scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


</head>

<div>
    <div id="container">
        <header>
            <div class="kontainer-header">
                <img class="logo" src="assets/images/icon.png" alt="Logo">
                <div class="menu-icons">
                    <a href="dashboard.php" class="menu-link">
                        <i class="fas fa-home"></i>
                    </a>
                    <a href="carts-pages.php" class="menu-link">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <!-- <a href="pre-order-pages.php" class="menu-link">
                        <i class="fas fa-check-circle"></i>
                    </a> -->
                </div>
            </div>
        </header>

        <div class="produk-detail-container">
            <div class="produk-info">
                <div class="produk-header">
                    <h1 class="produk-title"><?= htmlspecialchars($nama) ?></h1>
                    <p class="produk-harga">Harga : Rp. <?= htmlspecialchars(number_format($harga, 0, ',', '.')), ',00-.' ?></p>
                </div>

                <div class="produk-gallery">
                    <div class="produk-img-container">
                        <img src="<?= htmlspecialchars($url_gambar) ?>" alt="<?= htmlspecialchars($nama) ?>" class="produk-main-img">
                    </div>
                    <div class="produk-img-thumbnails">
                        <img src="<?= htmlspecialchars($url_gambar) ?>" alt="Thumbnail 1" class="thumbnail-img">
                        <img src="<?= htmlspecialchars($url_gambar) ?>" alt="Thumbnail 2" class="thumbnail-img">
                        <img src="<?= htmlspecialchars($url_gambar) ?>" alt="Thumbnail 3" class="thumbnail-img">
                    </div>
                </div>

                <div class="produk-description">
                    <h3>Deskripsi Produk</h3>
                    <p><?= htmlspecialchars($deskripsi) ?></p>
                </div>

                <div class="produk-additional-info">
                <div class="produk-availability">
                    <h4><?= htmlspecialchars($message) ?></h4> <!-- Menampilkan status stok -->
                </div>
                </div>
                <div class="product-quantity">
                <form class="quantity-control">
                    <button class="minus-btn" type="button">-</button>
                    <input type="number" value="1" class="quantity-input" name="quantity_total" min="1">
                    <button class="plus-btn" type="button">+</button>
                </form>
            </div>
            
            <form id="cartForm" action="carts-pages.php" method="POST" style="display: none;">
                <input type="hidden" name="id_produk" value="<?= htmlspecialchars($id) ?>">
                <input type="hidden" name="quantity_total" id="hiddenQuantityInput" value="1">
                <input type="hidden" name="nama_product" value="<?= htmlspecialchars($nama) ?>">
                <input type="hidden" name="harga" value="<?= htmlspecialchars($harga) ?>">
                <input type="hidden" name="gambar" value="<?= htmlspecialchars($url_gambar) ?>">
                <input type="hidden" name="nama_gambar" value="<?= htmlspecialchars(basename($url_gambar)) ?>">
            </form>
            <div class="produk-action">
                <a href="#" id="addToCart" class="add-to-cart-btn">Tambah Ke Keranjang</a>
            </div>


                </div>
            </div>
        </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const minusButtons = document.querySelectorAll('.minus-btn');
    const plusButtons = document.querySelectorAll('.plus-btn');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const addToCartButton = document.getElementById('addToCart');
    const cartForm = document.getElementById('cartForm');
    const hiddenQuantityInput = document.getElementById('hiddenQuantityInput');

    // Ambil stok dari PHP
    const availableStock = <?= intval($stock) ?>;

    const updateQuantity = (inputElement, increment) => {
        let currentQuantity = parseInt(inputElement.value) || 0;
        let newQuantity = currentQuantity + increment;

        // Batasi quantity antara 1 dan stok yang tersedia
        if (newQuantity >= 1 && newQuantity <= availableStock) {
            inputElement.value = newQuantity;
        } else {
            // Tampilkan peringatan jika melebihi stok
            if (newQuantity > availableStock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Terbatas',
                    text: `Maaf, stok hanya tersedia ${availableStock} unit`,
                    confirmButtonText: 'Oke'
                });
                inputElement.value = availableStock;
            }
        }
    };

    // Tambahkan event listener untuk tombol minus dan plus
    minusButtons.forEach((button, index) => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            updateQuantity(quantityInputs[index], -1);
        });
    });

    plusButtons.forEach((button, index) => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            updateQuantity(quantityInputs[index], 1);
        });
    });

    // Tambahkan event listener untuk input langsung
    quantityInputs.forEach(input => {
        input.addEventListener('input', function() {
            let inputValue = parseInt(this.value) || 0;
            
            // Jika input melebihi stok
            if (inputValue > availableStock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Terbatas',
                    text: `Maaf, stok hanya tersedia ${availableStock} unit`,
                    confirmButtonText: 'Oke'
                });
                this.value = availableStock;
            } 
            
            // Jika input kurang dari 1
            if (inputValue < 1) {
                this.value = 1;
            }
        });
    });

    // Event listener untuk tombol tambah ke keranjang
    if (addToCartButton && cartForm && hiddenQuantityInput) {
        addToCartButton.addEventListener('click', function (e) {
            e.preventDefault();
            
            const quantityValue = parseInt(quantityInputs[0].value, 10) || 1;
            
            // Validasi ulang sebelum submit
            if (quantityValue > availableStock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Terbatas',
                    text: `Maaf, stok hanya tersedia ${availableStock} unit`,
                    confirmButtonText: 'Oke'
                });
                quantityInputs[0].value = availableStock;
                return;
            }

            // Konfirmasi sebelum menambahkan ke keranjang
            Swal.fire({
                icon: 'question',
                title: 'Tambah ke Keranjang',
                text: `Tambahkan ${quantityValue} ${nama} ke keranjang?`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambahkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    hiddenQuantityInput.value = quantityValue;
                    cartForm.submit();
                }
            });
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addToCartButton = document.getElementById('addToCart');
    const cartForm = document.getElementById('cartForm');
    const quantityInput = document.querySelector('.quantity-input');
    const hiddenQuantityInput = document.getElementById('hiddenQuantityInput');

    if (addToCartButton && cartForm && quantityInput && hiddenQuantityInput) {
        addToCartButton.addEventListener('click', function (e) {
            e.preventDefault(); // Mencegah navigasi default dari link
            
            // Ambil nilai dari input quantity
            const quantityValue = parseInt(quantityInput.value, 10) || 1;
            
            // Debugging untuk memastikan nilai quantity
            console.log('Quantity Value:', quantityValue);
            
            // Masukkan nilai quantity ke input tersembunyi
            hiddenQuantityInput.value = quantityValue;

            // Submit form secara otomatis
            cartForm.submit();
        });
    }
});
</script>

</html>