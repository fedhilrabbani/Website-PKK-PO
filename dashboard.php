<?php
include "assets/backend/db.php";
session_start();

$datamakanan;
$dataminuman;

$sql = "SELECT * FROM makanan_table";
$result = $db->query($sql);
if ($result -> num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datamakanan [] = [
            'nama' => $row['nama_makanan']
        ];
    }
    $_SESSION['list_makanan'] = $datamakanan;
}
$sql2 = "SELECT * FROM minuman_table";
$result2 = $db->query($sql2);
if ($result2 -> num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $dataminuman [] = [
            'nama' => $row2['nama_minuman']
        ];
    }
    $_SESSION['list_minuman'] =$dataminuman;
}

$db->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style1.css">
</head>
<body>
    <header>
        <img src="assets/images/icon.png" alt="" class="icon2">
        <img src="assets/images/cart.png" alt="" class="icon">
    </header>
    <div class="container">
        <p class="judul">Makanan</p>
        <div class="content">
            <!-- isi konten makanan -->
            <?php foreach ($datamakanan as $makanan) { ?>
                <div class="item">
                    <div class="image"></div>
                    <div class="info">
                        <p class="font-biasa nama-makanan"><?=$makanan['nama']?></p>
                        <p class="font-biasa">Harga</p>
                    </div>
                </div>
            <?php }?>
        </div>
        <p class="judul">Minuman</p>
        <div class="content">
            <!-- isi konten minuman -->
            <?php foreach ($dataminuman as $minuman) { ?>
                <div class="item">
                    <div class="image"></div>
                    <div class="info">
                        <p class="font-biasa nama-makanan"><?=$minuman['nama']?></p>
                        <p class="font-biasa">Harga</p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>