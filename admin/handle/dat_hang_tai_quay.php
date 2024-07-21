<?php
session_start();
include("../../classes/DonHangTaiQuay.php");
include("../../config/database.php");
require '../../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khach_hang = $_POST["ten_khach_hang"];
    $so_dien_thoai = $_POST["so_dien_thoai"];
    $ngay_dat_hang = date("Y-m-d H:i:s");
    $nhan_vien_len_don = $_SESSION["username"];

    $ma_san_pham = $_POST['ma_san_pham'];
    $so_luong = $_POST['so_luong'];
    $ten_san_pham = $_POST['ten_san_pham'];
    $gia_san_pham = $_POST['gia_san_pham'];
    $ma_don_hang = rand();

    $tong_tien_don_hang = 0;

    $order = array(
        "ma_don_hang" => $ma_don_hang,
        "ten_khach_hang" => $ten_khach_hang,
        "so_dien_thoai" => $so_dien_thoai,
        "ngay_dat_hang" => $ngay_dat_hang,
        "nhan_vien_len_don" => $nhan_vien_len_don,
        "tong_tien_don_hang" => $tong_tien_don_hang,
        "orderDetails" => array()
    );
    
    for ($i = 0; $i < count($ma_san_pham); $i++) {
        $ma_sp = $ma_san_pham[$i];
        $sl = $so_luong[$i];
        $ten_sp = $ten_san_pham[$i];
        $gia_sp = $gia_san_pham[$i];

        $thanh_tien = round($sl * $gia_sp, 2);
        $order["tong_tien_don_hang"] += $thanh_tien;

        $order["orderDetails"][] = array(
            "maSanPham" => $ma_sp,
            "soLuong" => $sl,
            "tenSanPham" => $ten_sp,
            "giaSanPham" => $gia_sp
        );
    }

    echo $order["tong_tien_don_hang"];

    $don_hang_tai_quay = new DonHangTaiQuay();
    $result = $don_hang_tai_quay->datHang($conn, $order);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Tạo đơn hàng tại quầy có mã" . $ma_don_hang);

    header('Location: ../index.php?p=chitietdonhangtaiquay&id='. $order['ma_don_hang']);
exit();

} else {
    echo 'Thanh toán thất bại';
}