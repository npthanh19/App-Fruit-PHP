<?php
include('../config/database.php');
$username = $_SESSION['username'];
$query = "SELECT role FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$role = $row['role'];

if ($role !== 'admin' || $role !== 'nhanvien') {
    header("Location: index.php");
    exit;
}
?>