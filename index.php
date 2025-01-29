<?php
include "CODES/BACKEND/db.php";
session_start();

if (isset($_SESSION["is_login"])) {
    // Cek role untuk menentukan redirect
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header("location: admin-dashboard.php");
        exit;
    } else {
        // Jika bukan admin, redirect ke dashboard user
        header("location: dashboard.php");
        exit;
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek di tabel admin
    $sql_admin = "SELECT * FROM admin WHERE username_admin = ?";
    $stmt_admin = $db->prepare($sql_admin);
    $stmt_admin->bind_param("s", $username);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        // Admin ditemukan
        $admin_data = $result_admin->fetch_assoc();

        // Verifikasi password admin menggunakan password_verify
        if (password_verify($password, $admin_data['password_admin'])) {
            // Set session untuk admin
            $_SESSION['id_admin'] = $admin_data['id_admin'];
            $_SESSION['username'] = $username;
            $_SESSION['is_login'] = true;
            $_SESSION['role'] = 'admin';

            // Redirect ke halaman admin dashboard
            header('location: admin-dashboard.php');
            exit;
        } else {
            // Password admin salah
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Password admin salah!',
                        showConfirmButton: true,
                    });
                });
            </script>";
        }
    } else {
        // Jika bukan admin, cek di tabel users
        $sql_user = "SELECT * FROM users WHERE username = ?";
        $stmt_user = $db->prepare($sql_user);
        $stmt_user->bind_param("s", $username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows > 0) {
            $user_data = $result_user->fetch_assoc();

            // Verifikasi password user
            if (password_verify($password, $user_data['password'])) {
                // Simpan data ke sesi
                $_SESSION['user_id'] = $user_data['id'];
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['is_login'] = true;
                $_SESSION['role'] = 'user';

                // Redirect ke dashboard user
                header('location: dashboard.php');
                exit;
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Password salah!',
                            showConfirmButton: true,
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Username tidak ditemukan!',
                        showConfirmButton: true,
                    });
                });
            </script>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
        <link rel="stylesheet" href="CODES/CSS/sign-in-pages-styles.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="CODES/JS/login-register-scripts.js"></script>
        <title>Sign - In Marketopia !</title>
        <style>
        .hidepw:hover {
            cursor:pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Bergabung</h2>
            <form action="index.php" method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Nama Lengkap" name="username" id="username" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" id="password" required>
                    <i class="hidepw fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                <button type="submit" class="button" name="login" onclick="">Masuk</button>
                <a href="signup.php" class="font-biasa">Belum Memiliki Akun?</a>
            </form>
        </div>
    </div>
</body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                // Toggle tipe input
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePassword.classList.remove('fa-eye');
                    togglePassword.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    togglePassword.classList.remove('fa-eye-slash');
                    togglePassword.classList.add('fa-eye');
                }
            });
        });
    </script>

</html>