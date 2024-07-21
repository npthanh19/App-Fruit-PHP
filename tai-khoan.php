
<?php session_start(); ?>
<?php include('./partial/header.php'); ?>
<?php include('./classes/DonHang.php') ?>
<?php
if (!isset($_SESSION['id_tai_khoan'])) {
    echo "<div class='container' style='padding-top: 50px; text-align: center;'><span>Bạn phải cần đăng nhập thì mới xem được thông tin đơn đặt hàng</span></div>";
    return;
}
$id = $_SESSION['id_tai_khoan'];
$donhang_obj = new DonHang();
$don_hang = $donhang_obj->lichSuMuaHang($conn, $id);
echo '<main>
    <div class="history">
        <div class="container">
            <div class="mb-2">
                <h3 class="title-green">Thông tin tài khoản</h3>
                <span class="d-flex gap-10">Xin chào <h3 class="title-green">' . $_SESSION['ten_tai_khoan'] . '</h3></span>
            </div>
            <div class="history__item__header">
                <ul>
                    <li>Đơn hàng</li>
                    <li>Ngày đặt</li>
                    <li>Sản phẩm</li>
                    <li>Giá tiền</li>
                    <li>Địa chỉ</li>
                    <li>Trạng thái</li>
                </ul>
            </div>';


foreach ($don_hang as $row) {
    $ma_don_hang = $row['ma_don_hang'];
    $chi_tiet_don_hang = new ChiTietDonHang();
    $result_ct = $chi_tiet_don_hang->layChiTietDonHang($conn, $ma_don_hang);
    $tong_tien = 0;
    $ten_san_pham = '';
    while ($row_ct = mysqli_fetch_assoc($result_ct)) {
        $tong_tien += $row_ct['so_luong'] * $row_ct['gia_don_hang'];
        $ten_san_pham .= $row_ct['ten_san_pham'] . ', ';
    }

    echo '<ul class="history__list">';
    echo '<li>';
    echo $row['ma_don_hang'];
    echo '</li>';
    echo '<li>';
    echo $row['ngay_dat_hang'];
    echo '</li>';
    echo '<li>';
    echo $ten_san_pham;
    echo '</li>';
    echo '<li>';
    echo number_format($tong_tien, 0, ',', '.');
    echo '</li>';
    echo '<li>';
    echo $row['dia_chi'];
    echo '</li>';
    echo '<li>';
    echo $row['trang_thai'];
    echo '</li>';
    echo '</ul>';
}
echo '</div>';
echo '</div>';
echo '</main>';
include('./partial/footer.php');
?>