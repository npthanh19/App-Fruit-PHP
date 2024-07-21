<?php
session_start();
require '../../config/database.php';
require '../../classes/NhaCungCap.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
    $obj = new NhaCungCap();
if (isset($_POST['suaNhaCungCap'])) {
    $ma_nha_cung_cap = $_POST['ma_nha_cung_cap'];
    $ten_nha_cung_cap = $_POST['ten_nha_cung_cap'];
    $dia_chi = $_POST['dia_chi'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $email = $_POST['email'];
    $ma_danh_muc = $_POST['ma_danh_muc'];
    
    $obj->suaNhaCungCap($conn, $ma_nha_cung_cap, $ten_nha_cung_cap, $dia_chi, $so_dien_thoai, $email, $ma_danh_muc);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa nhà cung cấp " .$ten_nha_cung_cap);
}

header('Location: ../index.php?p=nhacungcap');
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'cap_nhat_hang_ton')) {
    header('Location: ../index.php?p=nhacungcap&quyen=null');
    exit();
}
$obj = new NhaCungCap();
if (isset($_POST['suaNhaCungCap'])) {
    $ma_nha_cung_cap = $_POST['ma_nha_cung_cap'];
    $ten_nha_cung_cap = $_POST['ten_nha_cung_cap'];
    $dia_chi = $_POST['dia_chi'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $email = $_POST['email'];
    $ma_danh_muc = $_POST['ma_danh_muc'];
    
    $obj->suaNhaCungCap($conn, $ma_nha_cung_cap, $ten_nha_cung_cap, $dia_chi, $so_dien_thoai, $email, $ma_danh_muc);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa nhà cung cấp " .$ten_nha_cung_cap);
}

header('Location: ../index.php?p=nhacungcap');
exit();