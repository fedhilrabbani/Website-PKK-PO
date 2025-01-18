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
    <link rel="stylesheet" href="CODES/CSS/login-register-pages.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <header>
            <img src="assets/images/icon.png" alt="" class="icon">
        </header>
        <form action="signup.php" method="POST">
            <input type="text" placeholder="Username" name="username" id="username">
            <input type="text" placeholder="Kelas" name="kelas">
            <input type="email" placeholder="Email" name="emailuser">
            <input type="password" placeholder="Password" name="password" id="password">
            <input type="password" placeholder="Confirm Password" id="checkpassword" onclick="checkPassword()">
            <button type="submit" class="button" name="signup" onclick="confirmPassword()">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="CODES/JS/login-register-scripts.js"></script>
</body>
</html>