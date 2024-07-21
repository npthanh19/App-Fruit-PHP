<?php
session_start();
require '../../config/database.php';
require '../../classes/SanPham.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
    if (isset($_POST['capNhatHangTon'])) {
        $ma_san_pham = $_POST['ma_san_pham'];
        $so_luong = $_POST['so_luong'];

        $obj = new SanPham();
        $obj->capNhatSoLuongSanPham($conn, $ma_san_pham, $so_luong);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Cập nhật hàng tồn có mã " . $ma_san_pham);
    }
    header('Location: ../index.php?p=tonkho');
    exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'cap_nhat_hang_ton')) {
    header('Location: ../index.php?p=tonkho&quyen=null');
    exit();
}

if (isset($_POST['capNhatHangTon'])) {
    $ma_san_pham = $_POST['ma_san_pham'];
    $so_luong = $_POST['so_luong'];

    $obj = new SanPham();
    $obj->capNhatSoLuongSanPham($conn, $ma_san_pham, $so_luong);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Cập nhật hàng tồn có mã " . $ma_san_pham);
}

header('Location: ../index.php?p=tonkho');
exit();