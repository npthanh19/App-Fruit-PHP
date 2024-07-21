<?php
$host = "localhost";
$username = "root";
$password = "12345678";
$dbname = "doan2"; 


$conn = mysqli_connect($host, $username, $password, $dbname);

mysqli_set_charset($conn, "utf8mb4");

if (!$conn) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}