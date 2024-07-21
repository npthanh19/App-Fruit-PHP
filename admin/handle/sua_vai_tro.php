<?php
session_start();
require '../../config/database.php';
require '../../classes/VaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

if (isset($_POST['suaVaiTro'])) {
    $id_vai_tro = $_POST['id_vai_tro'];
    $ten_vai_tro = $_POST['ten_vai_tro'];
    $chucNang = $_POST['chuc_nang'] ?? [];
    $id_tai_khoan = $_SESSION['id_tai_khoan'];

    
    

    $vaitro = new VaiTro();
    $vaitro->suaVaiTro($conn, $id_vai_tro, $id_tai_khoan, $ten_vai_tro, $chucNang);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa vai trò " .$ten_vai_tro,);
}

header('Location: ../index.php?p=vaitro');
exit();