<?php
class SanPham
{
    public $ma_san_pham;
    public $ten_san_pham;
    public $gia_nhap;
    public $gia_ban;
    public $xuat_xu;
    public $anh_san_pham;
    public $danh_muc_san_pham;
    public $mo_ta_san_pham;
    public $so_luong;
    public $ma_don_vi_tinh;


    public function layTatCaSanPham($conn)
    {
        $sql = "SELECT * FROM san_pham";
        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_nhap = $row['gia_nhap'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPham->ma_don_vi_tinh = $row['ma_don_vi_tinh'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }
    public function layTatCaSanPhamPhanTrang($conn, $soLuong, $trang)
    {
        $soSanPhamBatDau = ($trang - 1) * $soLuong;
        $sql = "SELECT * FROM san_pham LIMIT $soSanPhamBatDau, $soLuong";
        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }

    public function layTatCaSanPhamASC($conn, $soLuong, $trang)
    {
        $soSanPhamBatDau = ($trang - 1) * $soLuong;
        $sql = "SELECT * FROM san_pham ORDER BY ten_san_pham ASC LIMIT $soSanPhamBatDau, $soLuong";
        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }

    public function layTatCaSanPhamDESC($conn, $soLuong, $trang)
    {
        $soSanPhamBatDau = ($trang - 1) * $soLuong;
        $sql = "SELECT * FROM san_pham ORDER BY ten_san_pham DESC LIMIT $soSanPhamBatDau, $soLuong";
        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }

    public function layTatCaSanPhamGiaTangDan($conn, $soLuong, $trang)
    {
        $soSanPhamBatDau = ($trang - 1) * $soLuong;
        $sql = "SELECT * FROM san_pham ORDER BY gia_ban ASC LIMIT $soSanPhamBatDau, $soLuong";
        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }

    public function layTatCaSanPhamGiaGiamDan($conn, $soLuong, $trang)
    {
        $soSanPhamBatDau = ($trang - 1) * $soLuong;
        $sql = "SELECT * FROM san_pham ORDER BY gia_ban DESC LIMIT $soSanPhamBatDau, $soLuong";
        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }

    public function layTatCaSanPhamVietNam($conn, $soLuong, $trang)
    {
        $soSanPhamBatDau = ($trang - 1) * $soLuong;
        $sql = "SELECT * FROM san_pham WHERE danh_muc_san_pham = 0 ORDER BY ten_san_pham ASC LIMIT $soSanPhamBatDau, $soLuong";
        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }

    public function layTatCaSanPhamNuocNgoai($conn, $soLuong, $trang)
    {
        $soSanPhamBatDau = ($trang - 1) * $soLuong;
        $sql = "SELECT * FROM san_pham WHERE danh_muc_san_pham = 1700271199 ORDER BY ten_san_pham ASC LIMIT $soSanPhamBatDau, $soLuong";
        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }

    public function layTatCaSanPhamTheoGia($conn, $filters, $soLuong, $trang)
    {
        function generatePriceFilter($filters)
        {
            $conditions = '';

            if ($filters == 'under_100k') {
                $conditions = "gia_ban < 100";
            }

            if ($filters == '100k_to_200k') {
                $conditions = "gia_ban >= 100 AND gia_ban <= 200";
            }

            if ($filters == '200k_to_300k') {
                $conditions = "gia_ban >= 200 AND gia_ban <= 300";
            }

            if ($filters == '300k_to_500k') {
                $conditions = "gia_ban >= 300 AND gia_ban <= 500";
            }

            if ($filters == '500k_to_1m') {
                $conditions = "gia_ban >= 500 AND gia_ban <= 1000";
            }

            if ($filters == 'over_1m') {
                $conditions = "gia_ban > 1000";
            }

            $whereClause = $conditions;

            return $whereClause;
        }

        $soSanPhamBatDau = ($trang - 1) * $soLuong;

        $whereClause = generatePriceFilter($filters);

        $sql = "SELECT * FROM san_pham";
        if (!empty($whereClause)) {
            $sql .= " WHERE " . $whereClause;
        }

        $sql .= " LIMIT $soSanPhamBatDau, $soLuong";

        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }

        return $sanPhamArr;
    }


    /* lấy chi tiết sản phẩm */
    public function xemChiTietSanPham($conn, $id_san_pham)
    {
        $sql = "SELECT * FROM san_pham WHERE ma_san_pham = '$id_san_pham'";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            $this->ma_san_pham = $row['ma_san_pham'];
            $this->ten_san_pham = $row['ten_san_pham'];
            $this->gia_ban = $row['gia_ban'];
            $this->gia_nhap = $row['gia_nhap'];
            $this->xuat_xu = $row['xuat_xu'];
            $this->anh_san_pham = $row['anh_san_pham'];
            $this->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $this->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $this->so_luong = $row['so_luong'];
            $this->ma_don_vi_tinh = $row['ma_don_vi_tinh'];
        }
    }

    /* thêm sản phẩm */
    public function themSanPham($conn, $ma_san_pham, $ten_san_pham, $gia_nhap, $gia_ban, $xuat_xu, $anh_san_pham, $danh_muc_san_pham, $mo_ta_san_pham, $ma_don_vi_tinh)
    {
        $message = "Lỗi khi thêm sản phẩm";
        $sql = "INSERT INTO san_pham (ma_san_pham, ten_san_pham, gia_nhap, gia_ban, xuat_xu, anh_san_pham, danh_muc_san_pham, mo_ta_san_pham, ma_don_vi_tinh) VALUES ('$ma_san_pham', '$ten_san_pham', '$gia_nhap','$gia_ban','$xuat_xu', '$anh_san_pham', '$danh_muc_san_pham', '$mo_ta_san_pham', '$ma_don_vi_tinh')";
        if (mysqli_query($conn, $sql)) {
            $message = "Thêm sản phẩm $ten_san_pham thành công";
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }
    /* xóa sản phẩm */
    public function xoasanpham($conn, $ma_san_pham)
    {
        $message = "Sản phẩm đang có tồn tại trong 1 đơn hàng. Không được phép xóa";
        if (!$conn) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . mysqli_connect_error());
        }

        $sql_check = "SELECT * FROM chi_tiet_don_hang WHERE ma_san_pham = '$ma_san_pham'";
        $result = mysqli_query($conn, $sql_check);
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
            return;
        }


        $sql = "DELETE FROM san_pham WHERE ma_san_pham = '$ma_san_pham'";
        if (mysqli_query($conn, $sql)) {
            $message = "Sản phẩm đã được xóa thành công.";
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Xóa sản phẩm thất bại";
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        }
    }
    public function suaSanPham($conn, $ma_san_pham, $ten_san_pham, $gia_nhap, $gia_ban, $xuat_xu, $anh_san_pham, $danh_muc_san_pham, $mo_ta_san_pham, $ma_don_vi_tinh)
    {
        $message = "Sản phẩm đã được xóa thành công.";
        if (empty($anh_san_pham)) {
            $sql = "SELECT anh_san_pham FROM san_pham WHERE ma_san_pham = $ma_san_pham";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $anh_san_pham = $row['anh_san_pham'];
        } else {
            $anh_san_pham = file_get_contents($_FILES['anh_san_pham']['tmp_name']);
            $image_info = getimagesize($_FILES['anh_san_pham']['tmp_name']);

            if (!$image_info || !in_array($image_info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF])) {
                $message =  "File ảnh không đúng định dạng! Vui lòng chọn file ảnh có định dạng JPEG, PNG hoặc GIF.";
                echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
            } else {
                $anh_san_pham = base64_encode($anh_san_pham);
            }
        }
        $sql = "UPDATE san_pham SET ten_san_pham = '$ten_san_pham', gia_nhap = $gia_nhap, gia_ban = $gia_ban, xuat_xu = '$xuat_xu', anh_san_pham = '$anh_san_pham', danh_muc_san_pham = '$danh_muc_san_pham', mo_ta_san_pham = '$mo_ta_san_pham', ma_don_vi_tinh = '$ma_don_vi_tinh' WHERE ma_san_pham = $ma_san_pham";
        if (mysqli_query($conn, $sql)) {
            $message = "Cập nhật sản phẩm có ID là $ma_san_pham thành công";
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Có lỗi xảy ra khi cập nhật sản phẩm";
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        }
    }

    public function capNhatSoLuongSanPham($conn, $ma_san_pham, $so_luong)
    {
        $message = "Số lượng sản phẩm đã được cập nhật thành công.";

        if (!is_numeric($so_luong) || $so_luong < 0) {
            $message = "Số lượng phải là một số nguyên dương.";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            return;
        }

        $sql = "UPDATE san_pham SET so_luong = $so_luong WHERE ma_san_pham = $ma_san_pham";
        mysqli_query($conn, $sql);

        if (mysqli_query($conn, $sql)) {
            $message = "Cập nhật số lượng sản phẩm có ID là $ma_san_pham thành công";
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Có lỗi xảy ra khi cập nhật số lượng sản phẩm";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }
    public function xemSanPhamTheoLoai($conn, $danh_muc_san_pham, $limit = 4)
    {
        $sql = "SELECT * FROM san_pham WHERE danh_muc_san_pham = '$danh_muc_san_pham' LIMIT $limit";
        $result = mysqli_query($conn, $sql);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_nhap = $row['gia_nhap'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }

    public function laySoLuongSanPham($conn, $ma_san_pham)
    {
        $sql = "SELECT so_luong FROM san_pham WHERE ma_san_pham = $ma_san_pham";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['so_luong'];
        } else {
            return -1;
        }
    }

    public function timSanPham($conn, $searchTerm)
    {
        $query = "SELECT * FROM san_pham WHERE ten_san_pham LIKE '%$searchTerm%'";
        $result = mysqli_query($conn, $query);
        $sanPhamArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $sanPham = new SanPham();
            $sanPham->ma_san_pham = $row['ma_san_pham'];
            $sanPham->ten_san_pham = $row['ten_san_pham'];
            $sanPham->gia_nhap = $row['gia_nhap'];
            $sanPham->gia_ban = $row['gia_ban'];
            $sanPham->xuat_xu = $row['xuat_xu'];
            $sanPham->anh_san_pham = $row['anh_san_pham'];
            $sanPham->danh_muc_san_pham = $row['danh_muc_san_pham'];
            $sanPham->mo_ta_san_pham = $row['mo_ta_san_pham'];
            $sanPham->so_luong = $row['so_luong'];
            $sanPhamArr[] = $sanPham;
        }
        return $sanPhamArr;
    }
}