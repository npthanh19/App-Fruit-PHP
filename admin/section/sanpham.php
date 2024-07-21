<?php require "../config/database.php" ?>
<?php
if (isset($_GET['quyen']) && $_GET['quyen'] === 'null') {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo 'Bạn không được cấp quyền';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>
<?php
require '../classes/SanPham.php';
require '../classes/ChiTietVaiTro.php';
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();
$objChiTietVaiTro = new ChiTietVaiTro();

if (isset($_POST['themSanPham'])) {

    if ($_SESSION['id_tai_khoan'] !== "1684481330") {
        if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $_SESSION['id_tai_khoan'], 'them_san_pham')) {
            header('Location: ./index.php?p=sanpham&quyen=null');
            exit();
        }
    }

    $sanpham_obj = new SanPham();
    $ma_san_pham = time();
    $ten_san_pham = $_POST['ten_san_pham'];
    $gia_nhap = $_POST['gia_nhap'];
    $gia_ban = $_POST['gia_ban'];
    $xuat_xu = $_POST['xuat_xu'];
    $anh_san_pham = '';
    $danh_muc_san_pham = $_POST['danh_muc_san_pham'];
    $mo_ta_san_pham = $_POST['mo_ta_san_pham'];
    $ma_don_vi_tinh = $_POST['don_vi_tinh'];

    if (isset($_FILES['anh_san_pham']) && $_FILES['anh_san_pham']['error'] == 0) {
        $anh_san_pham = file_get_contents($_FILES['anh_san_pham']['tmp_name']);
        $image_info = getimagesize($_FILES['anh_san_pham']['tmp_name']);

        if (!$image_info || !in_array($image_info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF])) {
            echo "File ảnh không đúng định dạng! Vui lòng chọn file ảnh có định dạng JPEG, PNG hoặc GIF.";
        } else {
            $anh_san_pham = base64_encode($anh_san_pham);
            $sanpham_obj = new SanPham();
            $sanpham_obj->themSanPham($conn, $ma_san_pham, $ten_san_pham, $gia_nhap, $gia_ban, $xuat_xu, $anh_san_pham, $danh_muc_san_pham, $mo_ta_san_pham, $ma_don_vi_tinh);
            $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Thêm sản phẩm " . $ten_san_pham);
            header('Location: ./index.php?p=sanpham');
            exit();
        }
    }
}
?>
<?php
if (isset($_GET['delete_error']) && $_GET['delete_error'] === 'true') {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo 'Không được phép xóa do sản phẩm đang tồn tại ở dữ liệu kho';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

if (isset($_GET['delete_success']) && $_GET['delete_success'] === 'true') {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo 'Đã xóa sản phẩm thành công.';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>



<div class="head-page">
    <a class="btn btn-primary" href="./index.php?p=themsanpham">Thêm sản
        phẩm</a>
    <form method="post" action="">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="search_query">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <input type="hidden" name="search" />
    </form>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col" class="text-center bg-primary text-light">ID</th>
            <th scope="col" class="text-center bg-primary text-light">Danh mục</th>
            <th scope="col" class="text-center bg-primary text-light">Tên</th>
            <th scope="col" class="text-center bg-primary text-light">Xuất xứ</th>
            <th scope="col" class="text-center bg-primary text-light">Giá nhập</th>
            <th scope="col" class="text-center bg-primary text-light">Giá bán</th>
            <th scope="col" colspan="2" class="text-center bg-primary text-light">Cập nhật</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sanpham_obj = new SanPham();
        $data = $sanpham_obj->layTatCaSanPham($conn);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["search"])) {
            $searchQuery = $_POST['search_query'];
            $data = $sanpham_obj->timSanPham($conn, $searchQuery);
        }


        foreach ($data as $row) {
            echo '<tr>';
            echo '<td class="text-center">' . $row->ma_san_pham . '</td>';
            echo '<td class="text-center">' . $row->danh_muc_san_pham . '</td>';
            echo '<td class="text-center">' . $row->ten_san_pham . '</td>';
            echo '<td class="text-center">' . $row->xuat_xu . '</td>';
            echo '<td class="text-center">' . number_format($row->gia_nhap, 0, ',', '.') . '.000 VND</td>';
            echo '<td class="text-center">' . number_format($row->gia_ban, 0, ',', '.') . '.000 VND</td>';
            echo '<td class="text-center edit"><a href="./index.php?p=suasanpham&ma_san_pham=' . $row->ma_san_pham . '">Sửa</a></td>';
            echo '<td class="text-center remove"><a href="handle/xoa_san_pham.php?ma_san_pham=' . $row->ma_san_pham . '">Xóa</a></td>';
            echo '</tr>';

        }
        ?>
    </tbody>
</table>