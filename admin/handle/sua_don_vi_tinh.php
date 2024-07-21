<?php
session_start();
require '../../config/database.php';
require '../../classes/DonViTinh.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
    if (isset($_POST['suaDonViTinh'])) {
    $ma_don_vi_tinh = $_POST['ma_don_vi_tinh'];
    $ten_don_vi_tinh = $_POST['ten_don_vi_tinh'];
    
    $obj = new DonViTinh();
    $obj->suaDonViTinh($conn, $ma_don_vi_tinh, $ten_don_vi_tinh);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa đơn vị tính " .$ten_don_vi_tinh);
}

header('Location: ../index.php?p=donvitinh');
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'cap_nhat_hang_ton')) {
    header('Location: ../index.php?p=donvitinh&quyen=null');
    exit();
}
if (isset($_POST['suaDonViTinh'])) {
    $ma_don_vi_tinh = $_POST['ma_don_vi_tinh'];
    $ten_don_vi_tinh = $_POST['ten_don_vi_tinh'];
    
    $obj = new DonViTinh();
    $obj->suaDonViTinh($conn, $ma_don_vi_tinh, $ten_don_vi_tinh);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa đơn vị tính " .$ten_don_vi_tinh);
}

header('Location: ../index.php?p=donvitinh');
exit();
?>