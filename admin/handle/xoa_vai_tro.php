<?php
require '../../config/database.php';
require '../../classes/VaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

if (isset($_GET['id_vai_tro'])) {
    $id_vai_tro = $_GET['id_vai_tro'];
    $obj = new VaiTro();
    try {
        $obj-> xoaVaiTro($conn, $id_vai_tro);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa vai trò " .  $id_vai_tron);
        header('Location: ../index.php?p=vaitro&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=vaitro&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=vaitro');
exit();
?>