<?php
class DanhMucNhaCungCap
{
    public $ma_danh_muc;
    public $ten_danh_muc;

    public function themDanhMucNhaCungCap($conn, $ten_danh_muc)
    {
        $message = "Đã có loại nhà cung cấp có tên là $ten_danh_muc";
        $checkQuery = "SELECT * FROM danh_muc_nha_cung_cap WHERE ten_danh_muc = '$ten_danh_muc'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $sql = "INSERT INTO danh_muc_nha_cung_cap (ten_danh_muc) VALUES ('$ten_danh_muc')";

            if (mysqli_query($conn, $sql)) {
                $message = "Thêm danh mục nhà cung cấp thành công!";
                echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
            } else {
                $message = "Thêm danh mục nhà cung cấp thất bại";
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }
        }
    }

    public function xoaDanhMucNhaCungCap($conn, $ma_danh_muc)
    {
        $message = "Xóa danh mục nhà cung cấp thành công!";
        $sql = "DELETE FROM danh_muc_nha_cung_cap WHERE ma_danh_muc = $ma_danh_muc";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Xóa danh mục nhà cung cấp thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }

    public function layDanhMucNhaCungCap($conn)
    {
        $sql = "SELECT * FROM danh_muc_nha_cung_cap";
        $result = mysqli_query($conn, $sql);

        $data = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function suaDanhMucNhaCungCap($conn, $ma_danh_muc, $ten_danh_muc)
    {
        $message = "Chỉnh sửa loại nhà cung cấp thành công!";
        $sql = "UPDATE danh_muc_nha_cung_cap SET ten_danh_muc = '$ten_danh_muc' WHERE ma_danh_muc = $ma_danh_muc";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Chỉnh sửa danh mục nhà cung cấp thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }

    public function timDanhMuc($conn, $searchTerm)
    {
        $query = "SELECT * FROM danh_muc_nha_cung_cấp WHERE ten_danh_muc LIKE '%$searchTerm%'";
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
?>