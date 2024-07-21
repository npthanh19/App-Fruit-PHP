<?php
session_start();
require '../../config/database.php';
require '../../classes/NhaCungCap.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
   if (isset($_GET['ma_nha_cung_cap'])) {
    $ma_nha_cung_cap = $_GET['ma_nha_cung_cap'];
    $obj = new NhaCungCap();
    try {
        $obj-> xoaNhaCungCap($conn, $ma_nha_cung_cap);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa nhà cung cấp " . $ma_nha_cung_cap);
        header('Location: ../index.php?p=nhacungcap&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=nhacungcap&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=nhacungcap');
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'xoa_nha_cung_cap')) {
    header('Location: ../index.php?p=nhacungcap&quyen=null');
    exit();
}

if (isset($_GET['ma_nha_cung_cap'])) {
    $ma_nha_cung_cap = $_GET['ma_nha_cung_cap'];
    $obj = new NhaCungCap();
    try {
        $obj-> xoaNhaCungCap($conn, $ma_nha_cung_cap);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Xóa nhà cung cấp " . $ma_nha_cung_cap);
        header('Location: ../index.php?p=nhacungcap&delete_success=true');
        exit();
    } catch (Exception $e) {
        header('Location: ../index.php?p=nhacungcap&delete_error=true');
        exit();
    }
}

header('Location: ../index.php?p=nhacungcap');
exit();
?>