<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST["ten"];
    $soDienThoai = $_POST["so-dien-thoai"];
    $diaChi = $_POST["dia-chi"];
    $phuongThucThanhToan = $_POST["phuong-thuc-thanh-toan"];
    $tongTien = $_POST["total-price"];

    $_SESSION["hidden_ten"] = $ten;
    $_SESSION["hidden_so_dien_thoai"] = $soDienThoai;
    $_SESSION["hidden_dia_chi"] = $diaChi;
    $_SESSION["hidden_phuong_thuc_thanh_toan"] = $phuongThucThanhToan;
    $_SESSION["hidden_tong_tien"] = $tongTien;

    if ($phuongThucThanhToan == "null") {
        echo "Vui lòng chọn phương thức thanh toán.";
    } elseif ($phuongThucThanhToan == "Tiền mặt") {
        header('Location: ' . './xac-nhan-dat-hang.php?message=Successful.');
    } elseif ($phuongThucThanhToan == "Chuyển khoản QR Code") {
        header('Location: ' . '../thanh-toan-qr.php');
    } elseif ($phuongThucThanhToan == "Chuyển khoản ATM") {
        header('Location: ' . '../thanh-toan-atm.php');
    } else {
        echo "Phương thức thanh toán không hợp lệ.";
    }
}
?>