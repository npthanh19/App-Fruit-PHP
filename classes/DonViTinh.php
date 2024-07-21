<?php

class DonViTinh
{
    public $ma_don_vi_tinh;
    public $ten_don_vi_tinh;
    public function themDonViTinh($conn, $ten_don_vi_tinh)
    {
        $message = "Đã có đơn vị tính có tên là $ten_don_vi_tinh";
        $checkQuery = "SELECT * FROM don_vi_tinh WHERE ten_don_vi_tinh = '$ten_don_vi_tinh'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $sql = "INSERT INTO don_vi_tinh (ten_don_vi_tinh) VALUES ('$ten_don_vi_tinh')";

            if (mysqli_query($conn, $sql)) {
                $message =  "Thêm đơn vị tính thành công!";
                echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
            } else {
                $message =  "Thêm đơn vị tính thất bại";
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }
        }
    }

    public function xoaDonViTinh($conn, $ma_don_vi_tinh)
    {
        $message = "Xóa đơn vị tính thành công!";
        $sql = "DELETE FROM don_vi_tinh WHERE ma_don_vi_tinh = $ma_don_vi_tinh";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Xóa đơn vị tính thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }

    public function layDonViTinh($conn)
    {
        $sql = "SELECT * FROM don_vi_tinh";
        $result = mysqli_query($conn, $sql);

        $data = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function suaDonViTinh($conn, $ma_don_vi_tinh, $ten_don_vi_tinh)
    {
        $message = "Chỉnh sửa đơn vị tính thành công!";
        $sql = "UPDATE don_vi_tinh SET ten_don_vi_tinh = '$ten_don_vi_tinh' WHERE ma_don_vi_tinh = $ma_don_vi_tinh";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Chỉnh sửa đơn vị tính thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }

    public function timDonViTinh($conn, $searchTerm)
    {
        $query = "SELECT * FROM don_vi_tinh WHERE ten_don_vi_tinh LIKE '%$searchTerm%'";
        $result = mysqli_query($conn, $query);
        $donViTinhArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $ma_don_vi_tinh = $row['ma_don_vi_tinh'];
            $ten_don_vi_tinh = $row['ten_don_vi_tinh'];
            $donViTinh = array(
                'ma_don_vi_tinh' => $ma_don_vi_tinh,
                'ten_don_vi_tinh' => $ten_don_vi_tinh
            );
            $donViTinhArr[] = $donViTinh;
        }
        return $donViTinhArr;
    }
}
?>