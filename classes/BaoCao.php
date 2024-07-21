<?php
class BaoCao
{
    public function tinhTongGiaDonHang($conn, $startDate = null, $endDate = null)
{
    $tongGia = 0;

    $sql = "SELECT gia_don_hang 
            FROM chi_tiet_don_hang ctdh
            INNER JOIN don_dat_hang ddh ON ctdh.ma_don_hang = ddh.ma_don_hang";

    // Thêm điều kiện WHERE nếu có thời gian truyền vào
    if ($startDate && $endDate) {
        $sql .= " WHERE ddh.ngay_dat_hang BETWEEN '$startDate' AND '$endDate'";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tongGia += $row['gia_don_hang'];
        }
    }

    return $tongGia;
}

public function tinhDoanhThuDonHang($conn, $startDate = null, $endDate = null)
{
    $doanhThu = 0;
    $sql = "SELECT ctdh.gia_don_hang, sp.gia_nhap
            FROM chi_tiet_don_hang ctdh
            INNER JOIN san_pham sp ON ctdh.ma_san_pham = sp.ma_san_pham
            INNER JOIN don_dat_hang ddh ON ctdh.ma_don_hang = ddh.ma_don_hang";

    // Thêm điều kiện WHERE nếu có thời gian truyền vào
    if ($startDate && $endDate) {
        $sql .= " WHERE ddh.ngay_dat_hang BETWEEN '$startDate' AND '$endDate'";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $doanhThu += ($row['gia_don_hang'] - $row['gia_nhap']);
        }
    }

    return $doanhThu;
}


    public function tinhTongDonHang($conn, $startDate = null, $endDate = null)
{
    $doanhThu = 0;
    $sql = "SELECT ctdh.gia_don_hang, sp.gia_nhap
            FROM chi_tiet_don_hang ctdh
            INNER JOIN san_pham sp ON ctdh.ma_san_pham = sp.ma_san_pham";

    // Thêm điều kiện WHERE nếu có thời gian truyền vào
    if ($startDate && $endDate) {
        $sql .= " WHERE ctdh.ma_don_hang IN (SELECT ma_don_hang FROM don_dat_hang WHERE ngay_dat_hang BETWEEN '$startDate' AND '$endDate')";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $doanhThu += ($row['gia_don_hang'] - $row['gia_nhap']);
        }
    }

    return $doanhThu;
}

public function demSoLuongDonDatHang($conn, $startDate = null, $endDate = null)
{
    $soLuongDonDatHang = 0;

    $sql = "SELECT COUNT(*) as so_luong FROM don_dat_hang";

    // Thêm điều kiện WHERE nếu có thời gian truyền vào
    if ($startDate && $endDate) {
        $sql .= " WHERE ngay_dat_hang BETWEEN '$startDate' AND '$endDate'";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $soLuongDonDatHang = $row['so_luong'];
    }

    return $soLuongDonDatHang;
}


    public function demSoLuongKhachHang($conn)
    {
        $soLuongKhachHang = 0;

        $sql = "SELECT COUNT(*) as so_luong FROM tai_khoan WHERE loai_tai_khoan = 'khachhang'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $soLuongKhachHang = $row['so_luong'];
        }

        return $soLuongKhachHang;
    }

    public function duLieuSanPham($conn)
    {
        $sql = "
         SELECT sp.ten_san_pham, COALESCE(SUM(cthd.so_luong), 0) AS so_luong
FROM san_pham sp
LEFT JOIN chi_tiet_don_hang cthd ON sp.ma_san_pham = cthd.ma_san_pham
GROUP BY sp.ma_san_pham, sp.ten_san_pham";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            $soLuongSanPhamArr = array();


            while ($row = mysqli_fetch_assoc($result)) {
                $tenSanPham = $row['ten_san_pham'];
                $soLuong = $row['so_luong'];


                $soLuongSanPhamArr[$tenSanPham] = $soLuong;
            }


            return $soLuongSanPhamArr;
        } else {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
        }
    }

    public function tinhPhanTramDonHangThanhCong($conn, $startDate = null, $endDate = null)
{
    $sqlTongDonDatHang = "SELECT COUNT(*) as tong_don_hang FROM don_dat_hang";
    $sqlDonHangThanhCong = "SELECT COUNT(*) as so_don_thanh_cong FROM don_dat_hang WHERE trang_thai = 'Thành công'";

    // Thêm điều kiện WHERE nếu có thời gian truyền vào
    if ($startDate && $endDate) {
        $sqlTongDonDatHang .= " WHERE ngay_dat_hang BETWEEN '$startDate' AND '$endDate'";
        $sqlDonHangThanhCong .= " AND ngay_dat_hang BETWEEN '$startDate' AND '$endDate'";
    }

    $resultTongDonDatHang = mysqli_query($conn, $sqlTongDonDatHang);
    $rowTongDonDatHang = mysqli_fetch_assoc($resultTongDonDatHang);
    $tongDonDatHang = $rowTongDonDatHang['tong_don_hang'];

    $resultDonHangThanhCong = mysqli_query($conn, $sqlDonHangThanhCong);
    $rowDonHangThanhCong = mysqli_fetch_assoc($resultDonHangThanhCong);
    $soDonThanhCong = $rowDonHangThanhCong['so_don_thanh_cong'];

    if ($tongDonDatHang > 0) {
        $phanTram = round(($soDonThanhCong / $tongDonDatHang) * 100);
    } else {
        $phanTram = 0;
    }

    return $phanTram;
}

    function tinhPhanTramNguoiDungDatHang($conn)
    {
        $sqlTongNguoiDungUser = "SELECT COUNT(*) as tong_nguoi_dung_user FROM tai_khoan WHERE loai_tai_khoan = 'khachhang'";
        $resultTongNguoiDungUser = mysqli_query($conn, $sqlTongNguoiDungUser);
        $rowTongNguoiDungUser = mysqli_fetch_assoc($resultTongNguoiDungUser);
        $tongNguoiDungUser = $rowTongNguoiDungUser['tong_nguoi_dung_user'];

        $sqlNguoiDungDatHang = "SELECT COUNT(DISTINCT id_tai_khoan) as so_nguoi_dung_dat_hang FROM don_dat_hang
                        WHERE id_tai_khoan IN (SELECT id_tai_khoan FROM tai_khoan WHERE loai_tai_khoan = 'khachhang')";
        $resultNguoiDungDatHang = mysqli_query($conn, $sqlNguoiDungDatHang);
        $rowNguoiDungDatHang = mysqli_fetch_assoc($resultNguoiDungDatHang);
        $soNguoiDungDatHang = $rowNguoiDungDatHang['so_nguoi_dung_dat_hang'];

        if ($tongNguoiDungUser > 0) {
            $phanTram = ($soNguoiDungDatHang / $tongNguoiDungUser) * 100;
        } else {
            $phanTram = 0;
        }

        return $phanTram;
    }
    public function duLieuDoanhThu($conn)
    {
        $doanhThu = 0;
        $thoiGian = array();

        $sqlDonDatHang = "SELECT SUM(tong_tien) as tong_tien, ngay_dat_hang FROM don_dat_hang GROUP BY ngay_dat_hang";
        $resultDonDatHang = mysqli_query($conn, $sqlDonDatHang);
        while ($rowDonDatHang = mysqli_fetch_assoc($resultDonDatHang)) {
            $doanhThu += $rowDonDatHang['tong_tien'];
            $thoiGian[$rowDonDatHang['ngay_dat_hang']] = $rowDonDatHang['tong_tien'];
        }

        $sqlDonHangTaiQuay = "SELECT SUM(tong_tien) as tong_tien, ngay_dat_hang FROM don_hang_tai_quay GROUP BY ngay_dat_hang";
        $resultDonHangTaiQuay = mysqli_query($conn, $sqlDonHangTaiQuay);
        while ($rowDonHangTaiQuay = mysqli_fetch_assoc($resultDonHangTaiQuay)) {
            $doanhThu += $rowDonHangTaiQuay['tong_tien'];
            $thoiGian[$rowDonHangTaiQuay['ngay_dat_hang']] = $rowDonHangTaiQuay['tong_tien'];
        }

        return $thoiGian;
    }

    public function duLieuDoanhThuTheoNgay($conn, $ngayDatHang)
    {
        $doanhThu = 0;

        $sqlDonDatHang = "SELECT SUM(tong_tien) as tong_tien FROM don_dat_hang WHERE ngay_dat_hang = '$ngayDatHang'";
        $resultDonDatHang = mysqli_query($conn, $sqlDonDatHang);
        $rowDonDatHang = mysqli_fetch_assoc($resultDonDatHang);
        $doanhThu += $rowDonDatHang['tong_tien'];

        $sqlDonHangTaiQuay = "SELECT SUM(tong_tien) as tong_tien FROM don_hang_tai_quay WHERE ngay_dat_hang = '$ngayDatHang'";
        $resultDonHangTaiQuay = mysqli_query($conn, $sqlDonHangTaiQuay);
        $rowDonHangTaiQuay = mysqli_fetch_assoc($resultDonHangTaiQuay);
        $doanhThu += $rowDonHangTaiQuay['tong_tien'];

        return $doanhThu;
    }


    public function duLieuDonHang($conn)
    {
        $thongKeDonHang = array();

        $sqlDonDatHang = "SELECT COUNT(*) as so_luong, ngay_dat_hang FROM don_dat_hang WHERE trang_thai = 'Thành công' GROUP BY ngay_dat_hang";
        $resultDonDatHang = mysqli_query($conn, $sqlDonDatHang);
        while ($rowDonDatHang = mysqli_fetch_assoc($resultDonDatHang)) {
            $thongKeDonHang[$rowDonDatHang['ngay_dat_hang']] = $rowDonDatHang['so_luong'];
        }

        $sqlDonHangTaiQuay = "SELECT COUNT(*) as so_luong, ngay_dat_hang FROM don_hang_tai_quay GROUP BY ngay_dat_hang";
        $resultDonHangTaiQuay = mysqli_query($conn, $sqlDonHangTaiQuay);
        while ($rowDonHangTaiQuay = mysqli_fetch_assoc($resultDonHangTaiQuay)) {
            if (isset($thongKeDonHang[$rowDonHangTaiQuay['ngay_dat_hang']])) {
                $thongKeDonHang[$rowDonHangTaiQuay['ngay_dat_hang']] += $rowDonHangTaiQuay['so_luong'];
            } else {
                $thongKeDonHang[$rowDonHangTaiQuay['ngay_dat_hang']] = $rowDonHangTaiQuay['so_luong'];
            }
        }

        return $thongKeDonHang;
    }
    public function tinhTiLeNguoiDungDatHang($conn)
    {
        $sqlTongNguoiDung = "SELECT COUNT(*) as tong_nguoi_dung FROM tai_khoan WHERE vai_tro = 'khachhang'";
        $resultTongNguoiDung = mysqli_query($conn, $sqlTongNguoiDung);
        $rowTongNguoiDung = mysqli_fetch_assoc($resultTongNguoiDung);
        $tongNguoiDung = $rowTongNguoiDung['tong_nguoi_dung'];

        if ($tongNguoiDung > 0) {
            $sqlNguoiDungDatHang = "SELECT COUNT(DISTINCT id_tai_khoan) as so_nguoi_dung_dat_hang FROM don_dat_hang";
            $resultNguoiDungDatHang = mysqli_query($conn, $sqlNguoiDungDatHang);
            $rowNguoiDungDatHang = mysqli_fetch_assoc($resultNguoiDungDatHang);
            $soNguoiDungDatHang = $rowNguoiDungDatHang['so_nguoi_dung_dat_hang'];

            $tiLeNguoiDungDatHang = ($soNguoiDungDatHang / $tongNguoiDung) * 100;
        } else {
            $tiLeNguoiDungDatHang = 0;
        }

        return $tiLeNguoiDungDatHang;
    }

    public function layDanhSachSanPhamBanChayNhat($conn)
    {
        $dsSanPhamBanChay = array();

        $sql = "SELECT sp.ten_san_pham, SUM(cthd.so_luong) as so_luong_ban
            FROM san_pham sp
            LEFT JOIN chi_tiet_don_hang cthd ON sp.ma_san_pham = cthd.ma_san_pham
            GROUP BY sp.ten_san_pham
            ORDER BY so_luong_ban DESC
            LIMIT 5";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $tenSanPham = $row['ten_san_pham'];
                $soLuongBan = $row['so_luong_ban'];

                $dsSanPhamBanChay[] = array(
                    'ten_san_pham' => $tenSanPham,
                    'so_luong_ban' => $soLuongBan
                );
            }
        } else {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
        }

        return $dsSanPhamBanChay;
    }

    public function laySanPhamGioHangNhieuNhat($conn)
    {
        $sql = "SELECT sp.ten_san_pham, ctgh.so_luong
FROM chi_tiet_gio_hang ctgh
INNER JOIN san_pham sp ON ctgh.ma_san_pham = sp.ma_san_pham
ORDER BY ctgh.so_luong DESC
LIMIT 5";

        $result = mysqli_query($conn, $sql);
        $sanPhamGioHangNhieuNhat = array();

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $sanPhamGioHangNhieuNhat[] = array(
                    'ten_san_pham' => $row['ten_san_pham'],
                    'so_luong_gio_hang' => $row['so_luong']
                );
            }
        } else {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
            return null;
        }
        return $sanPhamGioHangNhieuNhat;
    }

    public function duLieuNhapHang($conn)
    {
        $sql = "SELECT COUNT(*) AS so_luong, ngay_nhap
            FROM phieu_nhap_hang
            GROUP BY ngay_nhap";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $duLieuNhapHang = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $soLuong = $row['so_luong'];
                $ngayNhap = $row['ngay_nhap'];

                $duLieuNhapHang[] = array(
                    'so_luong' => $soLuong,
                    'ngay_nhap' => $ngayNhap
                );
            }

            return $duLieuNhapHang;
        } else {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
            return null;
        }
    }

    public function topNhaCungCapNhapHang($conn)
    {
        $sql = "SELECT ncc.ten_nha_cung_cap, COUNT(pnh.id_phieu_nhap) AS so_lan_nhap
            FROM nha_cung_cap ncc
            LEFT JOIN phieu_nhap_hang pnh ON ncc.ma_nha_cung_cap = pnh.ma_nha_cung_cap
            GROUP BY ncc.ten_nha_cung_cap
            ORDER BY so_lan_nhap DESC
            LIMIT 5";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $topNhaCungCap = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $tenNhaCungCap = $row['ten_nha_cung_cap'];
                $soLanNhap = $row['so_lan_nhap'];

                $topNhaCungCap[] = array(
                    'ten_nha_cung_cap' => $tenNhaCungCap,
                    'so_lan_nhap' => $soLanNhap
                );
            }

            return $topNhaCungCap;
        } else {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
            return null;
        }
    }
}