<?php include('ChiTietDonHang.php') ?>
<?php include('SanPham.php') ?>
<?php

class DonHang
{
    public $ma_don_hang;
    public $ten_khach_hang;
    public $dia_chi;
    public $id_tai_khoan;
    public $so_dien_thoai;
    public $ngay_dat_hang;
    public $trang_thai;
    public $phuong_thuc_thanh_toan;
    public $tong_tien;

    public function xemTatCaDonHang($conn)
    {
        $sql = "SELECT don_dat_hang.ma_don_hang, don_dat_hang.ten_khach_hang, don_dat_hang.dia_chi, don_dat_hang.so_dien_thoai, don_dat_hang.ngay_dat_hang, don_dat_hang.trang_thai, don_dat_hang.phuong_thuc_thanh_toan
        FROM don_dat_hang
        INNER JOIN tai_khoan ON don_dat_hang.id_tai_khoan = tai_khoan.id_tai_khoan";
        $result = mysqli_query($conn, $sql);

        $don_hang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $don_hang[] = $row;
        }

        return $don_hang;
    }
    public function xemTatCaDonHangPhanTrang($conn, $page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;

        $sql = "SELECT don_dat_hang.ma_don_hang, don_dat_hang.ten_khach_hang, don_dat_hang.dia_chi, don_dat_hang.so_dien_thoai, don_dat_hang.ngay_dat_hang, don_dat_hang.trang_thai, don_dat_hang.phuong_thuc_thanh_toan
        FROM don_dat_hang
        INNER JOIN tai_khoan ON don_dat_hang.id_tai_khoan = tai_khoan.id_tai_khoan
        LIMIT $offset, $pageSize";

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
        $ma_don_hang = rand();

        $sql = "INSERT INTO don_dat_hang (ma_don_hang, ten_khach_hang, dia_chi, id_tai_khoan, so_dien_thoai, ngay_dat_hang, trang_thai, phuong_thuc_thanh_toan, tong_tien) VALUES ('$ma_don_hang', '" . $order['customerName'] . "', '" . $order['customerAddress'] . "', '" . $order['customerId'] . "', '" . $order['customerPhone'] . "', '" . $order['orderDate'] . "', '" . $order['status'] . "','" . $order['paymentMethods'] . "', '".$order['totalPrice']."')";

        if ($conn->query($sql) === TRUE) {
            $last_inserted_id = $conn->insert_id;

            foreach ($order['orderDetails'] as $orderDetail) {
                $id_chi_tiet_don_hang = rand();

                $chi_tiet_don_hang = new ChiTietDonHang();
                $chi_tiet_don_hang->taoChiTietDonHang($conn, $id_chi_tiet_don_hang, $ma_don_hang, $orderDetail['productName'], $orderDetail['productId'], $orderDetail['productPrice'], $orderDetail['quantity']);

                $san_pham = new SanPham();
                $so_luong_hien_co = $san_pham->laySoLuongSanPham($conn, $orderDetail['productId']);

                $so_luong_mua = $orderDetail['quantity'];
                $so_luong_con_lai = $so_luong_hien_co - $so_luong_mua;
                $san_pham->capNhatSoLuongSanPham($conn, $orderDetail['productId'], $so_luong_con_lai);
            }

            echo "<div class='container' style='margin-bottom: 20px;'><i class='fa-sharp fa-regular fa-circle-check' style='color: #22BB33; margin-right: 5px'></i><span>Đặt hàng thành công</span></div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    public function lichSuMuaHang($conn, $id)
    {
        $query = "SELECT * FROM don_dat_hang WHERE id_tai_khoan = $id";
        $result = mysqli_query($conn, $query);

        $don_hang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $don_hang[] = $row;
        }

        return $don_hang;
    }

    public function layChiTietDonHangOnline($conn, $ma_don_hang)
    {
        $sql = "SELECT don_dat_hang.ma_don_hang, don_dat_hang.ten_khach_hang, don_dat_hang.dia_chi, don_dat_hang.so_dien_thoai, don_dat_hang.ngay_dat_hang, don_dat_hang.trang_thai,
            chi_tiet_don_hang.ma_san_pham, chi_tiet_don_hang.ten_san_pham, chi_tiet_don_hang.gia_don_hang, chi_tiet_don_hang.so_luong
            FROM don_dat_hang
            INNER JOIN chi_tiet_don_hang ON don_dat_hang.ma_don_hang = chi_tiet_don_hang.ma_don_hang
            WHERE don_dat_hang.ma_don_hang = '$ma_don_hang'";

        $result = mysqli_query($conn, $sql);

        $order = array(
            "ma_don_hang" => $ma_don_hang,
            "ten_khach_hang" => "",
            "dia_chi" => "",
            "so_dien_thoai" => "",
            "ngay_dat_hang" => "",
            "trang_thai" => "",
            "orderDetails" => array()
        );

        while ($row = mysqli_fetch_assoc($result)) {
            $order["ten_khach_hang"] = $row["ten_khach_hang"];
            $order["dia_chi"] = $row["dia_chi"];
            $order["so_dien_thoai"] = $row["so_dien_thoai"];
            $order["ngay_dat_hang"] = $row["ngay_dat_hang"];
            $order["trang_thai"] = $row["trang_thai"];

            $order["orderDetails"][] = array(
                "maSanPham" => $row["ma_san_pham"],
                "tenSanPham" => $row["ten_san_pham"],
                "giaDonHang" => $row["gia_don_hang"],
                "soLuong" => $row["so_luong"]
            );
        }

        return $order;
    }
    public function demDonHangChoXacNhan($conn)
    {
        $trang_thai = "Chờ xác nhận";
        $sql = "SELECT COUNT(*) AS count FROM don_dat_hang WHERE trang_thai = '$trang_thai'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['count'];
        } else {
            return 0;
        }
    }
    public function xemDonHangTheoDieuKien($conn, $ngay_dat_hang, $trang_thai, $phuong_thuc_thanh_toan)
    {
        $sql = "SELECT don_dat_hang.ma_don_hang, don_dat_hang.ten_khach_hang, don_dat_hang.dia_chi, don_dat_hang.so_dien_thoai, don_dat_hang.ngay_dat_hang, don_dat_hang.trang_thai, don_dat_hang.phuong_thuc_thanh_toan
    FROM don_dat_hang
    INNER JOIN tai_khoan ON don_dat_hang.id_tai_khoan = tai_khoan.id_tai_khoan
    WHERE 1 ";

        if (!empty($ngay_dat_hang)) {
            $sql .= "AND don_dat_hang.ngay_dat_hang = '$ngay_dat_hang' ";
        }

        if (!empty($trang_thai)) {
            $sql .= "AND don_dat_hang.trang_thai = '$trang_thai' ";
        }

        if (!empty($phuong_thuc_thanh_toan)) {
            $sql .= "AND don_dat_hang.phuong_thuc_thanh_toan = '$phuong_thuc_thanh_toan' ";
        }

        $result = mysqli_query($conn, $sql);

        $don_hang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $don_hang[] = $row;
        }

        return $don_hang;
    }
}