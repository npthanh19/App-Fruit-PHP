<?php
session_start();
include("../config/database.php");
include("../classes/Voucher.php");

$response = [];

if (isset($_POST['ma-voucher'])) {
    $maVoucher = $_POST['ma-voucher'];

    if (!isset($_SESSION['applied_vouchers'])) {
        $_SESSION['applied_vouchers'] = [];
    }

    if (in_array($maVoucher, $_SESSION['applied_vouchers'])) {
        $response['message'] = 'Voucher đã được áp dụng trước đó.';
    } else {
        $voucher = new Voucher();
        $voucherData = $voucher->apDungVoucher($conn, $maVoucher);

        if ($voucherData) {
            $_SESSION['applied_vouchers'][] = $maVoucher;
            $response = $voucherData;
        } else {
            $response['message'] = 'Không thể áp dụng voucher. Hãy thử lại sau.';
        }
    }
} else {
    $response['error'] = 'Mã voucher không được gửi đến.';
}

echo json_encode($response);
?>