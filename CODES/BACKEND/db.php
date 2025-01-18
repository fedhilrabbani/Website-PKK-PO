<?php

$hostname = "localhost";
$username = "dbpkk";
$password = "dbprojekpkk2025?";
$database_name = "dbpkk";

$db = mysqli_connect($hostname, $username, $password, $database_name);

if($db -> connect_error){
    echo "Koneksi database rusak!";
    die("error!");
}

?>
