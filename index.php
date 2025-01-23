<?php
include "CODES/BACKEND/db.php";
session_start();

if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gunakan prepared statement untuk menghindari SQL injection
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $username); // "s" untuk string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $data['password'])) {
            // Simpan data ke sesi
            $_SESSION['user_id'] = $data['id']; // Simpan ID pengguna untuk konsistensi
            $_SESSION['username'] = $data['username']; // Simpan nama pengguna jika perlu
            $_SESSION["is_login"] = true;
            header('location: dashboard.php'); // Redirect ke dashboard
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