<?php
class DanhMucSanPham
{
    public $ma_danh_muc;
    public $ten_danh_muc;

    public function themDanhMucSanPham($conn, $ma_danh_muc, $ten_danh_muc)
    {
        $message = "Đã có loại sản phẩm có tên là $ten_danh_muc";
        $checkQuery = "SELECT * FROM danh_muc_san_pham WHERE ten_danh_muc = '$ten_danh_muc'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $sql = "INSERT INTO danh_muc_san_pham (ma_danh_muc, ten_danh_muc) VALUES ('$ma_danh_muc','$ten_danh_muc')";

            if (mysqli_query($conn, $sql)) {
                $message =  "Thêm danh mục sản phẩm thành công!";
                echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
            } else {
                $message =  "Thêm danh mục sản phẩm thất bại";
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }
        }
    }

    public function xoaDanhMucSanPham($conn, $ma_danh_muc)
    {
        $message = "Xóa danh mục sản phẩm thành công!";
        $sql = "DELETE FROM danh_muc_san_pham WHERE ma_danh_muc = $ma_danh_muc";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Xóa danh mục sản phẩm phẩm thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }

    public function layDanhMucSanPham($conn)
    {
        $sql = "SELECT * FROM danh_muc_san_pham";
        $result = mysqli_query($conn, $sql);

        $data = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function suaDanhMucSanPham($conn, $ma_danh_muc, $ten_danh_muc)
    {
        $message = "Chỉnh sửa loại sản phẩm thành công!";
        $sql = "UPDATE danh_muc_san_pham SET ten_danh_muc = '$ten_danh_muc' WHERE ma_danh_muc = $ma_danh_muc";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Chỉnh sửa danh mục sản phẩm thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }

    public function timDanhMuc($conn, $searchTerm)
    {
        $query = "SELECT * FROM danh_muc_san_pham WHERE ten_danh_muc LIKE '%$searchTerm%'";
        $result = mysqli_query($conn, $query);
        $danhMucArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
        $ma_danh_muc = $row['ma_danh_muc'];
        $ten_danh_muc = $row['ten_danh_muc'];
        $danhMuc = array(
            'ma_danh_muc' => $ma_danh_muc,
            'ten_danh_muc' => $ten_danh_muc
        );
        $danhMucArr[] = $danhMuc;
    }
        return $danhMucArr;
    }
}