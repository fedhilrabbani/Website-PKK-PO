<?php
include "assets/backend/db.php";
session_start();

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $sql = "INSERT INTO user_table (username, user_password) VALUES('$username', '$password_hashed')";

        if ($db -> query($sql)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success', // 
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
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Akun gagal dibuat',
                    showConfirmButton: true,
                });
            });
        </script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Username sudah digunakan!',
                    showConfirmButton: true,
                });
            });
        </script>";
    }
    $db -> close();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style5.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
            <img src="assets/images/icon.png" alt="" class="icon">
        </header>
        <form action="signup.php" method="POST">
            <input type="text" placeholder="Username" name="username" id="username">
            <input type="password" placeholder="Password" name="password" id="password">
            <input type="password" placeholder="Confirm Password" id="checkpassword" onclick="checkPassword()">
            <button type="submit" class="button" name="signup" onclick="confirmPassword()">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>