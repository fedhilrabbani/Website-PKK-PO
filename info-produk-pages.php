<?php
include "CODES/BACKEND/db.php";

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

            if($stock < 0) {
                $message = "Habis";
            } else {
                $message = "Tersedia";
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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Jajan Yuk !</title>
    <link rel="stylesheet" href="CODES/CSS/info-produk-styles.css">
    <link rel="shortcut icon" href="ASSETS/IMAGES/icon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="CODES/JS/info-produk-scripts.js"></script>
</head>

<body>
    <div id="container">
        <header>
            <div class="kontainer-header">
                <img class="logo" src="ASSETS/IMAGES/icon.png" alt="Logo">
                <div class="menu-icons">
                    <a href="dashboard.php" class="menu-link">
                        <i class="fas fa-home"></i>
                    </a>
                    <a href="carts-pages.php" class="menu-link">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <a href="pre-order-pages.php" class="menu-link">
                        <i class="fas fa-check-circle"></i>
                    </a>
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
                        <h4>Tersedia : <?= htmlspecialchars($message) ?></h4>
                    </div>

                    <?php if ($type === 'foods'): ?>
                        <div class="produk-food-info">
                            <h4>Informasi Makanan</h4>
                            <p><strong><i class="fas fa-utensils"></i> Ukuran Porsi :</strong> <?= htmlspecialchars($ukuran_porsi) ?></p>
                            <p><strong><i class="fas fa-pepper-hot"></i> Tingkat Pedas :</strong> <?= htmlspecialchars($tingkat_pedas) ?></p>
                            <p><strong><i class="fas fa-flask"></i> Rasa :</strong> <?= htmlspecialchars($deskripsi_rasa) ?></p>
                            <!-- <p><strong><i class="fas fa-chart-bar"></i> Gizi :</strong> <?= htmlspecialchars($deskripsi_gizi) ?></p> -->
                            <p><strong><i class="fas fa-clock"></i> Waktu Penyajian :</strong> <?= htmlspecialchars($waktu_penyajian) ?></p>
                        </div>
                    <?php elseif ($type === 'drinks'): ?>
                        <div class="produk-drink-info">
                            <h4>Informasi Minuman</h4>
                            <p><strong><i class="fas fa-temperature-high"></i> Suhu :</strong> <?= htmlspecialchars($suhu) ?></p>
                            <p><strong><i class="fas fa-tint"></i> Rasa :</strong> <?= htmlspecialchars($rasa) ?></p>
                            <p><strong><i class="fas fa-glass-whiskey"></i> Volume :</strong> <?= htmlspecialchars($volume) ?> ml</p>
                            <!-- <p><strong><i class="fas fa-chart-bar"></i> Gizi :</strong> <?= htmlspecialchars($deskripsi_gizi) ?></p> -->
                            <p><strong><i class="fas fa-clock"></i> Waktu Penyajian :</strong> <?= htmlspecialchars($waktu_penyajian) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="product-quantity">
                        <form class="quantity-control" action="carts-pages.php" method="">
                            <button class="minus-btn" data-id="2">-</button>
                            <input type="number" value="1" class="quantity-input" data-id="2">
                            <button class="plus-btn" data-id="2" name="plusbtn">+</button>
                        </form>
                    </div>

                <div class="produk-action">
                    <a href="carts-pages.php?idproduk=<?= $id ?>" class="add-to-cart-btn">Tambah Ke Keranjang</a>
                    <a href="" class="buy-now-btn">Pre Order</a>
                </div>
            </div>
        </div>
</body>

</html>

<?php
$db->close();
?>