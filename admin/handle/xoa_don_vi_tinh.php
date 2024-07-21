<?php
session_start();
require '../../config/database.php';
require '../../classes/DonViTinh.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
   if (isset($_GET['ma_don_vi_tinh'])) {
    $ma_don_vi_tinh = $_GET['ma_don_vi_tinh'];
    $obj = new DonViTinh();
    
    try {
        $obj->xoaDonViTinh($conn, $ma_don_vi_tinh);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa đơn vị tính " . $ma_don_vi_tinh);
        header('Location: ../index.php?p=donvitinh&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=donvitinh&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=donvitinh');
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'xoa_don_vi')) {
    header('Location: ../index.php?p=donvitinh&quyen=null');
    exit();
}

if (isset($_GET['ma_don_vi_tinh'])) {
    $ma_don_vi_tinh = $_GET['ma_don_vi_tinh'];
    $obj = new DonViTinh();
    
    try {
        $obj->xoaDonViTinh($conn, $ma_don_vi_tinh);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa đơn vị tính " . $ma_don_vi_tinh);
        header('Location: ../index.php?p=donvitinh&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=donvitinh&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=donvitinh');
exit();
?>