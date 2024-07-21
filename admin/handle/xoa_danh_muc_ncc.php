<?php
session_start();
require '../../config/database.php';
require '../../classes/DanhMucNhaCungCap.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
    if (isset($_GET['ma_danh_muc'])) {
    $ma_danh_muc = $_GET['ma_danh_muc'];
    $obj = new DanhMucNhaCungCap();
    
    try {
        $obj->xoaDanhMucNhaCungCap($conn, $ma_danh_muc);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa danh mục nhà cung cấp " . $ma_danh_muc);
        header('Location: ../index.php?p=danhmucncc&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=danhmucncc&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=danhmucncc');
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'cap_nhat_hang_ton')) {
    header('Location: ../index.php?p=danhmucncc&quyen=null');
    exit();
}

if (isset($_GET['ma_danh_muc'])) {
    $ma_danh_muc = $_GET['ma_danh_muc'];
    $obj = new DanhMucNhaCungCap();
    
    try {
        $obj->xoaDanhMucNhaCungCap($conn, $ma_danh_muc);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa danh mục nhà cung cấp " . $ma_danh_muc);
        header('Location: ../index.php?p=danhmucncc&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=danhmucncc&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=danhmucncc');
exit();
?>