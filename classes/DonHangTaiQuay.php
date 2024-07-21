<?php include('ChiTietDonHangTaiQuay.php') ?>
<?php include('SanPham.php') ?>
<?php

class DonHangTaiQuay
{
    public $ma_don_hang;
    public $ten_khach_hang;
    public $so_dien_thoai;
    public $ngay_dat_hang;
    public $nhan_vien_len_don;

    public function xemTatCaDonHang($conn)
    {
        $sql = "SELECT don_hang_tai_quay.ma_don_hang, don_hang_tai_quay.ten_khach_hang, don_hang_tai_quay.so_dien_thoai, don_hang_tai_quay.nhan_vien_len_don, don_hang_tai_quay.ngay_dat_hang,
            SUM(chi_tiet_don_hang_tai_quay.gia_don_hang * chi_tiet_don_hang_tai_quay.so_luong) AS tong_gia
            FROM don_hang_tai_quay
            LEFT JOIN chi_tiet_don_hang_tai_quay ON don_hang_tai_quay.ma_don_hang = chi_tiet_don_hang_tai_quay.ma_don_hang
            GROUP BY don_hang_tai_quay.ma_don_hang";

        $result = mysqli_query($conn, $sql);
        $don_hang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $don_hang[] = $row;
        }

        return $don_hang;
    }
    public function capNhatTrangThai($conn, $trang_thai, $ma_don_hang)
    {
        $sql = "UPDATE don_dat_hang SET trang_thai = '$trang_thai' WHERE ma_don_hang = $ma_don_hang";
        mysqli_query($conn, $sql);
    }
    public function datHang($conn, $order)
    {

        $sql = "INSERT INTO don_hang_tai_quay (ma_don_hang, ten_khach_hang, so_dien_thoai, nhan_vien_len_don, ngay_dat_hang, tong_tien) VALUES ('" . $order['ma_don_hang'] . "', '" . $order['ten_khach_hang'] . "', '" . $order['so_dien_thoai'] . "', '" . $order['nhan_vien_len_don'] . "', '" . $order['ngay_dat_hang'] . "', '" . $order['tong_tien_don_hang'] . "')";

        if ($conn->query($sql) === TRUE) {
            $last_inserted_id = $conn->insert_id;

            foreach ($order['orderDetails'] as $orderDetail) {
                $id_chi_tiet_don_hang = rand();

                $chi_tiet_don_hang = new ChiTietDonHangTaiQuay();
                $chi_tiet_don_hang->taoChiTietDonHang($conn, $id_chi_tiet_don_hang, $order['ma_don_hang'], $orderDetail['tenSanPham'], $orderDetail['maSanPham'], $orderDetail['giaSanPham'], $orderDetail['soLuong']);

                $san_pham = new SanPham();
                $so_luong_hien_co = $san_pham->laySoLuongSanPham($conn, $orderDetail['maSanPham']);

                $so_luong_mua = $orderDetail['soLuong'];
                $so_luong_con_lai = $so_luong_hien_co - $so_luong_mua;
                $san_pham->capNhatSoLuongSanPham($conn, $orderDetail['maSanPham'], $so_luong_con_lai);
            }

            http_response_code(200);
            return "Đặt hàng thành công";
        } else {
            http_response_code(500);
            return "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
    public function lichSuMuaHang($conn, $id)
    {
        $query = "SELECT * FROM don_hang_tai_quay WHERE id_tai_khoan = $id";
        $result = mysqli_query($conn, $query);

        $don_hang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $don_hang[] = $row;
        }

        return $don_hang;
    }
    public function layChiTietDonHang($conn, $ma_don_hang)
    {
        $sql = "SELECT don_hang_tai_quay.ma_don_hang, don_hang_tai_quay.ten_khach_hang, don_hang_tai_quay.so_dien_thoai, don_hang_tai_quay.ngay_dat_hang, don_hang_tai_quay.nhan_vien_len_don,
            chi_tiet_don_hang_tai_quay.ma_san_pham, chi_tiet_don_hang_tai_quay.so_luong, san_pham.ten_san_pham, san_pham.gia_ban
            FROM don_hang_tai_quay
            INNER JOIN chi_tiet_don_hang_tai_quay ON don_hang_tai_quay.ma_don_hang = chi_tiet_don_hang_tai_quay.ma_don_hang
            INNER JOIN san_pham ON chi_tiet_don_hang_tai_quay.ma_san_pham = san_pham.ma_san_pham
            WHERE don_hang_tai_quay.ma_don_hang = '$ma_don_hang'";

        $result = mysqli_query($conn, $sql);

        $order = array(
            "ma_don_hang" => $ma_don_hang,
            "ten_khach_hang" => "",
            "so_dien_thoai" => "",
            "ngay_dat_hang" => "",
            "nhan_vien_len_don" => "",
            "orderDetails" => array()
        );

        while ($row = mysqli_fetch_assoc($result)) {
            $order["ten_khach_hang"] = $row["ten_khach_hang"];
            $order["so_dien_thoai"] = $row["so_dien_thoai"];
            $order["ngay_dat_hang"] = $row["ngay_dat_hang"];
            $order["nhan_vien_len_don"] = $row["nhan_vien_len_don"];

            $order["orderDetails"][] = array(
                "maSanPham" => $row["ma_san_pham"],
                "soLuong" => $row["so_luong"],
                "tenSanPham" => $row["ten_san_pham"],
                "giaSanPham" => $row["gia_ban"]
            );
        }

        return $order;
    }
}