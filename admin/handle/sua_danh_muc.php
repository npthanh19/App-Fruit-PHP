<?php
session_start();
require '../../config/database.php';
require '../../classes/DanhMucSanPham.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
    if (isset($_POST['suaDanhMuc'])) {
    $ma_danh_muc = $_POST['ma_danh_muc'];
    $ten_danh_muc = $_POST['ten_danh_muc'];
    
    $obj = new DanhMucSanPham();
    $obj->suaDanhMucSanPham($conn, $ma_danh_muc, $ten_danh_muc);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa danh mục " .$ten_danh_muc);
}

header('Location: ../index.php?p=danhmuc');
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'cap_nhat_hang_ton')) {
    header('Location: ../index.php?p=danhmuc&quyen=null');
    exit();
}
if (isset($_POST['suaDanhMuc'])) {
    $ma_danh_muc = $_POST['ma_danh_muc'];
    $ten_danh_muc = $_POST['ten_danh_muc'];
    
    $obj = new DanhMucSanPham();
    $obj->suaDanhMucSanPham($conn, $ma_danh_muc, $ten_danh_muc);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa danh mục " .$ten_danh_muc);
}

header('Location: ../index.php?p=danhmuc');
exit();
?>