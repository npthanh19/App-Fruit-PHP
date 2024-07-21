<?php
class ChiTietDonHang
{
    public $id_chi_tiet_don_hang;
    public $ma_don_hang;
    public $ten_san_pham;
    public $ma_san_pham;
    public $gia_don_hang;
    public $so_luong;
    public static function taoChiTietDonHang($conn, $id, $ma_dh, $ten_sp, $ma_sp, $gia_dh, $so_luong)
    {
        $sql = "INSERT INTO chi_tiet_don_hang (id_chi_tiet_don_hang, ma_don_hang, ten_san_pham, ma_san_pham, gia_don_hang, so_luong) VALUES ('$id', '$ma_dh', '$ten_sp', '$ma_sp', '$gia_dh', '$so_luong')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    public static function layChiTietDonHang($conn, $ma_don_hang)
    {
        $query_ct = "SELECT * FROM chi_tiet_don_hang WHERE ma_don_hang = '$ma_don_hang'";
        $result_ct = mysqli_query($conn, $query_ct);

        if (!$result_ct) {
            echo "Error: " . $query_ct . "<br>" . mysqli_error($conn);
            return false;
        }

        return $result_ct;
    }
}