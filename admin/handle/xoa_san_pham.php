<?php
session_start();
require '../../config/database.php';
require '../../classes/SanPham.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
   if (isset($_GET['ma_san_pham'])) {
    $ma_san_pham = $_GET['ma_san_pham'];
    $obj = new SanPham();
    echo $ma_san_pham;
    try {
        $obj->xoasanpham($conn, $ma_san_pham);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa sản phẩm " .  $ma_san_pham);
        header('Location: ../index.php?p=sanpham&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=sanpham&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=sanpham');
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'xoa_san_pham')) {
    header('Location: ../index.php?p=sanpham&quyen=null');
    exit();
}

if (isset($_GET['ma_san_pham'])) {
    $ma_san_pham = $_GET['ma_san_pham'];
    $obj = new SanPham();
    echo $ma_san_pham;
    try {
        $obj->xoasanpham($conn, $ma_san_pham);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa sản phẩm " .  $ma_san_pham);
        header('Location: ../index.php?p=sanpham&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=sanpham&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=sanpham');
exit();