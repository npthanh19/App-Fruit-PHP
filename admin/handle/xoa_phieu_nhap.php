<?php
require '../../config/database.php';
require '../../classes/PhieuNhapHang.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
   if (isset($_GET['id_phieu_nhap'])) {
    $id_phieu_nhap = $_GET['id_phieu_nhap'];
    $obj = new PhieuNhapHang();
    try {
        $obj-> xoaPhieuNhapHang($conn, $id_phieu_nhap);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa phiếu nhập " . $id_phieu_nhap);
        header('Location: ../index.php?p=phieunhaphang&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=phieunhaphang&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=phieunhaphang');
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'xoa_nha_phieu_nhap')) {
    header('Location: ../index.php?p=phieunhaphang&quyen=null');
    exit();
}

if (isset($_GET['id_phieu_nhap'])) {
    $id_phieu_nhap = $_GET['id_phieu_nhap'];
    $obj = new PhieuNhapHang();
    try {
        $obj-> xoaPhieuNhapHang($conn, $id_phieu_nhap);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa phiếu nhập " . $id_phieu_nhap);
        header('Location: ../index.php?p=phieunhaphang&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=phieunhaphang&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=phieunhaphang');
exit();
?>