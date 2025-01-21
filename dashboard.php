<?php
include "CODES/BACKEND/db.php";
session_start();

$datamakanan = [];
$dataminuman = [];

$imagepath = [
    1 => 'assets/images-product/Mie Roll.jpg',
    2 => 'assets/images-product/Sawi Gulung.jpg',
    3 => 'assets/images-product/Keripik Pisang Lumer.jpg',
    4 => 'assets/images-product/sushi.jpg',
    5 => 'assets/images-product/Donat.jpg',

];

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

$sql = "SELECT * FROM foods";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datamakanan[] = [
            'nama' => $row['nama'],
            'harga' => $row['harga'],
            'id' => $row['foods_id'],
            'url_gambar' => $row['gambar'],
            'nama_gambar' => $row['nama_gambar'],
        ];
    }
    $_SESSION['list_makanan'] = $datamakanan;
}

$sql2 = "SELECT * FROM drinks";
$result2 = $db->query($sql2);
if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $dataminuman[] = [
            'nama' => $row2['nama'],
            'harga' => $row2['harga'],
            'id' => $row2['drinks_id'],
            'url_gambar' => $row2['url_gambar'],
            'deskripsi' => $row2['deskripsi'],
        ];
    }
    $_SESSION['list_minuman'] = $dataminuman;
}

$db->close();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="ASSETS/IMAGES/icon.png" type="image/x-icon">
    <title>Dashboard Jajan Yuk !</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CODES/CSS/dashboard-styles.css">
</head>

<body>
    <header>
        <div class="kontainer-header">
            <img class="logo" src="ASSETS/IMAGES/icon.png">
            <nav class="nav-desktop">
                <ul class="menu">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#layanan">Layanan</a></li>
                    <li><a href="#promo">Promo</a></li>
                    <li><a href="#produk">Popular</a></li>
                    <li><a href="#produk">Produk</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </nav>
            <div class="tombol-autentikasi">
                <a href="index.php" class="tombol-masuk">Masuk</a>
                <a href="signup.php" class="tombol-daftar">Daftar</a>
            </div>
            <button class="burger-menu" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <aside class="sidebar">
        <div class="sidebar-header">
            <img class="logo" src="ASSETS/IMAGES/icon.png">
            <button class="close-sidebar" aria-label="Close Sidebar">&times;</button>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#layanan">Layanan</a></li>
                <li><a href="#promo">Promo</a></li>
                <li><a href=".produk-populer">Popular</a></li>
                <li><a href="#produk">Produk</a></li>
                <li><a href="footer">Kontak</a></li>
            </ul>
        </nav>
    </aside>

    <div class="slider-container">
        <div class="slider">
            <div class="slide" style="background-image: url('ASSETS/IMAGES/bg.jpg');">
                <div class="slide-content">
                    <h1>Diskon Besar Akhir Bulan</h1>
                    <p>Dapatkan penawaran terbaik hanya untuk Anda ! Belanja sekarang.</p>
                    <button class="cta-button">Belanja Sekarang</button>
                </div>
            </div>
            <div class="slide" style="background-image: url('ASSETS/IMAGES/bg.jpg');">
                <div class="slide-content">
                    <h1>Produk Baru !</h1>
                    <p>Koleksi terbaru telah hadir. Jangan sampai kehabisan !</p>
                    <button class="cta-button">Lihat Koleksi</button>
                </div>
            </div>
            <div class="slide" style="background-image: url('ASSETS/IMAGES/bg.jpg');">
                <div class="slide-content">
                    <h1>Produk Terlaris</h1>
                    <p>Belanja produk favorit Anda dengan harga spesial.</p>
                    <button class="cta-button">Lihat Produk</button>
                </div>
            </div>
        </div>
        <div class="dots"></div>
    </div>

    <section id="tentang" class="tentang">
        <div class="container-tentang">
            <div class="tentang-content">
                <div class="tentang-text">
                    <h2 class="section-title">Tentang <span>Jajan Yuk!</span></h2>
                    <p class="section-description">
                        Selamat datang di <strong>Jajan Yuk!</strong>, platform inovatif yang dirancang khusus untuk mempermudah Anda menyediakan makanan dan minuman berkualitas untuk berbagai acara, terutama <strong>Market Day</strong>.
                        Kami hadir untuk menghadirkan pengalaman yang praktis, menyenangkan, dan penuh pilihan lezat, mulai dari jajanan tradisional hingga makanan kekinian yang sedang tren.
                    </p>
                    <!-- <ul class="feature-list">
                        <li><i class="fas fa-check-circle"></i> <strong>Kualitas Terbaik :</strong> Produk makanan dan minuman yang terjamin kebersihan dan kesegarannya.</li>
                        <li><i class="fas fa-box-open"></i> <strong>Pilihan Beragam :</strong> Berbagai jenis jajanan dari pelaku usaha lokal yang dapat disesuaikan dengan tema acara Anda.</li>
                        <li><i class="fas fa-shopping-cart"></i> <strong>Pemesanan Mudah :</strong> Antarmuka sederhana untuk membantu Anda memesan dengan cepat.</li>
                        <li><i class="fas fa-tags"></i> <strong>Harga Terjangkau :</strong> Nikmati penawaran terbaik tanpa mengurangi kualitas.</li>
                    </ul> -->
                    <button class="cta-button">Pelajari Lebih Lanjut</button>
                </div>
                <div class="tentang-image">
                    <img src="ASSETS/IMAGES/bg.jpg" alt="Tentang Jajan Yuk !">
                </div>
            </div>
        </div>
    </section>

    <section id="produk" class="produk">
        <div class="container">
            <h2 class="section-title">Katalog Produk</h2>

            <div class="produk-populer">
                <h3 class="kategori-title">Produk Populer</h3>
                <div class="produk-scroll">
                    <div class="produk-item">
                        <div class="badge">Baru</div>
                        <div class="gambar-produk" style="background-image: url('img/popular1.jpg');"></div>
                        <div class="produk-info">
                            <h3>Smoothie Berry Bliss</h3>
                            <p class="harga">Rp 28.000</p>
                            <div class="rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="deskripsi">Smoothie segar dengan campuran berry yang penuh nutrisi.</p>
                            <a href="#" class="cek-produk">Lihat Detail</a>
                        </div>
                    </div>
                    <div class="produk-item">
                        <div class="badge diskon">Diskon 20%</div>
                        <div class="gambar-produk" style="background-image: url('img/popular2.jpg');"></div>
                        <div class="produk-info">
                            <h3>Pudding Mango Delight</h3>
                            <p class="harga">Rp 24.000 <span class="harga-asli">Rp 30.000</span></p>
                            <div class="rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                            </div>
                            <p class="deskripsi">Lezatnya pudding mangga dengan tekstur lembut.</p>
                            <a href="#" class="cek-produk">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kategori-produk">
                <h3 class="kategori-title"><i class="fas fa-hamburger"></i> Makanan </h3>
                <div class="produk-scroll">
                    <?php foreach ($datamakanan as $makanan): ?>
                        <div class="produk-item">
                            <div class="produk-info">
                                <div class="gambar-produk" style="background-image: url('<?= htmlspecialchars($makanan['url_gambar']) ?>');"></div>
                                <h3><?= htmlspecialchars($makanan['nama']) ?></h3>
                                <p class="harga">Rp. <?= number_format($makanan['harga'], 0, ',', '.') . ',00-.' ?></p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <p class="deskripsi"><?= htmlspecialchars($makanan['deskripsi']) ?></p>
                                <a href="info-produk-pages.php?id=<?= $makanan['id'] ?>&type=foods" class="cek-produk">Lihat Detail</a>
                            </div>
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
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <p class="deskripsi"><?= htmlspecialchars($minuman['deskripsi']) ?></p>
                                <a href="info-produk-pages.php?id=<?= $minuman['id'] ?>&type=drinks" class="cek-produk">Lihat Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-contact">
                <h3>Hubungi Kami</h3>
                <form class="contact-form">
                    <input type="text" placeholder="Nama" required>
                    <input type="email" placeholder="Email" required>
                    <textarea placeholder="Pesan" required></textarea>
                    <button type="submit">Kirim</button>
                </form>
            </div>

            <div class="footer-navigation">
                <h3>Navigasi</h3>
                <ul>
                    <li><a href="#beranda"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><a href="#tentang"><i class="fas fa-info-circle"></i> Tentang Kami</a></li>
                    <li><a href="#"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</a></li>
                    <li><a href="#layanan"><i class="fas fa-cogs"></i> Pelayanan</a></li>
                    <li><a href="#"><i class="fas fa-box-open"></i> Produk</a></li>
                    <li><a href="#katalog"><i class="fas fa-th"></i> Katalog Produk</a></li>
                    <li><a href="#footer"><i class="fas fa-envelope"></i> Kontak</a></li>
                    <li><a href="#"><i class="fas fa-briefcase"></i> Karir</a></li>
                </ul>
            </div>

            <div class="footer-info">
                <h3>Informasi</h3>
                <p><i class="fas fa-map-marker-alt"></i> Lokasi : SMKN 1 Kota Bekasi </p>
                <p><i class="fas fa-envelope"></i> Email : info@jajanyuk.com</p>
                <p><i class="fas fa-phone"></i> Telepon : ( 021 ) 123-4567</p>
                <p><i class="fas fa-clock"></i> Jam Operasional : Kamis 30 Januari 2025 ( 06:30 - 11:30 WIB )</p>
            </div>

            <div class="footer-social">
                <h3>Ikuti Kami</h3>
                <ul>
                    <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="#"><i class="fab fa-youtube"></i> YouTube</a></li>
                </ul>
            </div>

            <div class="footer-payment">
                <h3>Pembayaran</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-credit-card"></i> Transfer Bank</a></li>
                    <li><a href="#"><i class="fas fa-wallet"></i> E - Monney</a></li>
                    <li><a href="#"><i class="fas fa-money-bill-wave"></i> Cash On Delivery</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Jajan Yuk. Semua Hak Cipta Dilindungi</p>
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
    <script src="CODES/JS/dashboard-scripts.js"></script>
</body>

</html>