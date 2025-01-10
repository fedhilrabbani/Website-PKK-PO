<?php
include "assets/backend/db.php";
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_table WHERE username = '$username'";
    $result = $db -> query($sql);
    
    if ($result -> num_rows > 0) {
        $data = $result -> fetch_assoc();
        if (password_verify($password, $data['user_password'])) {
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
    <link rel="stylesheet" href="assets/css/style5.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
            <img src="assets/images/icon.png" alt="" class="icon">
        </header>
        <form action="index.php" method="POST">
            <input type="text" placeholder="Username" name="username" id="username">
            <input type="password" placeholder="Password" name="password" id="password">
            <button type="submit" class="button" name="login" onclick="">Login</button>
            <a href="signup.php" class="font-biasa">Don't have account?</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>