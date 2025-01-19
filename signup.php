<?php
include "CODES/BACKEND/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['emailuser'];
    $kelas = $_POST['kelas'];

    $errors = [];

    if (empty($username)) {
        $errors[] = "Username tidak boleh kosong.";
    }

    $query_username = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($query_username);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Username sudah digunakan.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $query = "INSERT INTO users (username, email, password, kelas) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $kelas);

        if ($stmt->execute()) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Akun Berhasil Dibuat!',
                        showConfirmButton: true,
                    }).then((result) => { 
                        if (result.isConfirmed) {
                            window.location.href = 'index.php'; 
                        }
                    });
                });
            </script>";
        } else {
            $errors[] = "Gagal menyimpan data pengguna.";
        }
    }

    if (!empty($errors)) {
        $error_message = implode('<br>', $errors);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Lawak lu...',
                    html: '$error_message',
                    showConfirmButton: true,
                });
            });
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign - Up Marketopia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CODES/CSS/sign-up-pages-styles.css">
</head>

<body>
    <div class="container">
        <div class="welcome-container">
            <h1>Selamat Datang di Platform Kami !</h1>
            <p>Bergabunglah Sebelum Melakukan Transaksi Pembelian Produk Makanan & Minuman Di Platform Kami</p>
        </div>
        <div class="form-container">
            <h2>Mulai Bergabung ?</h2>
            <form action="signup.php" method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Username" name="username" id="username" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-graduation-cap"></i>
                    <input type="text" placeholder="Kelas" name="kelas" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email" name="emailuser" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" id="password" required onclick="checkPassword()">
                </div>
                <div class="input-group">
                    <i class="fas fa-check-circle"></i>
                    <input type="password" placeholder="Konfirmasi Password" id="checkpassword" required onclick="confirmPassword()">
                </div>
                <button type="submit" class="button" name="signup">Daftar</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="CODES/JS/login-register-scripts.js"></script>
</body>

</html>