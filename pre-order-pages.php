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
                <a href="info-produk-pages.php" class="menu-link"><i class="fas fa-info-circle"></i></a>
            </nav>
        </header>

        <main class="main-content">
            <form id="preorder-form" class="preorder-form">
                <h2 class="form-title">Pre-Order Form</h2>

                <section class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" placeholder="Masukkan Nama Anda" required>
                </section>
                <section class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select id="jurusan" name="jurusan" required>
                        <option value="" disabled selected>Pilih Jurusan...</option>
                        <option value="PPLG">PPLG</option>
                        <option value="TKJT">TKJT</option>
                        <option value="DKV">DKV</option>
                        <option value="AKL">AKL</option>
                        <option value="BUSANA">Busana</option>
                        <option value="TKRO">TKRO</option>
                        <option value="TPFL">TPFL</option>
                        <option value="TPB">TPB</option>
                    </select>
                </section>
                <section class="form-group">
                    <label for="kelas">Kelas</label>
                    <select id="kelas" name="kelas" required>
                        <option value="" disabled selected>Pilih Kelas...</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </section>
                <section class="form-group">
                    <label for="telp">Nomer Telepon</label>
                    <input type="tel" id="telp" name="telp" placeholder="0812xxxxxxx" required>
                </section>
                <section class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="email@gmail.com" required>
                </section>
                <section class="form-group">
                    <label for="payment">Metode Pembayaran</label>
                    <select id="payment" name="payment" required>
                        <option value="" disabled selected>Pilih Metode Pembayaran...</option>
                        <option value="Cash">Cash</option>
                        <option value="Cashless">Cashless</option>
                    </select>
                </section>

                <div class="product-item">
                    <h4>Produk Minuman</h4>
                    <ul>
                        <li><strong>Deskripsi :</strong> Minuman segar dengan rasa alami buah-buahan.</li>
                        <li><strong>Ukuran :</strong> 500 ml</li>
                        <li><strong>Suhu :</strong> Dingin</li>
                        <li><strong>Deskripsi Rasa :</strong> Manis dan menyegarkan.</li>
                        <li><strong>Deskripsi Gizi :</strong> Mengandung vitamin C, rendah kalori.</li>
                        <li><strong>Harga :</strong> Rp 25,000</li>
                    </ul>
                </div>
                <div class="product-item">
                    <h4>Produk Makanan</h4>
                    <ul>
                        <li><strong>Deskripsi :</strong> Makanan ringan dengan rasa gurih khas nusantara.</li>
                        <li><strong>Ukuran Porsi :</strong> 250 gram</li>
                        <li><strong>Tingkat Pedas :</strong> Sedang</li>
                        <li><strong>Deskripsi Rasa :</strong> Gurih dan kaya bumbu.</li>
                        <li><strong>Deskripsi Gizi :</strong> Protein tinggi, karbohidrat kompleks.</li>
                        <li><strong>Harga :</strong> Rp 50,000</li>
                    </ul>
                </div>

                <div class="total-harga">
                    <span>Total Harga: <strong>Rp 75,000</strong></span>
                </div>
                <button type="button" id="submit-order" class="submit-button">Pesan Sekarang</button>
            </form>

            <div id="order-summary" class="order-summary hidden">
                <h2>Rincian Pesanan</h2>
                <p><strong>Nama :</strong> <span id="order-summary-name"></span></p>
                <p><strong>Jurusan :</strong> <span id="order-summary-jurusan"></span></p>
                <p><strong>Kelas :</strong> <span id="order-summary-kelas"></span></p>
                <p><strong>Nomer Telepon :</strong> <span id="order-summary-telp"></span></p>
                <p><strong>Email :</strong> <span id="order-summary-email"></span></p>
                <p><strong>Metode Pembayaran :</strong> <span id="order-summary-payment"></span></p>
                <div class="product-item">
                    <ul>
                        <li><strong>Produk Minuman :</strong> Rp 25,000</li>
                        <li><strong>Produk Makanan :</strong> Rp 50,000</li>
                    </ul>
                </div>
                <div class="total-harga">
                    <span>Total Harga : <strong>Rp 75,000</strong></span>
                </div>
                <button id="proceed-to-transaction" class="pay-button">Lanjutkan ke Transaksi</button>
            </div>

            <div class="transaction-summary hidden" id="transaction-summary">
                <h2>Rincian Transaksi</h2>
                <p><strong>Tanggal :</strong> <span id="transaction-date"></span></p>
                <p><strong>No. Transaksi :</strong> <span id="transaction-id"></span></p>
                <p><strong>Metode Pembayaran :</strong> <span id="transaction-payment"></span></p>
                <p><strong>Asal Rekening :</strong> <span id="transaction-origin"></span></p>
                <p><strong>Tujuan Rekening :</strong> <span id="transaction-destination">1234567890 (Jajan Yuk!)</span></p>
                <p><strong>Total Bayar :</strong> Rp 75,000</p>
                <button class="pay-button" id="pay-button">Bayar Sekarang</button>
            </div>

            <div id="receipt" class="receipt hidden">
                <h2>Struk Pembayaran</h2>
                <p><strong>Nama :</strong> <span id="receipt-name"></span></p>
                <p><strong>Nomor Transaksi :</strong> <span id="receipt-transaction"></span></p>
                <p><strong>Tanggal :</strong> <span id="receipt-date"></span></p>
                <p><strong>Total Harga :</strong> Rp 75,000</p>
                <p><strong>Status :</strong> Lunas</p>
                <button id="new-order" class="new-order-button">Pesan Lagi</button>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; 2025 Jajan Yuk! All Rights Reserved.</p>
        </footer>
    </div>
    <script src="CODES/JS/pre-order-pages-scripts.js" defer></script>
</body>

</html>