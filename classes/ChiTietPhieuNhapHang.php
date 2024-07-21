<?php
class ChiTietPhieuNhapHang
{
    public $id_chi_tiet;
    public $id_phieu_nhap;
    public $ma_san_pham;
    public $so_luong;
    public $gia_nhap;
    public $thanh_tien;
    
    public static function taoChiTietPhieuNhap($conn, $id_phieu_nhap, $ma_san_pham, $so_luong, $gia_nhap, $thanh_tien)
    {
        $sql = "INSERT INTO chi_tiet_phieu_nhap_hang (id_phieu_nhap, ma_san_pham, so_luong, gia_nhap, thanh_tien) VALUES ('$id_phieu_nhap', '$ma_san_pham', '$so_luong', '$gia_nhap', '$thanh_tien')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    public static function layChiTietPhieuNhap($conn, $id_phieu_nhap)
    {
        $query_ct = "SELECT * FROM chi_tiet_phieu_nhap_hang WHERE id_phieu_nhap = '$id_phieu_nhap'";
        $result_ct = mysqli_query($conn, $query_ct);

        if (!$result_ct) {
            echo "Error: " . $query_ct . "<br>" . mysqli_error($conn);
            return false;
        }

        return $result_ct;
    }
    public static function xoaChiTietPhieuNhapTheoPhieuNhap($conn, $id_phieu_nhap)
    {
        $sql = "DELETE FROM chi_tiet_phieu_nhap_hang WHERE id_phieu_nhap = '$id_phieu_nhap'";

        if ($conn->query($sql) === TRUE) {
            echo "Chi tiết phiếu nhập hàng đã được xóa thành công.";
        } else {
            echo "Lỗi khi xóa chi tiết phiếu nhập hàng: " . $conn->error;
        }
    }
}