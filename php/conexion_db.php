<?php
$servername = "localhost";
$username = "root";
$password = "superadmin";
$dbname = "la_fortaleza_ca";
$port = "3306";

$connect = new mysqli($servername,$username,$password,$dbname,$port);
$connect->set_charset("utf8");

if ($connect->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>