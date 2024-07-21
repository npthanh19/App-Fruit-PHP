<?php
class ChiTietVaiTro
{
    public $id_chi_tiet_vai_tro;
    public $id_tai_khoan;
    public $id_vai_tro;
    
    public static function taoChiTietVaiTro($conn, $id_tai_khoan, $id_vai_tro)
    {
        $sql = "INSERT INTO chi_tiet_vai_tro (id_tai_khoan, id_vai_tro) VALUES ('$id_tai_khoan', '$id_vai_tro')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    public static function layChiTietVaiTro($conn, $id_chi_tiet_vai_tro)
    {
        $query_ct = "SELECT * FROM chi_tiet_vai_tro WHERE id_chi_tiet_vai_tro = '$id_chi_tiet_vai_tro'";
        $result_ct = mysqli_query($conn, $query_ct);

        if (!$result_ct) {
            echo "Error: " . $query_ct . "<br>" . mysqli_error($conn);
            return false;
        }

        return $result_ct;
    }

    public static function kiemTraQuyenTruyCap($conn, $id_tai_khoan, $chuc_nang)
{
    $query = "SELECT * FROM tai_khoan WHERE id_tai_khoan = '$id_tai_khoan'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
        return false;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $id_vai_tro = $row['vai_tro'];

        $query_chucnang = "SELECT * FROM chi_tiet_vai_tro WHERE id_vai_tro = '$id_vai_tro' AND chuc_nang = '$chuc_nang'";
        $result_chucnang = mysqli_query($conn, $query_chucnang);

        if (!$result_chucnang) {
            echo "Error: " . $query_chucnang . "<br>" . mysqli_error($conn);
            return false;
        }

        if (mysqli_num_rows($result_chucnang) > 0) {
            return true;
        }
    }
}
}
?>