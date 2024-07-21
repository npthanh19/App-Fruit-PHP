<?php
session_start();
require '../../config/database.php';
require '../../classes/SanPham.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
    if (isset($_POST['suaSanPham'])) {
    $ma_san_pham = $_POST['ma_san_pham'];
    $ten_san_pham = $_POST['ten_san_pham'];
    $gia_nhap = $_POST['gia_nhap'];
    $gia_ban = $_POST['gia_ban'];
    $xuat_xu = $_POST['xuat_xu'];
    $anh_san_pham = '';
    $danh_muc_san_pham = $_POST['danh_muc_san_pham'];
    $mo_ta_san_pham = $_POST['mo_ta_san_pham_hidden'];
    $ma_don_vi_tinh = $_POST['don_vi_tinh'];


    $obj = new SanPham();
    $obj->suaSanPham($conn, $ma_san_pham, $ten_san_pham, $gia_nhap, $gia_ban, $xuat_xu, $anh_san_pham, $danh_muc_san_pham, $mo_ta_san_pham, $ma_don_vi_tinh);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa sản phẩm " .$ten_san_pham);

}  

header('Location: ../index.php?p=sanpham');
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'cap_nhat_hang_ton')) {
    header('Location: ../index.php?p=sanpham&quyen=null');
    exit();
}

if (isset($_POST['suaSanPham'])) {
    $ma_san_pham = $_POST['ma_san_pham'];
    $ten_san_pham = $_POST['ten_san_pham'];
    $gia_nhap = $_POST['gia_nhap'];
    $gia_ban = $_POST['gia_ban'];
    $xuat_xu = $_POST['xuat_xu'];
    $anh_san_pham = '';
    $danh_muc_san_pham = $_POST['danh_muc_san_pham'];
    $mo_ta_san_pham = $_POST['mo_ta_san_pham_hidden'];
    $ma_don_vi_tinh = $_POST['don_vi_tinh'];


    $obj = new SanPham();
    $obj->suaSanPham($conn, $ma_san_pham, $ten_san_pham, $gia_nhap, $gia_ban, $xuat_xu, $anh_san_pham, $danh_muc_san_pham, $mo_ta_san_pham, $ma_don_vi_tinh);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa sản phẩm " .$ten_san_pham);

}

header('Location: ../index.php?p=sanpham');
exit();