<?php
include "CODES/BACKEND/db.php";
session_start();

if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
    }

if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true) {
    header("Location: index.php");
    exit;
    }

    $imagepath = [];
    
    foreach ($imagepath as $id => $path) {
        $imagename = basename($path); 
        $sql = "UPDATE foods 
            SET 
                nama_gambar = CASE WHEN foods_id = ? THEN ? END,
                gambar = CASE WHEN foods_id = ? THEN ? END
            WHERE foods_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isisi", $id, $imagename, $id, $path, $id);
    $stmt->execute();
}

foreach ($imagepath as $id => $path) {
    $imagename = basename($path); 
    $sql = "UPDATE drinks 
            SET 
                nama_gambar = CASE WHEN drinks_id = ? THEN ? END,
                gambar = CASE WHEN drinks_id = ? THEN ? END
            WHERE drinks_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isisi", $id, $imagename, $id, $path, $id);
    $stmt->execute();
}

$datamakanan = [];
$dataminuman = [];

// Ambil data dari tabel foods berdasarkan product_type
$sql = "SELECT * FROM foods";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['product_type'] === 'food') {
            $datamakanan[] = [
                'nama' => $row['nama'],
                'harga' => $row['harga'],
                'id' => $row['foods_id'],
                'url_gambar' => $row['gambar'],
                'nama_gambar' => $row['nama_gambar'],
                'deskripsi' => $row['deskripsi'],
            ];
        } elseif ($row['product_type'] === 'drink') {
            $dataminuman[] = [
                'nama' => $row['nama'],
                'harga' => $row['harga'],
                'id' => $row['foods_id'],
                'url_gambar' => $row['gambar'],
                'nama_gambar' => $row['nama_gambar'],
                'deskripsi' => $row['deskripsi'],
            ];
        }
    }
    $_SESSION['list_makanan'] = $datamakanan;
    $_SESSION['list_minuman'] = $dataminuman;
}

$db->close();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
    <title>Dashboard Marketopia !</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CODES/CSS/dashboard-styles.css">
    <script src="CODES/JS/dashboard-scripts.js"></script>
</head>
<body>
    <a href="carts-pages.php">
        <i class="fas fa-shopping-cart" style="scale:1.7;bottom:30px;z-index:999;border-radius:50%;right:30px;position:fixed;padding:10px;background-color:orange;"></i>
    </a>
    <header>
        <div class="kontainer-header">
            <img class="logo" src="assets/images/icon.png">
            <nav class="tombol-navigasi">    
                <a href="#beranda">Beranda</a>
                <a href="#produk">Produk</a>
                <a href="riwayat-po.php">Riwayat</a>
            </nav>
        </div>
    </header>

    <aside class="sidebar">
        <div class="sidebar-header">
            <img class="logo" src="assets/images/icon.png">
            <button class="close-sidebar" aria-label="Close Sidebar">&times;</button>
        </div>
        <!-- <nav>
            <ul class="menu">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#layanan">Layanan</a></li>
                <li><a href="#promo">Promo</a></li>
                <li><a href=".produk-populer">Popular</a></li>
                <li><a href="#produk">Produk</a></li>
                <li><a href="footer">Kontak</a></li>
            </ul>
        </nav> -->
    </aside>

    <div class="slider-container" id="beranda">
        <div class="slider">
            <div class="slide" style="background-image: url('assets/images/bg.jpg');">
                <div class="slide-content">
                    <h1>Diskon Besar Akhir Bulan</h1>
                    <p>Dapatkan penawaran terbaik hanya untuk Anda ! Belanja sekarang.</p>
                    <a href="#produk"><button class="cta-button">Belanja Sekarang</button></a>
                </div>
            </div>
            <div class="slide" style="background-image: url('assets/images/bg.jpg');">
                <div class="slide-content">
                    <h1>Produk Baru !</h1>
                    <p>Koleksi terbaru telah hadir. Jangan sampai kehabisan !</p>
                    <a href="#produk"><button class="cta-button">Lihat Koleksi</button></a>
                </div>
            </div>
            <div class="slide" style="background-image: url('assets/images/bg.jpg');">
                <div class="slide-content">
                    <h1>Produk Terlaris</h1>
                    <p>Belanja produk favorit Anda dengan harga spesial.</p>
                    <a href="#produk"><button class="cta-button">Lihat Produk</button></a>
                </div>
            </div>
        </div>
        <div class="dots"></div>
    </div>

    <section id="tentang" class="tentang">
        <div class="container-tentang">
            <div class="tentang-content">
                <div class="tentang-text">
                    <h2 class="section-title">Tentang <span>Marketopia!</span></h2>
                    <p class="section-description">
                        Selamat datang di <strong>Marketopia!</strong>, platform inovatif yang dirancang khusus untuk mempermudah Anda menyediakan makanan dan minuman berkualitas untuk berbagai acara, terutama <strong>Market Day</strong>.
                        Kami hadir untuk menghadirkan pengalaman yang praktis, menyenangkan, dan penuh pilihan lezat, mulai dari jajanan tradisional hingga makanan kekinian yang sedang tren.
                    </p>
                </div>
                <div class="tentang-image">
                    <img src="assets/images/bg.jpg" alt="Tentang Marketopia !">
                </div>
            </div>
        </div>
    </section>

    <section id="produk" class="produk">
        <div class="container">
            <h2 class="section-title">Katalog Produk</h2>

            <div class="kategori-produk">
                <h3 class="kategori-title"><i class="fas fa-hamburger"></i> Makanan </h3>
                <div class="produk-scroll">
                    <?php foreach ($datamakanan as $makanan): ?>
                        <div class="produk-item">
                            <div class="produk-info">
                                <div class="gambar-produk" style="background-image: url('<?= htmlspecialchars($makanan['url_gambar']) ?>');"></div>
                                <h3><?= htmlspecialchars($makanan['nama']) ?></h3>
                                <p class="harga">Rp. <?= number_format($makanan['harga'], 0, ',', '.') . ',00-.' ?></p>
                                <p class="deskripsi"><?= htmlspecialchars($makanan['deskripsi']) ?></p>
                            </div>
                            <a href="info-produk-pages.php?id=<?= $makanan['id'] ?>&type=foods" class="cek-produk">Lihat Detail</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="kategori-produk">
                <h3 class="kategori-title"><i class="fas fa-glass-martini-alt"></i> Minuman</h3>
                <div class="produk-scroll">
                    <?php foreach ($dataminuman as $minuman): ?>
                        <div class="produk-item">
                            <div class="produk-info">
                                <div class="gambar-produk" style="background-image: url('<?= htmlspecialchars($minuman['url_gambar']) ?>');"></div>
                                <h3><?= htmlspecialchars($minuman['nama']) ?></h3>
                                <p class="harga">Rp. <?= number_format($minuman['harga'], 0, ',', '.') . ',00-.' ?></p>
                                <p class="deskripsi"><?= htmlspecialchars($minuman['deskripsi']) ?></p>
                            </div>
                            <a href="info-produk-pages.php?id=<?= $minuman['id'] ?>&type=foods" class="cek-produk">Lihat Detail</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-navigation">
                <h3>Navigasi</h3>
                <ul>
                    <li><a href="#beranda"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><a href="#tentang"><i class="fas fa-info-circle"></i> Tentang Kami</a></li>
                    <li><a href="carts-pages.php"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</a></li>
                    <li><a href="#produk"><i class="fas fa-box-open"></i> Produk</a></li>
                </ul>
            </div>

            <div class="footer-info">
                <h3>Informasi</h3>
                <p><i class="fas fa-map-marker-alt"></i> Lokasi : SMKN 1 Kota Bekasi </p>
                <p><i class="fas fa-envelope"></i> Email : -</p>
                <p><i class="fas fa-phone"></i> Telepon : -</p>
                <p><i class="fas fa-clock"></i> Jam Operasional : Kamis 30 Januari 2025 ( 06:30 - 11:30 WIB )</p>
            </div>

            <div class="footer-social">
                <h3>Ikuti Kami</h3>
                <ul>
                    <li><a href="https://www.instagram.com/marketopia27/"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><form action="dashboard.php" method="POST">
                        <button type="submit" name="logout" style="padding: 5px 10px;border-radius:5px;border:0;">Logout</button>
                </form></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Marketopia. Semua Hak Cipta Dilindungi</p>
        </div>
    </footer>
    <script>
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        const dotsContainer = document.querySelector('.dots');

        let currentSlide = 0;

        slides.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.classList.add(index === 0 ? 'active' : '');
            dotsContainer.appendChild(dot);
        });

        const updateSlider = () => {
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            dotsContainer.querySelectorAll('div').forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        };

        const autoSlide = () => {
            currentSlide = (currentSlide + 1) % slides.length;
            updateSlider();
        };

        let slideInterval = setInterval(autoSlide, 5000);

        document.querySelector('.slider-container').addEventListener('mouseover', () => {
            clearInterval(slideInterval);
        });

        document.querySelector('.slider-container').addEventListener('mouseout', () => {
            slideInterval = setInterval(autoSlide, 5000);
        });

        dotsContainer.addEventListener('click', (e) => {
            if (e.target.tagName === 'DIV') {
                currentSlide = Array.from(dotsContainer.children).indexOf(e.target);
                updateSlider();
            }
        });
    </script>
</body>

</html>