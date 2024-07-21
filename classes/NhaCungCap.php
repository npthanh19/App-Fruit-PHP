<?php

class NhaCungCap
{
    public $ma_nha_cung_cap;
    public $ten_nha_cung_cap;
    public $dia_chi;
    public $so_dien_thoai;
    public $email;

    public function themNhaCungCap($conn, $ten_nha_cung_cap, $dia_chi, $so_dien_thoai, $email, $ma_danh_muc)
    {
        $message = "Đã có nhà cung cấp có tên là $ten_nha_cung_cap";

        $checkQuery = "SELECT * FROM nha_cung_cap WHERE ten_nha_cung_cap = '$ten_nha_cung_cap'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $sql = "INSERT INTO nha_cung_cap (ten_nha_cung_cap, dia_chi, so_dien_thoai, email, ma_danh_muc) 
                    VALUES ('$ten_nha_cung_cap', '$dia_chi', '$so_dien_thoai', '$email', '$ma_danh_muc')";

            if (mysqli_query($conn, $sql)) {
                $message =  "Thêm nhà cung cấp thành công!";
                echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
            } else {
                $message =  "Thêm nhà cung cấp thất bại";
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }
        }
    }

    public function xoaNhaCungCap($conn, $id_nha_cung_cap)
    {
        $message = "Xóa nhà cung cấp thành công!";
        $sql = "DELETE FROM nha_cung_cap WHERE ma_nha_cung_cap = '$id_nha_cung_cap'";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Xóa nhà cung cấp thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }

    public function layDanhSachNhaCungCap($conn)
    {
        $sql = "SELECT * FROM nha_cung_cap";
        $result = mysqli_query($conn, $sql);

        $data = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function suaNhaCungCap($conn, $id_nha_cung_cap, $ten_nha_cung_cap, $dia_chi, $so_dien_thoai, $email, $ma_danh_muc)
    {
        $message = "Chỉnh sửa nhà cung cấp thành công!";
        $sql = "UPDATE nha_cung_cap 
                SET ten_nha_cung_cap = '$ten_nha_cung_cap', dia_chi = '$dia_chi', so_dien_thoai = '$so_dien_thoai', 
                    email = '$email', ma_danh_muc = '$ma_danh_muc' 
                WHERE ma_nha_cung_cap = '$id_nha_cung_cap'";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Chỉnh sửa nhà cung cấp thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }

    public function timNhaCungCap($conn, $searchTerm)
    {
        $query = "SELECT * FROM nha_cung_cap WHERE ten_nha_cung_cap LIKE '%$searchTerm%' OR dia_chi LIKE '%$searchTerm%'";
        $result = mysqli_query($conn, $query);
        $nhaCungCapArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $ma_nha_cung_cap = $row['ma_nha_cung_cap'];
            $nhaCungCapArr[] = $ma_nha_cung_cap;
        }
        return $nhaCungCapArr;
    }
}