<?php

// INI ADALAH KODE UNTUK LOGOUT

session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit;
?>
