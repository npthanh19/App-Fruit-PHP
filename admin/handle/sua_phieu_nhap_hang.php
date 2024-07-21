<?php
require '../../config/database.php';
require '../../classes/PhieuNhapHang.php';
require("../../classes/SanPham.php");
require '../../classes/NhaCungCap.php';
require '../../classes/ChiTietVaiTro.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$id_tai_khoan = $_SESSION['id_tai_khoan'];
if ($_SESSION['id_tai_khoan'] === "1684481330") {
    $phieuNhapObj = new PhieuNhapHang();

if (isset($_POST['suaPhieuNhap'])) {
    $id_phieu_nhap = $_POST['id_phieu_nhap'];
    $ngay_nhap = $_POST['ngay_nhap'];
    $nguoi_tao = $_POST['nguoi_tao'];
    $ghi_chu = $_POST['ghi_chu'];
    $nha_cung_cap = $_POST['nha_cung_cap'];

    $orderDetails = [];
    if (isset($_POST['ma_san_pham']) && isset($_POST['so_luong']) && isset($_POST['gia_nhap'])) {
        $ma_san_pham = $_POST['ma_san_pham'];
        $so_luong_nhap = $_POST['so_luong'];
        $gia_nhap = $_POST['gia_nhap'];

        foreach ($ma_san_pham as $key => $ma) {
            $orderDetails[] = [
                'ma_san_pham' => $ma,
                'so_luong_nhap' => $so_luong_nhap[$key],
                'gia_nhap' => $gia_nhap[$key]
            ];
        }
    }

    $phieu_nhap = array(
        "ngay_nhap" => $ngay_nhap,
        "nguoi_tao" => $nguoi_tao,
        "ghi_chu" => $ghi_chu,
        "ma_nha_cung_cap" => $nha_cung_cap,
        "orderDetails" => $orderDetails
    );
    

    $phieuNhapObj->suaPhieuNhapHang($conn, $id_phieu_nhap, $phieu_nhap);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa phiếu nhập hàng " .$id_phieu_nhap);
}
header('Location: ../index.php?p=suaphieunhaphang&id='.$id_phieu_nhap);
exit();
}

$objChiTietVaiTro = new ChiTietVaiTro();
if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $id_tai_khoan, 'cap_nhat_hang_ton')) {
    header('Location: ../index.php?p=suaphieunhaphang&quyen=null');
    exit();
}
$phieuNhapObj = new PhieuNhapHang();

if (isset($_POST['suaPhieuNhap'])) {
    $id_phieu_nhap = $_POST['id_phieu_nhap'];
    $ngay_nhap = $_POST['ngay_nhap'];
    $nguoi_tao = $_POST['nguoi_tao'];
    $ghi_chu = $_POST['ghi_chu'];
    $nha_cung_cap = $_POST['nha_cung_cap'];

    $orderDetails = [];
    if (isset($_POST['ma_san_pham']) && isset($_POST['so_luong']) && isset($_POST['gia_nhap'])) {
        $ma_san_pham = $_POST['ma_san_pham'];
        $so_luong_nhap = $_POST['so_luong'];
        $gia_nhap = $_POST['gia_nhap'];

        foreach ($ma_san_pham as $key => $ma) {
            $orderDetails[] = [
                'ma_san_pham' => $ma,
                'so_luong_nhap' => $so_luong_nhap[$key],
                'gia_nhap' => $gia_nhap[$key]
            ];
        }
    }

    $phieu_nhap = array(
        "ngay_nhap" => $ngay_nhap,
        "nguoi_tao" => $nguoi_tao,
        "ghi_chu" => $ghi_chu,
        "ma_nha_cung_cap" => $nha_cung_cap,
        "orderDetails" => $orderDetails
    );
    

    $phieuNhapObj->suaPhieuNhapHang($conn, $id_phieu_nhap, $phieu_nhap);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa phiếu nhập hàng " .$id_phieu_nhap);
}
header('Location: ../index.php?p=suaphieunhaphang&id='.$id_phieu_nhap);
exit();
?>