<?php
include('ChiTietPhieuNhapHang.php');
class PhieuNhapHang
{
    public $id_phieu_nhap;
    public $ngay_nhap;
    public $nguoi_tao;
    public $ghi_chu;
    public $nha_cung_cap;

    public function themPhieuNhapHang($conn, $phieuNhap)
    {
        $ngay_nhap = $phieuNhap['ngay_nhap'];
        $nguoi_tao = $phieuNhap['nguoi_tao'];
        $ma_nha_cung_cap = $phieuNhap['nha_cung_cap'];
        $ghi_chu = $phieuNhap['ghi_chu'];
        $orderDetails = $phieuNhap['orderDetails'];

        $message = "Đã có phiếu nhập hàng";


        $checkQuery = "SELECT * FROM phieu_nhap_hang WHERE ngay_nhap = '$ngay_nhap' AND nguoi_tao = '$nguoi_tao'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            mysqli_begin_transaction($conn);

            try {
                $sql = "INSERT INTO phieu_nhap_hang (ngay_nhap, nguoi_tao, ghi_chu, ma_nha_cung_cap)
                    VALUES ('$ngay_nhap', '$nguoi_tao', '$ghi_chu', '$ma_nha_cung_cap')";

                if (mysqli_query($conn, $sql)) {
                    $last_inserted_id = mysqli_insert_id($conn);

                    foreach ($orderDetails as $orderDetail) {
                        $ma_san_pham = $orderDetail['ma_san_pham'];
                        $so_luong_nhap = $orderDetail['so_luong_nhap'];
                        $gia_nhap = $orderDetail['gia_nhap'];

                        $chi_tiet_phieu_nhap = new ChiTietPhieuNhapHang();
                        $chi_tiet_phieu_nhap->taoChiTietPhieuNhap($conn, $last_inserted_id, $ma_san_pham, $so_luong_nhap, $gia_nhap, $nguoi_tao);
                    }

                    mysqli_commit($conn);

                    $message = "Thêm phiếu nhập hàng và chi tiết phiếu nhập hàng thành công!";
                    echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
                } else {
                    throw new Exception("Thêm phiếu nhập hàng thất bại");
                }
            } catch (Exception $e) {
                mysqli_rollback($conn);

                echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
            }
        }
    }


    public function xoaPhieuNhapHang($conn, $id_phieu_nhap)
    {
        mysqli_begin_transaction($conn);
        try {
            $chi_tiet_phieu_nhap = new ChiTietPhieuNhapHang();
            $chi_tiet_phieu_nhap->xoaChiTietPhieuNhapTheoPhieuNhap($conn, $id_phieu_nhap);

            // Sau đó xóa phiếu nhập hàng
            $message = "Xóa phiếu nhập hàng thành công!";
            $sql = "DELETE FROM phieu_nhap_hang WHERE id_phieu_nhap = $id_phieu_nhap";

            if (mysqli_query($conn, $sql)) {
                mysqli_commit($conn);
                echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
            } else {
                throw new Exception("Xóa phiếu nhập hàng thất bại!");
            }
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
        }
    }


    public function layPhieuNhapHang($conn)
    {
        $sql = "SELECT ph.*, tk.ten_tai_khoan AS nguoi_tao, ncc.ten_nha_cung_cap 
            FROM phieu_nhap_hang ph
            LEFT JOIN tai_khoan tk ON ph.nguoi_tao = tk.id_tai_khoan
            LEFT JOIN nha_cung_cap ncc ON ph.ma_nha_cung_cap = ncc.ma_nha_cung_cap";
        $result = mysqli_query($conn, $sql);

        $data = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function suaPhieuNhapHang($conn, $id_phieu_nhap, $phieuNhap)
{
    $ngay_nhap = $phieuNhap['ngay_nhap'];
    $ma_nha_cung_cap = $phieuNhap['ma_nha_cung_cap'];
    $ghi_chu = $phieuNhap['ghi_chu'];
    $orderDetails = $phieuNhap['orderDetails'];

    $message = "Chỉnh sửa phiếu nhập hàng và chi tiết phiếu nhập hàng thành công!";

    mysqli_begin_transaction($conn);

    try {
        $sqlXoaChiTiet = "DELETE FROM chi_tiet_phieu_nhap_hang WHERE id_phieu_nhap = '$id_phieu_nhap'";
        mysqli_query($conn, $sqlXoaChiTiet);

        foreach ($orderDetails as $orderDetail) {
            $ma_san_pham = $orderDetail['ma_san_pham'];
            $so_luong_nhap = $orderDetail['so_luong_nhap'];
            $gia_nhap = $orderDetail['gia_nhap'];

            $sqlChiTiet = "INSERT INTO chi_tiet_phieu_nhap_hang (id_phieu_nhap, ma_san_pham, so_luong, gia_nhap) 
                           VALUES ('$id_phieu_nhap', '$ma_san_pham', '$so_luong_nhap', '$gia_nhap')";

            mysqli_query($conn, $sqlChiTiet);
        }

        $sqlCapNhatPhieuNhap = "UPDATE phieu_nhap_hang 
                                SET ngay_nhap = '$ngay_nhap', ghi_chu = '$ghi_chu', ma_nha_cung_cap = '$ma_nha_cung_cap' 
                                WHERE id_phieu_nhap = '$id_phieu_nhap'";
        mysqli_query($conn, $sqlCapNhatPhieuNhap);

        mysqli_commit($conn);

        echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
    } catch (Exception $e) {
        mysqli_rollback($conn);

        $message = "Chỉnh sửa phiếu nhập hàng thất bại!";
        echo '<div class="alert alert-danger" role="alert">' . $e . '</div>';
    }
}



    public function timPhieuNhapHang($conn, $searchTerm)
    {
        $query = "SELECT * FROM phieu_nhap_hang WHERE ngay_nhap LIKE '%$searchTerm%'";
        $result = mysqli_query($conn, $query);
        $phieuNhapArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $id_phieu_nhap = $row['id_phieu_nhap'];
            $ngay_nhap = $row['ngay_nhap'];
            $gia_nhap = $row['gia_nhap'];
            $nguoi_tao = $row['nguoi_tao'];
            $ghi_chu = $row['ghi_chu'];
            $phieuNhap = array(
                'id_phieu_nhap' => $id_phieu_nhap,
                'ngay_nhap' => $ngay_nhap,
                'gia_nhap' => $gia_nhap,
                'nguoi_tao' => $nguoi_tao,
                'ghi_chu' => $ghi_chu,
            );
            $phieuNhapArr[] = $phieuNhap;
        }
        return $phieuNhapArr;
    }

    public function layPhieuNhapHangTheoId($conn, $id_phieu_nhap)
    {
        $phieuNhap = array();

        $phieuNhapQuery = "SELECT ph.*, tk.ten_tai_khoan AS nguoi_tao, ncc.ten_nha_cung_cap 
                        FROM phieu_nhap_hang ph
                        LEFT JOIN tai_khoan tk ON ph.nguoi_tao = tk.id_tai_khoan
                        LEFT JOIN nha_cung_cap ncc ON ph.ma_nha_cung_cap = ncc.ma_nha_cung_cap
                        WHERE ph.id_phieu_nhap = '$id_phieu_nhap'";

        $phieuNhapResult = mysqli_query($conn, $phieuNhapQuery);

        if ($phieuNhapResult && mysqli_num_rows($phieuNhapResult) > 0) {
            $phieuNhap = mysqli_fetch_assoc($phieuNhapResult);

            $orderDetailsQuery = "SELECT c.*, sp.ten_san_pham
                              FROM chi_tiet_phieu_nhap_hang c
                              LEFT JOIN san_pham sp ON c.ma_san_pham = sp.ma_san_pham
                              WHERE c.id_phieu_nhap = '$id_phieu_nhap'";
            $orderDetailsResult = mysqli_query($conn, $orderDetailsQuery);

            $orderDetails = array();
            while ($row = mysqli_fetch_assoc($orderDetailsResult)) {
                $orderDetails[] = $row;
            }

            $phieuNhap['orderDetails'] = $orderDetails;
        }

        return $phieuNhap;
    }
}