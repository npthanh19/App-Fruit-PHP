<?php
session_start();
include("../classes/DonHang.php");
include("../config/database.php");
include("../classes/GioHang.php");
if (isset($_GET['message']) && $_GET['message'] === 'Successful.') {

    $order = array(
        "customerName" => $_SESSION["hidden_ten"],
        "customerAddress" => $_SESSION["hidden_dia_chi"],
        "customerId" => $_SESSION['id_tai_khoan'],
        "customerPhone" => $_SESSION["hidden_so_dien_thoai"],
        "orderDate" => date("Y-m-d H:i:s"),
        "status" => "Chờ xác nhận",
        "paymentMethods" => $_SESSION["hidden_phuong_thuc_thanh_toan"],
        "totalPrice" => $_SESSION["hidden_tong_tien"],
        "orderDetails" => array(),
    );

    if (isset($_SESSION['selected_products']) && count($_SESSION['selected_products']) > 0) {
        foreach ($_SESSION['selected_products'] as $productId => $productQuantity) {
            $sql = "SELECT * FROM san_pham WHERE ma_san_pham = $productId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $product_id = $row['ma_san_pham'];
                $product_name = $row['ten_san_pham'];
                $product_price = $row['gia_ban'];
                $product_quantity = $productQuantity;
                $total_item_price = $product_price * $product_quantity;

                $order_detail = array(
                    "productName" => $product_name,
                    "productId" => $product_id,
                    "productPrice" => $product_price,
                    "quantity" => $product_quantity,
                );
                array_push($order["orderDetails"], $order_detail);
            }
        }
    }
    $objDonHang = new DonHang();
    $objDonHang->datHang($conn, $order);

    if (isset($_SESSION['selected_products']) && count($_SESSION['selected_products']) > 0) {
        foreach ($_SESSION['selected_products'] as $productId => $productQuantity) {
            $objGioHang = new GioHang();
            $objGioHang->xoaSanPhamKhoiGio($conn, $productId);
        }
    }



    header('Location: ../dat-hang-thanh-cong.php');
} else {
    echo 'Thanh toán thất bại';
}