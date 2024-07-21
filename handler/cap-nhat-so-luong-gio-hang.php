<?php session_start(); ?>
<?php
include("../config/database.php");
include("../classes/GioHang.php");
$gioHang = new GioHang();
if (isset($_POST['product_id']) && isset($_POST['new_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];
    $gioHang->capNhatSoLuongSanPham($conn, $product_id, $new_quantity);
}
?>