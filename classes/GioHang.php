<?php
class GioHang
{
    public $ma_san_pham;
    public $ten_san_pham;
    public $anh_san_pham;
    public $gia_san_pham;
    public $so_luong;


    public function layTatCaChiTietGioHang()
    {
        $chi_tiet_gio_hang = array();

        if (isset($_SESSION['id_tai_khoan'])) {
            $id_nguoi_dung = $_SESSION['id_tai_khoan'];
            include("./config/database.php");

            $query = "SELECT chi_tiet_gio_hang.*, san_pham.ten_san_pham, san_pham.anh_san_pham 
                  FROM chi_tiet_gio_hang 
                  INNER JOIN gio_hang ON chi_tiet_gio_hang.id_gio_hang = gio_hang.id_gio_hang
                  INNER JOIN san_pham ON chi_tiet_gio_hang.ma_san_pham = san_pham.ma_san_pham
                  WHERE gio_hang.id_nguoi_dung = $id_nguoi_dung";

            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $chi_tiet = new GioHang();

                    $chi_tiet->ma_san_pham = $row['ma_san_pham'];
                    $chi_tiet->ten_san_pham = $row['ten_san_pham'];
                    $chi_tiet->anh_san_pham = $row['anh_san_pham'];
                    $chi_tiet->gia_san_pham = $row['gia_tien'];
                    $chi_tiet->so_luong = $row['so_luong'];

                    $chi_tiet_gio_hang[] = $chi_tiet;
                }
            }

            mysqli_close($conn);
        }

        return $chi_tiet_gio_hang;
    }


    public function themSanPhamVaoGio()
    {
        if (isset($_POST['add_to_cart'])) {
            $product_id = $_POST['product_id'];
            $query = "SELECT * FROM san_pham WHERE ma_san_pham = $product_id";
            include("./config/database.php");
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $sanpham = mysqli_fetch_assoc($result);

                $ma_san_pham = $sanpham['ma_san_pham'];
                $ten_san_pham = $sanpham['ten_san_pham'];
                $anh_san_pham = $sanpham['anh_san_pham'];
                $gia_ban = $sanpham['gia_ban'];
                $so_luong = 1;

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }


                $product_exists = false;
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['id'] == $ma_san_pham) {
                        $_SESSION['cart'][$key]['quantity']++;
                        $so_luong = $_SESSION['cart'][$key]['quantity'];
                        $product_exists = true;
                        break;
                    }
                }

                $_SESSION['product_exists'] = $product_exists;

                if (!$product_exists) {
                    array_push($_SESSION['cart'], array(
                        'id' => $ma_san_pham,
                        'name' => $ten_san_pham,
                        'image' => $anh_san_pham,
                        'price' => $gia_ban,
                        'quantity' => $so_luong
                    ));
                }

                if (isset($_SESSION['id_tai_khoan'])) {
                    $id_tai_khoan = $_SESSION['id_tai_khoan'];
                    $sql = "SELECT id_gio_hang FROM gio_hang WHERE id_nguoi_dung = $id_tai_khoan";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);

                        $id_gio_hang = $row['id_gio_hang'];
                        foreach ($_SESSION['cart'] as $item) {
                            $ma_san_pham = $item['id'];
                            $gia_tien = $item['price'];
                            $so_luong = $item['quantity'];

                            $kiemTraDonHangQuery = "SELECT id_chi_tiet_gio_hang FROM chi_tiet_gio_hang WHERE ma_san_pham = $ma_san_pham";
                            $kiemTraDonHangResult = mysqli_query($conn, $kiemTraDonHangQuery);
                            if ($kiemTraDonHangResult && mysqli_num_rows($kiemTraDonHangResult) > 0) {
                                $row = mysqli_fetch_assoc($kiemTraDonHangResult);
                                $id_chi_tiet_gio_hang = $row['id_chi_tiet_gio_hang'];

                                $update_so_luong_query = "UPDATE chi_tiet_gio_hang SET so_luong = $so_luong WHERE id_chi_tiet_gio_hang = $id_chi_tiet_gio_hang";
                                mysqli_query($conn, $update_so_luong_query);
                            } else {
                                $insert_chi_tiet_gio_hang_query = "INSERT INTO chi_tiet_gio_hang (id_gio_hang, ma_san_pham, gia_tien, so_luong) VALUES ($id_gio_hang, $ma_san_pham, $gia_tien, $so_luong)";
                                mysqli_query($conn, $insert_chi_tiet_gio_hang_query);
                            }
                        }
                    }
                }
            }
        }
    }


    public function xoaSanPhamKhoiGio($conn, $item_id)
    {

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $item_id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }

        if (isset($_SESSION['id_tai_khoan'])) {
            $id_tai_khoan = $_SESSION['id_tai_khoan'];

            $xoaSanPhamQuery = "DELETE FROM chi_tiet_gio_hang WHERE ma_san_pham = $item_id AND id_gio_hang IN (SELECT id_gio_hang FROM gio_hang WHERE id_nguoi_dung = $id_tai_khoan)";
            mysqli_query($conn, $xoaSanPhamQuery);
        }
    }

    public function capNhatSoLuongSanPham($conn, $product_id, $new_quantity)
    {
        $sql = "SELECT so_luong FROM san_pham WHERE ma_san_pham = $product_id";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            http_response_code(500);
            return;
        }

        $row = mysqli_fetch_assoc($result);
        $so_luong_hien_co = $row['so_luong'];

        if (!is_numeric($new_quantity) || $new_quantity <= 0 || $new_quantity > $so_luong_hien_co) {
            http_response_code(400);
            echo 'Số lượng sản phẩm không hợp lệ';
            return;
        }

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $product_id) {
                    $item['quantity'] = $new_quantity;
                    break;
                }
            }
        }

        if (isset($_SESSION['id_tai_khoan'])) {
            $id_tai_khoan = $_SESSION['id_tai_khoan'];
            $update_query = "UPDATE chi_tiet_gio_hang 
                     SET so_luong = $new_quantity 
                     WHERE ma_san_pham = $product_id 
                     AND id_gio_hang IN (SELECT id_gio_hang FROM gio_hang WHERE id_nguoi_dung = $id_tai_khoan)";
            if (mysqli_query($conn, $update_query)) {
                http_response_code(200);
            } else {
                http_response_code(500);
                return;
            }
        }
    }
}