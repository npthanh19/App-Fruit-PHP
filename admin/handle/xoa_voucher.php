<?php
require '../../config/database.php';
require '../../classes/Voucher.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

if (isset($_GET['id_voucher'])) {
    $id_voucher = $_GET['id_voucher'];
    $obj = new Voucher();
    try {
        $obj-> xoaVoucher($conn, $id_voucher);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa voucher " .  $id_voucher);
        header('Location: ../index.php?p=voucher&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=voucher&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=voucher');
exit();
?>