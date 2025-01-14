<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CODES/CSS/pre-order-pages-styles.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
            <img src="assets/images/arrow-back.png" alt="" class="icon">
        </header>
        <form action="">
            <div class="informasi-user">
                <div class="pemisah">
                    <label for="usertxt">Nama : </label>
                    <input type="text" name="usertxt">
                </div>
                <div class="pemisah">
                    <label for="sbjurusan">Jurusan: </label>
                    <select name="sbjurusan" id="sbjurusan">
                        <option value="" disabled selected>Pilih Jurusan...</option>
                        <option value="">PPLG</option>
                        <option value="">TKJT</option>
                        <option value="">DKV</option>
                        <option value="">AKL</option>
                        <option value="">BUSANA</option>
                        <option value="">TKRO</option>
                        <option value="">TPFL</option>
                        <option value="">TPB</option>
                    </select>
                </div>
                <div class="pemisah">
                    <label for="sbkelas">Kelas : </label>
                    <select name="sbkelas" id="sbkelas">
                        <option value="" disabled selected>Pilih Kelas...</option>
                        <option value="">10</option>
                        <option value="">11</option>
                        <option value="">12</option>
                    </select>
                </div>
                <div class="pemisah">
                    <label for="no-telp">No. Telp : </label>
                    <input type="number" name="no-telp">
                </div>
                <div class="pemisah">
                    <label for="payment">Metode Pembayaran : </label>
                    <select name="payment" id="payment">
                        <option value="" disabled selected>Pilih Pembayaran...</option>
                        <option value="">Cash</option>
                        <option value="">Cashless</option>
                    </select>
                </div>
            </div>
            <div class="info-harga">
                <div class="produk1">
                    <div class="nama-jumlah">
                        <p class="font-biasa">Nama Produk</p>
                        <p class="font-biasa">*1 (jumlah barang)</p>
                    </div>
                    Harga
                </div>
                <div class="produk1">
                    <div class="nama-jumlah">
                        <p class="font-biasa">Nama Produk</p>
                        <p class="font-biasa">*1 (jumlah barang)</p>
                    </div>
                    Harga
                </div>
                <hr>
                <div class="total-harga">
                    <p class="font-biasa">Harga :</p>
                    <p class="font-biasa">Rp 00000</p>
                </div>
            </div>
            <button type="submit" name="submit" class="button">Pesan</button>
        </form>
    </div>
</body>
</html>