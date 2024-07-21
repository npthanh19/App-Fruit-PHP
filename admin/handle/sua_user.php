<?php
require '../../config/database.php';
require '../../classes/Admin.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

if (isset($_POST['suaUser'])) {
    $ten_tai_khoan = $_POST['ten_tai_khoan'];
    $mat_khau = $_POST['mat_khau'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $loai_tai_khoan = $_POST['loai_tai_khoan'];
    
    $obj = new Admin();
}

header('Location: ../index.php?p=nhanvien');
exit();
?>