<?php
session_start();
require '../../config/database.php';
require '../../classes/DanhMucSanPham.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
    if (isset($_GET['ma_danh_muc'])) {
    $ma_danh_muc = $_GET['ma_danh_muc'];
    $obj = new DanhMucSanPham();
    
    try {
        $obj->xoaDanhMucSanPham($conn, $ma_danh_muc);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa danh mục " . $ma_danh_muc);
        header('Location: ../index.php?p=danhmuc&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=danhmuc&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=danhmuc');
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'xoa_danh_muc')) {
    header('Location: ../index.php?p=danhmuc&quyen=null');
    exit();
}

if (isset($_GET['ma_danh_muc'])) {
    $ma_danh_muc = $_GET['ma_danh_muc'];
    $obj = new DanhMucSanPham();
    
    try {
        $obj->xoaDanhMucSanPham($conn, $ma_danh_muc);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa danh mục " . $ma_danh_muc);
        header('Location: ../index.php?p=danhmuc&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=danhmuc&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=danhmuc');
exit();
?>