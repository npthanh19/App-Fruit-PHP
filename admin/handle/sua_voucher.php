<?php
session_start();
require '../../config/database.php';
require '../../classes/Voucher.php';
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

if (isset($_POST['suaVoucher'])) {
    $id_voucher = $_POST['id_voucher'];
    $ma_voucher = $_POST['ma_voucher'];
    $loai_voucher = $_POST['loai_voucher'];
    $gia_tri_don_hang_ap_dung = $_POST['gia_tri_don_hang_ap_dung'];
    $gia_tri = $_POST['gia_tri'];
    $phan_tram_giam_gia = $_POST['phan_tram_giam_gia'];
    $ngay_bat_dau = $_POST['ngay_bat_dau'];
    $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
    $mo_ta = $_POST['mo_ta'];
    $so_luong_giam_gia = $_POST['so_luong_giam_gia'];
    
    $chi_tiet_san_pham_sua = $_POST['chi_tiet_san_pham_sua'];

    var_dump($chi_tiet_san_pham_sua);

    $voucher = new Voucher();
    $voucher->suaVoucher($conn, $id_voucher, $ma_voucher, $loai_voucher, $gia_tri_don_hang_ap_dung, $gia_tri, $phan_tram_giam_gia, $ngay_bat_dau, $ngay_ket_thuc, $mo_ta, $so_luong_giam_gia, $chi_tiet_san_pham_sua);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Sửa voucher " . $ma_voucher);
}

header('Location: ../index.php?p=voucher');
exit();