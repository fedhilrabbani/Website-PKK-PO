<?php 
include "CODES/BACKEND/db.php";
session_start();

// Proses Logout
if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit;
}

// Periksa apakah pengguna sudah login dan memiliki hak akses admin
if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true || $_SESSION["role"] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Proses Hapus Produk
if(isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    
    // Ambil nama gambar untuk dihapus dari file
    $sql_gambar = "SELECT gambar FROM foods WHERE foods_id = ?";
    $stmt_gambar = $db->prepare($sql_gambar);
    $stmt_gambar->bind_param("i", $id);
    $stmt_gambar->execute();
    $result_gambar = $stmt_gambar->get_result();
    $row_gambar = $result_gambar->fetch_assoc();

    // Hapus gambar dari folder
    if (!empty($row_gambar['gambar']) && file_exists($row_gambar['gambar'])) {
        unlink($row_gambar['gambar']);
    }

    // Hapus produk dari database
    $sql = "DELETE FROM foods WHERE foods_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        $_SESSION['success_message'] = "Produk berhasil dihapus!";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus produk!";
    }
    
    header("Location: daftar_produk.php");
    exit;
}

// Ambil daftar produk
$sql = "SELECT * FROM foods ORDER BY foods_id DESC";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Daftar Produk</h2>
                
                <!-- Tombol Tambah Produk Baru -->
                <!-- <a href="tambah_produk.php" class="btn btn-primary mb-3">Tambah Produk Baru</a> -->
                <a href="admin-riwayat-po.php" class="btn btn-primary mb-3">Riwayat Pre Order</a>

                <!-- Pesan Sukses/Error -->
                <?php if(isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success_message'] ?>
                        <?php unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error_message'] ?>
                        <?php unset($_SESSION['error_message']); ?>
                    </div>
                <?php endif; ?>

                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Tipe Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['foods_id'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= substr($row['deskripsi'], 0, 50) ?>...</td>
                                <td>Rp. <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td><?= $row['product_type'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Logout Form -->
                <form action="" method="post">
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfirmasi Hapus dengan SweetAlert
        const tombolHapus = document.querySelectorAll('.btn-hapus');
        tombolHapus.forEach(tombol => {
            tombol.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus produk ${nama}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `daftar_produk.php?hapus=${id}`;
                    }
                });
            });
        });
    });
    </script>
</body>
</html>