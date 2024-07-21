<!-- check role -->
<?php require "../config/database.php" ?>
<?php
require '../classes/DanhMucNhaCungCap.php';
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();
$obj = new DanhMucNhaCungCap();
if (isset($_POST['themLoaiSanPham'])) {
    if ($_SESSION['id_tai_khoan'] !== "1684481330") {
        if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $_SESSION['id_tai_khoan'], 'them_danh_muc_ncc')) {
            header('Location: ./index.php?p=danhmucncc&quyen=null');
            exit();
        }
    }
    $ma_danh_muc = time();
    $ten_danh_muc = $_POST['ten_danh_muc'];

    try {
        $obj->themDanhMucNhaCungCap($conn,$ten_danh_muc);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Thêm danh mục nhà cung cấp " .  $ten_danh_muc);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    } catch (Exception $e) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo $e->getMessage();
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}
?>
<?php
if (isset($_GET['quyen']) && $_GET['quyen'] === 'null') {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo 'Bạn không được cấp quyền';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>
<?php
if (isset($_GET['delete_error']) && $_GET['delete_error'] === 'true') {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo 'Không được phép xóa do danh mục đang tồn tại ở dữ liệu kho';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

if (isset($_GET['delete_success']) && $_GET['delete_success'] === 'true') {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo 'Đã xóa danh mục thành công.';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>
<div class="head-page">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#themLoaiSanPhamModal">Thêm danh
        mục</button>
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
    <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center bg-primary text-light">ID</th>
            <th scope="col" class="text-center bg-primary text-light">Tên danh mục</th>
            <th scope="col" class="text-center bg-primary text-light">Xem sản phẩm thuộc danh mục</th>
            <th scope="col" colspan="2" class="text-center bg-primary text-light">Cập nhật</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $obj->layDanhMucNhaCungCap($conn);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["search"])) {
            $searchQuery = $_POST['search_query'];
            $data = $obj->timDanhMuc($conn, $searchQuery);
        }

        foreach ($data as $row) {
            echo '<tr>';
            echo '<td class="text-center">' . $row['ma_danh_muc'] . '</td>';
            echo '<td class="text-center">' . $row['ten_danh_muc'] . '</td>';
            echo '<td class="text-center"><a href="#" class="view" data-bs-toggle="modal" data-bs-target="#xemSanPhamModal' . $row['ma_danh_muc'] . '">Xem</a></td>';
            echo '<td class="text-center edit"><a href="#" data-bs-toggle="modal" data-bs-target="#suaLoaiSanPhamModal' . $row['ma_danh_muc'] . '">Sửa</a></td>';
            echo '<td class="text-center remove"><a href="handle/xoa_danh_muc_ncc.php?ma_danh_muc=' . $row['ma_danh_muc'] . '">Xóa</a></td>';
            echo '</tr>';

            /* modal */
            echo '<div class="modal fade" id="suaLoaiSanPhamModal' . $row['ma_danh_muc'] . '" tabindex="-1" aria-labelledby="suaLoaiSanPhamModalLabel' . $row['ma_danh_muc'] . '" aria-hidden="true">';
            echo '<div class="modal-dialog">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="suaLoaiSanPhamModalLabel' . $row['ma_danh_muc'] . '">Sửa danh mục</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<form method="post" action="handle/sua_danh_muc_ncc.php">';
            echo '<input type="hidden" name="ma_danh_muc" value="' . $row['ma_danh_muc'] . '">';
            echo '<div class="mb-3">';
            echo '<label for="ten_danh_muc" class="form-label">Tên danh mục</label>';
            echo '<input type="text" class="form-control" id="ten_danh_muc" name="ten_danh_muc" value="' . $row['ten_danh_muc'] . '" required>';
            echo '</div>';
            echo '<button type="submit" name="suaDanhMuc" class="btn btn-primary">Lưu</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            $categoryId = $row['ma_danh_muc'];
            $productQuery = "SELECT * FROM san_pham WHERE danh_muc_san_pham = $categoryId";
            $products = $conn->query($productQuery);
            /* modal xem chi tiết sản phẩm */
            echo '<div class="modal fade" id="xemSanPhamModal' . $row['ma_danh_muc'] . '" tabindex="-1" aria-labelledby="xemSanPhamModalLabel' . $row['ma_danh_muc'] . '" aria-hidden="true">';
            echo '<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 550px;">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="xemSanPhamModalLabel' . $row['ma_danh_muc'] . '">Xem chi tiết sản phẩm</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<ul class="list-group" style="max-height: 400px; overflow-y: scroll;">';

            if ($products->num_rows > 0) {
                while ($product = $products->fetch_assoc()) {
                    echo '<li class="list-group-item">';
                    echo '<h6 class="mb-1">Mã sản phẩm: ' . $product['ma_san_pham'] . '</h6>';
                    echo '<div class="d-flex justify-content-between">';
                    echo '<span>Tên sản phẩm: ' . $product['ten_san_pham'] . '</span>';
                    echo '<span class="fw-bold">Giá sản phẩm: ' . number_format($product['gia_ban'], 0, ',', '.') . '.000 VND</span>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                echo '<li class="list-group-item">Không có sản phẩm thuộc loại sản phẩm này.</li>';
            }

            echo '</ul>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        ?>
    </tbody>
</table>


<div class="modal fade" id="themLoaiSanPhamModal" tabindex="-1" aria-labelledby="themLoaiSanPhamModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="themLoaiSanPhamModalLabel">Thêm danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="ten_danh_muc" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="ten_danh_muc" name="ten_danh_muc" required>
                    </div>
                    <button type="submit" name="themLoaiSanPham" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>