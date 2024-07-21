<?php
class ChiTietVoucher
{
    public $id_chi_tiet_voucher;
    public $id_voucher;
    public $id_san_pham;
    
    public static function taoChiTietVoucher($conn, $id_voucher, $id_san_pham)
    {
        $sql = "INSERT INTO chi_tiet_voucher (id_voucher, id_san_pham) VALUES ('$id_voucher', '$id_san_pham')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    public static function layChiTietVoucher($conn, $id_voucher)
    {
        $query_ct = "SELECT * FROM chi_tiet_voucher WHERE id_voucher = '$id_voucher'";
        $result_ct = mysqli_query($conn, $query_ct);

        if (!$result_ct) {
            echo "Error: " . $query_ct . "<br>" . mysqli_error($conn);
            return false;
        }

        return $result_ct;
    }
}