<?php
class Voucher
{
    private $conn;

    public function themVoucher($conn, $ma_voucher, $loai_voucher, $gia_tri_don_hang_ap_dung, $gia_tri, $phan_tram_giam_gia, $ngay_bat_dau, $ngay_ket_thuc, $mo_ta, $so_luong_giam_gia, $ngay_tao, $ngay_cap_nhat, $hieu_luc, $chi_tiet_san_pham)
    {
        $checkQuery = "SELECT * FROM voucher WHERE ma_voucher = '$ma_voucher'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $message = "Đã có voucher có mã là $ma_voucher";
            return $message;
        } else {
            $sql = "INSERT INTO voucher (ma_voucher, loai_voucher, gia_tri_don_hang_ap_dung, gia_tri, phan_tram_giam_gia, ngay_bat_dau, ngay_ket_thuc, mo_ta, so_luong_giam_gia, ngay_tao, ngay_cap_nhat, hieu_luc) 
                VALUES ('$ma_voucher', '$loai_voucher', '$gia_tri_don_hang_ap_dung', '$gia_tri', '$phan_tram_giam_gia', '$ngay_bat_dau', '$ngay_ket_thuc', '$mo_ta', '$so_luong_giam_gia', '$ngay_tao', '$ngay_cap_nhat', '$hieu_luc')";

            if (mysqli_query($conn, $sql)) {
                $message =  "Thêm voucher thành công!";

                $voucherId = mysqli_insert_id($conn);

                foreach ($chi_tiet_san_pham as $id_san_pham) {
                    $id_chi_tiet_voucher = rand();

                    $sqlChiTiet = "INSERT INTO chi_tiet_voucher (id_voucher, id_san_pham) 
                                VALUES ('$voucherId', '$id_san_pham')";

                    mysqli_query($conn, $sqlChiTiet);
                }

                return $message;
            } else {
                $message = "Thêm voucher thất bại!";
                return $message;
            }
        }
    }


    public function xoaVoucher($conn, $id_voucher)
    {
        $message = "Xóa voucher và chi tiết voucher thành công!";

        $sqlChiTiet = "DELETE FROM chi_tiet_voucher WHERE id_voucher = '$id_voucher'";
        if (mysqli_query($conn, $sqlChiTiet)) {
            $sql = "DELETE FROM voucher WHERE id_voucher = '$id_voucher'";
            if (mysqli_query($conn, $sql)) {
                echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
            } else {
                $message = "Xóa voucher thất bại!";
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }
        } else {
            $message = "Xóa chi tiết voucher thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }


    public function layDanhSachVoucher($conn)
    {
        $sql = "SELECT v.*, GROUP_CONCAT(ctv.id_san_pham) AS chi_tiet_san_pham_ids, GROUP_CONCAT(sp.ten_san_pham) AS chi_tiet_san_pham_ten
            FROM voucher AS v
            LEFT JOIN chi_tiet_voucher AS ctv ON v.id_voucher = ctv.id_voucher
            LEFT JOIN san_pham AS sp ON ctv.id_san_pham = sp.ma_san_pham
            GROUP BY v.id_voucher";
        $result = mysqli_query($conn, $sql);

        $data = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $chi_tiet_san_pham_ids = isset($row['chi_tiet_san_pham_ids']) ? $row['chi_tiet_san_pham_ids'] : '';
                $chi_tiet_san_pham_ten = isset($row['chi_tiet_san_pham_ten']) ? $row['chi_tiet_san_pham_ten'] : '';

                $chi_tiet_san_pham_ids = explode(",", $chi_tiet_san_pham_ids);
                $chi_tiet_san_pham_ten = explode(",", $chi_tiet_san_pham_ten);

                $chi_tiet_san_pham = array();
                for ($i = 0; $i < count($chi_tiet_san_pham_ids); $i++) {
                    $chi_tiet_san_pham[] = array(
                        'id' => $chi_tiet_san_pham_ids[$i],
                        'ten_san_pham' => $chi_tiet_san_pham_ten[$i]
                    );
                }

                unset($row['chi_tiet_san_pham_ids']);
                unset($row['chi_tiet_san_pham_ten']);

                $row['chi_tiet_san_pham'] = $chi_tiet_san_pham;
                $data[] = $row;
            }
        }
        return $data;
    }


    public function suaVoucher($conn, $id_voucher, $ma_voucher, $loai_voucher, $gia_tri_don_hang_ap_dung, $gia_tri, $phan_tram_giam_gia, $ngay_bat_dau, $ngay_ket_thuc, $mo_ta, $so_luong_giam_gia, $chi_tiet_san_pham)
    {
        $message = "Chỉnh sửa voucher và chi tiết voucher thành công!";

        $sqlXoaChiTiet = "DELETE FROM chi_tiet_voucher WHERE id_voucher = '$id_voucher'";
        if (mysqli_query($conn, $sqlXoaChiTiet)) {
            foreach ($chi_tiet_san_pham as $id_san_pham) {

                $sqlKiemTraTonTai = "SELECT COUNT(*) AS count FROM chi_tiet_voucher WHERE id_voucher = '$id_voucher' AND id_san_pham = '$id_san_pham'";
                $resultKiemTra = mysqli_query($conn, $sqlKiemTraTonTai);
                $rowKiemTra = mysqli_fetch_assoc($resultKiemTra);
                $soLanTonTai = $rowKiemTra['count'];

                if ($soLanTonTai == 0) {
                    $id_chi_tiet_voucher = rand();
                    $sqlChiTiet = "INSERT INTO chi_tiet_voucher (id_voucher, id_san_pham) 
                                VALUES ('$id_voucher', '$id_san_pham')";

                    mysqli_query($conn, $sqlChiTiet);
                }
            }
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Cập nhật chi tiết voucher thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }

        $sql = "UPDATE voucher 
            SET ma_voucher = '$ma_voucher', loai_voucher = '$loai_voucher', gia_tri_don_hang_ap_dung = '$gia_tri_don_hang_ap_dung', 
                gia_tri = '$gia_tri', phan_tram_giam_gia = '$phan_tram_giam_gia', ngay_bat_dau = '$ngay_bat_dau', 
                ngay_ket_thuc = '$ngay_ket_thuc', mo_ta = '$mo_ta', so_luong_giam_gia = '$so_luong_giam_gia' 
            WHERE id_voucher = '$id_voucher'";

        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Cập nhật voucher thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }




    public function timVoucher($searchTerm)
    {
        $query = "SELECT * FROM voucher WHERE ma_voucher LIKE '%$searchTerm%' OR mo_ta LIKE '%$searchTerm%'";
        $result = mysqli_query($this->conn, $query);
        $voucherArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $ma_voucher = $row['ma_voucher'];
            $voucherArr[] = $ma_voucher;
        }
        return $voucherArr;
    }

    public function layVoucherTheoId($conn, $id_voucher)
    {
        $sql = "SELECT v.id_voucher, v.ma_voucher, v.gia_tri_don_hang_ap_dung, v.gia_tri, v.phan_tram_giam_gia, v.ngay_bat_dau, v.ngay_ket_thuc, v.mo_ta, v.so_luong_giam_gia, 
            GROUP_CONCAT(ctv.id_san_pham) AS chi_tiet_san_pham_ids, GROUP_CONCAT(sp.ten_san_pham) AS chi_tiet_san_pham_ten
            FROM voucher AS v
            LEFT JOIN chi_tiet_voucher AS ctv ON v.id_voucher = ctv.id_voucher
            LEFT JOIN san_pham AS sp ON ctv.id_san_pham = sp.ma_san_pham
            WHERE v.id_voucher = '$id_voucher'
            GROUP BY v.id_voucher";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $chi_tiet_san_pham_ids = isset($row['chi_tiet_san_pham_ids']) ? $row['chi_tiet_san_pham_ids'] : '';
            $chi_tiet_san_pham_ten = isset($row['chi_tiet_san_pham_ten']) ? $row['chi_tiet_san_pham_ten'] : '';

            $chi_tiet_san_pham_ids = explode(",", $chi_tiet_san_pham_ids);
            $chi_tiet_san_pham_ten = explode(",", $chi_tiet_san_pham_ten);

            $chi_tiet_san_pham = array();
            for ($i = 0; $i < count($chi_tiet_san_pham_ids); $i++) {
                $chi_tiet_san_pham[] = array(
                    'id' => $chi_tiet_san_pham_ids[$i],
                    'ten_san_pham' => $chi_tiet_san_pham_ten[$i]
                );
            }

            unset($row['chi_tiet_san_pham_ids']);
            unset($row['chi_tiet_san_pham_ten']);

            $row['chi_tiet_san_pham'] = $chi_tiet_san_pham;
            return $row;
        } else {
            return null;
        }
    }
    

    public function apDungVoucher($conn, $ma_voucher)
{
    $query = "SELECT v.id_voucher, v.ma_voucher, v.loai_voucher, v.gia_tri_don_hang_ap_dung, 
              v.gia_tri, v.phan_tram_giam_gia, v.ngay_bat_dau, v.ngay_ket_thuc, 
              v.mo_ta, v.so_luong_giam_gia, v.ngay_tao, v.ngay_cap_nhat, v.hieu_luc,
              sp.ma_san_pham, sp.ten_san_pham, sp.gia_ban
              FROM voucher v
              JOIN chi_tiet_voucher cv ON v.id_voucher = cv.id_voucher
              JOIN san_pham sp ON cv.id_san_pham = sp.ma_san_pham
              WHERE v.ma_voucher = '$ma_voucher'";

    $result = mysqli_query($conn, $query);

    $voucherData = array();
    if (mysqli_num_rows($result) > 0) {
        $voucherInfo = mysqli_fetch_assoc($result);
        $voucherData['voucher_info'] = $voucherInfo;

        mysqli_data_seek($result, 0);

        $productList = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $productList[] = array(
                'ma_san_pham' => $row['ma_san_pham'],
                'ten_san_pham' => $row['ten_san_pham'],
                'gia_ban' => $row['gia_ban']
            );
        }
        $voucherData['product_list'] = $productList;
    }

    return $voucherData;
}


}