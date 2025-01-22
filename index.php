<?php
include "CODES/BACKEND/db.php";
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        if (password_verify($password, $data['password'])) {
            $_SESSION['username'] = $data['username'];
            header('location: dashboard.php');
            exit;
        }
    } else {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Username atau Password tidak ditemukan!',
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
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="shortcut icon" href="ASSETS/IMAGES/icon.png" type="image/x-icon">
        <link rel="stylesheet" href="CODES/CSS/sign-in-pages-styles.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="CODES/JS/login-register-scripts.js"></script>
        <title>Sign - In Jajan Yuk !</title>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Bergabung</h2>
            <form action="index.php" method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Username" name="username" id="username" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" id="password" required>
                </div>
                <button type="submit" class="button" name="login" onclick="">Masuk</button>
                <a href="signup.php" class="font-biasa">Belum Memiliki Akun?</a>
            </form>
        </div>
    </div>
</body>

</html>