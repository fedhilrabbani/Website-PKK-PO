<?php
include "CODES/BACKEND/db.php";
session_start();

if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
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

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $query = "INSERT INTO users (username, password, kelas) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $username, $hashed_password, $kelas);

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
                    title: 'eror..',
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="CODES/JS/login-register-scripts.js"></script>
    <style>
        .hidepw:hover {
            cursor:pointer;
        }
    </style>
</head>

<body style="background-image: url('assets/images/background-login-register.jpg');">
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
                    <input type="text" placeholder="Nama Lengkap" name="username" id="username" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-graduation-cap"></i>
                    <input type="text" placeholder="Nama Kelas" name="kelas" required>
                </div>
                    <p style="margin:-10px 0 10px 0">(Ketik guru jika anda guru)</p>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" id="password" required>
                    <i class="hidepw fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                <p style="margin:-10px 0 10px 0">Buat password yang mudah diingat!</p>
                <button type="submit" class="button" name="signup" required>Daftar</button>
                <a href="index.php"><button type="button" class="button" name="">Masuk</button></a>
            </form>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            // Ubah tipe input antara 'password' dan 'text'
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ubah ikon antara mata terbuka dan tertutup
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
</html>