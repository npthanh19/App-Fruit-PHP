<?php

class LichSuHoatDong
{
    public $id_lich_su_hoat_dong;
    public $thoi_gian;
    public $id_tai_khoan;
    public $ten_tai_khoan;
    public $hanh_dong;

    public function taoLichSuHoatDong($conn, $id_tai_khoan, $hanh_dong)
    {
        $thoi_gian = date("Y-m-d H:i:s");
        $sql = "INSERT INTO lich_su_hoat_dong (thoi_gian, id_tai_khoan, hanh_dong) 
                VALUES ('$thoi_gian', '$id_tai_khoan', '$hanh_dong')";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">Tạo lịch sử hoạt động thành công!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Tạo lịch sử hoạt động thất bại!</div>';
        }
    }

public function lietKeLichSuHoatDong($conn)
{
    $sql = "SELECT lshd.id_lich_su_hoat_dong, lshd.thoi_gian, lshd.id_tai_khoan, lshd.hanh_dong, tk.ten_tai_khoan 
            FROM lich_su_hoat_dong lshd 
            LEFT JOIN tai_khoan tk ON lshd.id_tai_khoan = tk.id_tai_khoan";
    $result = mysqli_query($conn, $sql);

    $lichSuHoatDongArr = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $lichSuHoatDongArr[] = $row;
        }
    }
    return $lichSuHoatDongArr;
}

    public function timKiemLichSuHoatDong($conn, $id_tai_khoan = null, $hanh_dong = null, $thoi_gian = null)
{
    $sql = "SELECT lshd.id_lich_su_hoat_dong, lshd.thoi_gian, lshd.id_tai_khoan, lshd.hanh_dong, tk.ten_tai_khoan 
            FROM lich_su_hoat_dong lshd 
            LEFT JOIN tai_khoan tk ON lshd.id_tai_khoan = tk.id_tai_khoan
            WHERE 1";

    // Thêm điều kiện tìm kiếm nếu có
    if ($hanh_dong !== null) {
        $sql .= " AND lshd.hanh_dong LIKE '%$hanh_dong%'";
    }

    $result = mysqli_query($conn, $sql);

    $lichSuHoatDongArr = array();
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $lichSuHoatDongArr[] = $row;
        }
    }

    return $lichSuHoatDongArr;
}

}