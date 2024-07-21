<?php
require '../../config/database.php';
require '../../classes/Admin.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

if (isset($_GET['id_tai_khoan'])) {
    $id_tai_khoan = $_GET['id_tai_khoan'];
    $obj = new Admin();
    try {
        $obj-> xoaTaiKhoan($conn, $id_tai_khoan);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa tài khoản " .  $id_tai_khoan);
        header('Location: ../index.php?p=nhanvien&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=nhanvien&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=nhanvien');
exit();
?>