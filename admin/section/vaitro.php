<!-- check role -->
<?php require "../config/database.php" ?>
<?php
require '../classes/VaiTro.php';
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();
$obj = new VaiTro();
if (isset($_POST['themLoaiSanPham'])) {
    $tenDanhMuc = $_POST['ten_vai_tro'];
    $chucNang = $_POST['chuc_nang'];
    $id_tai_khoan = $_SESSION['id_tai_khoan'];


    try {
        $obj->themVaiTro($conn, $tenDanhMuc, $id_tai_khoan, $chucNang);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Thêm vai trò " . $tenDanhMuc);
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
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#themLoaiSanPhamModal">Thêm vai
        trò</button>
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
            <th scope="col" class="text-center bg-primary text-light">Tên vai trò</th>
            <th scope="col" class="text-center bg-primary text-light">Xem tất cả chức năng</th>
            <th scope="col" colspan="2" class="text-center bg-primary text-light">Cập nhật</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $obj->layVaiTro($conn);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["search"])) {
            $searchQuery = $_POST['search_query'];
            $data = $obj->timVaiTro($conn, $searchQuery);
        }

        foreach ($data as $row) {
            $suaModalId = 'suaLoaiSanPhamModal' . $row['id_vai_tro'];
            $xemModalId = 'xemSanPhamModal' . $row['id_vai_tro'];
            echo '<tr>';
            echo '<td class="text-center">' . $row['id_vai_tro'] . '</td>';
            echo '<td class="text-center">' . $row['ten_vai_tro'] . '</td>';
            echo '<td class="text-center"><a href="#" class="view" data-bs-toggle="modal" data-bs-target="#' . $xemModalId . '">Xem</a></td>';
            echo '<td class="text-center edit"><a href="#" data-bs-toggle="modal" data-bs-target="#' . $suaModalId . '">Sửa</a></td>';
            echo '<td class="text-center remove"><a href="handle/xoa_vai_tro.php?id_vai_tro=' . $row['id_vai_tro'] . '">Xóa</a></td>';
            echo '</tr>';
            /* modal */
            $chucNang = $row['chuc_nang'];
            echo '<div class="modal fade" id="' . $suaModalId . '" tabindex="-1" aria-labelledby="' . $suaModalId . 'Label" aria-hidden="true">';
            echo '    <div class="modal-dialog modal-dialog-centered">';
            echo '        <div class="modal-content">';
            echo '            <div class="modal-header">';
            echo '                <h5 class="modal-title" id="suaLoaiSanPhamModalLabel">Sửa vai trò</h5>';
            echo '                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '            </div>';
            echo '            <div class="modal-body">';
            echo '                <form method="post" action="handle/sua_vai_tro.php">';
            echo '                    <div class="row mb-3">';
            echo '                        <div class="col">';
            echo '                            <input type="hidden" class="form-control" id="id_vai_tro" name="id_vai_tro" required value="' . $row['id_vai_tro'] . '">';
            echo '                        </div>';
            echo '                    </div>';
            echo '                    <div class="row mb-3">';
            echo '                        <div class="col">';
            echo '                            <label for="ten_vai_tro" class="form-label">Tên vai trò</label>';
            echo '                            <input type="text" class="form-control" id="ten_vai_tro" name="ten_vai_tro" required value="' . $row['ten_vai_tro'] . '">';
            echo '                        </div>';
            echo '                    </div>';
            echo '                    <div class="row mb-3">';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý đơn hàng</label>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="them_don_hang" id="them_don_hang" name="chuc_nang[]"';
            if (in_array("them_don_hang", $chucNang)) {
        echo ' checked';
    }
            echo '>';
            echo '                                <label class="form-check-label" for="them_don_hang">Thêm đơn hàng</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="xac_nhan_don_hang" id="xac_nhan_don_hang" name="chuc_nang[]"';
            if (in_array("xac_nhan_don_hang", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xac_nhan_don_hang">Xác nhận đơn hàng</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý hàng tồn</label>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="cap_nhat_hang_ton" id="cap_nhat_hang_ton" name="chuc_nang[]"';
            if (in_array("cap_nhat_hang_ton", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="cap_nhat_hang_ton">Cập nhật hàng tồn</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                    </div>';
            echo '                    <div class="row mb-3">';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý phiếu nhập kho</label>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="tao_phieu_nhap_kho" id="tao_phieu_nhap_kho" name="chuc_nang[]"';
            if (in_array("tao_phieu_nhap_kho", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="tao_phieu_nhap_kho">Tạo phiếu nhập kho</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="chinh_sua_phieu_nhap_kho" id="chinh_sua_phieu_nhap_kho" name="chuc_nang[]"';
            if (in_array("chinh_sua_phieu_nhap_kho", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="chinh_sua_phieu_nhap_kho">Chỉnh sửa phiếu nhập kho</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="xoa_phieu_nhap_kho" id="xoa_phieu_nhap_kho" name="chuc_nang[]"';
            if (in_array("xoa_phieu_nhap_kho", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xoa_phieu_nhap_kho">Xóa phiếu nhập kho</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý sản phẩm</label>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="them_san_pham" id="them_san_pham" name="chuc_nang[]"';
            if (in_array("them_san_pham", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="them_san_pham">Thêm sản phẩm</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="sua_san_pham" id="sua_san_pham" name="chuc_nang[]"';
            if (in_array("sua_san_pham", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="sua_san_pham">Sửa sản phẩm</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="xoa_san_pham" id="xoa_san_pham" name="chuc_nang[]"';
            if (in_array("xoa_san_pham", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xoa_san_pham">Xóa sản phẩm</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                    </div>';
            echo '                    <div class="row mb-3">';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý danh mục</label>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="them_danh_muc" id="them_danh_muc" name="chuc_nang[]"';
            if (in_array("them_danh_muc", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="them_danh_muc">Thêm danh mục</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="sua_danh_muc" id="sua_danh_muc" name="chuc_nang[]"';
            if (in_array("sua_danh_muc", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="sua_danh_muc">Sửa danh mục</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="xoa_danh_muc" id="xoa_danh_muc" name="chuc_nang[]"';
            if (in_array("xoa_danh_muc", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xoa_danh_muc">Xóa danh mục</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge" for="them_don_vi">Quản lý đơn vị tính</label>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="them_don_vi" id="them_don_vi" name="chuc_nang[]"';
            if (in_array("them_don_vi", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="them_don_vi">Thêm đơn vị tính</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="sua_don_vi" id="sua_don_vi" name="chuc_nang[]"';
            if (in_array("sua_don_vi", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="sua_don_vi">Sửa đơn vị tính</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input class="form-check-input" type="checkbox" value="xoa_don_vi" id="xoa_don_vi" name="chuc_nang[]"';
            if (in_array("xoa_don_vi", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xoa_don_vi">Xóa đơn vị tính</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                    </div>';
            echo '                    <button type="submit" name="suaVaiTro" class="btn btn-primary">Lưu</button>';
            echo '                </form>';
            echo '            </div>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';


            /* modal xem chi tiết sản phẩm */
            echo '<div class="modal fade" id="xemSanPhamModal' . $row['id_vai_tro'] . '" tabindex="-1" aria-labelledby="xemSanPhamModalLabel' . $row['id_vai_tro'] . '" aria-hidden="true">';
            echo '<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 550px;">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="xemSanPhamModalLabel' . $row['id_vai_tro'] . '">Xem chi tiết sản phẩm</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '                    <div class="row mb-3">';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý đơn hàng</label>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="them_don_hang" id="them_don_hang" name="chuc_nang[]"';
            if (in_array("them_don_hang", $chucNang)) {
        echo ' checked';
    }
            echo '>';
            echo '                                <label class="form-check-label" for="them_don_hang">Thêm đơn hàng</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="xac_nhan_don_hang" id="xac_nhan_don_hang" name="chuc_nang[]"';
            if (in_array("xac_nhan_don_hang", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xac_nhan_don_hang">Xác nhận đơn hàng</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý hàng tồn</label>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="cap_nhat_hang_ton" id="cap_nhat_hang_ton" name="chuc_nang[]"';
            if (in_array("cap_nhat_hang_ton", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="cap_nhat_hang_ton">Cập nhật hàng tồn</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                    </div>';
            echo '                    <div class="row mb-3">';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý phiếu nhập kho</label>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="tao_phieu_nhap_kho" id="tao_phieu_nhap_kho" name="chuc_nang[]"';
            if (in_array("tao_phieu_nhap_kho", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="tao_phieu_nhap_kho">Tạo phiếu nhập kho</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="chinh_sua_phieu_nhap_kho" id="chinh_sua_phieu_nhap_kho" name="chuc_nang[]"';
            if (in_array("chinh_sua_phieu_nhap_kho", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="chinh_sua_phieu_nhap_kho">Chỉnh sửa phiếu nhập kho</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="xoa_phieu_nhap_kho" id="xoa_phieu_nhap_kho" name="chuc_nang[]"';
            if (in_array("xoa_phieu_nhap_kho", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xoa_phieu_nhap_kho">Xóa phiếu nhập kho</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý sản phẩm</label>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="them_san_pham" id="them_san_pham" name="chuc_nang[]"';
            if (in_array("them_san_pham", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="them_san_pham">Thêm sản phẩm</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="sua_san_pham" id="sua_san_pham" name="chuc_nang[]"';
            if (in_array("sua_san_pham", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="sua_san_pham">Sửa sản phẩm</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="xoa_san_pham" id="xoa_san_pham" name="chuc_nang[]"';
            if (in_array("xoa_san_pham", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xoa_san_pham">Xóa sản phẩm</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                    </div>';
            echo '                    <div class="row mb-3">';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge">Quản lý danh mục</label>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="them_danh_muc" id="them_danh_muc" name="chuc_nang[]"';
            if (in_array("them_danh_muc", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="them_danh_muc">Thêm danh mục</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="sua_danh_muc" id="sua_danh_muc" name="chuc_nang[]"';
            if (in_array("sua_danh_muc", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="sua_danh_muc">Sửa danh mục</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="xoa_danh_muc" id="xoa_danh_muc" name="chuc_nang[]"';
            if (in_array("xoa_danh_muc", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xoa_danh_muc">Xóa danh mục</label>';
            echo '                            </div>';
            echo '                        </div>';
            echo '                        <div class="col">';
            echo '                            <label class="form-check-label bg-primary badge" for="them_don_vi">Quản lý đơn vị tính</label>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="them_don_vi" id="them_don_vi" name="chuc_nang[]"';
            if (in_array("them_don_vi", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="them_don_vi">Thêm đơn vị tính</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="sua_don_vi" id="sua_don_vi" name="chuc_nang[]"';
            if (in_array("sua_don_vi", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="sua_don_vi">Sửa đơn vị tính</label>';
            echo '                            </div>';
            echo '                            <div class="form-check">';
            echo '                                <input onclick="return false;" class="form-check-input" type="checkbox" value="xoa_don_vi" id="xoa_don_vi" name="chuc_nang[]"';
            if (in_array("xoa_don_vi", $chucNang)) {
                echo ' checked';
            }
            echo '>';
            echo '                                <label class="form-check-label" for="xoa_don_vi">Xóa đơn vị tính</label>';
            echo '                            </div>';
            echo '                        </div>';
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="themLoaiSanPhamModalLabel">Thêm vai trò</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="ten_vai_tro" class="form-label">Tên vai trò</label>
                            <input type="text" class="form-control" id="ten_vai_tro" name="ten_vai_tro" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-check-label bg-primary badge">Quản lý đơn hàng</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="them_don_hang" id="them_don_hang"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="them_don_hang">Thêm đơn hàng</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="xac_nhan_don_hang"
                                    id="xac_nhan_don_hang" name="chuc_nang[]">
                                <label class="form-check-label" for="xac_nhan_don_hang">Xác nhận đơn hàng</label>
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-check-label bg-primary badge">Quản lý hàng tồn</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="cap_nhat_hang_ton"
                                    id="cap_nhat_hang_ton" name="chuc_nang[]">
                                <label class="form-check-label" for="cap_nhat_hang_ton">Cập nhật hàng tồn</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-check-label bg-primary badge">Quản lý phiếu nhập kho</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="tao_phieu_nhap_kho"
                                    id="tao_phieu_nhap_kho" name="chuc_nang[]">
                                <label class="form-check-label" for="tao_phieu_nhap_kho">Tạo phiếu nhập kho</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="chinh_sua_phieu_nhap_kho"
                                    id="chinh_sua_phieu_nhap_kho" name="chuc_nang[]">
                                <label class="form-check-label" for="chinh_sua_phieu_nhap_kho">Chỉnh sửa phiếu nhập
                                    kho</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="xoa_phieu_nhap_kho"
                                    id="xoa_phieu_nhap_kho" name="chuc_nang[]">
                                <label class="form-check-label" for="xoa_phieu_nhap_kho">Xóa phiếu nhập kho</label>
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-check-label bg-primary badge">Quản lý sản phẩm</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="them_san_pham" id="them_san_pham"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="them_san_pham">Thêm sản phẩm</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="sua_san_pham" id="sua_san_pham"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="sua_san_pham">Sửa sản phẩm</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="xoa_san_pham" id="xoa_san_pham"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="xoa_san_pham">Xóa sản phẩm</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-check-label bg-primary badge">Quản lý danh mục</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="them_danh_muc" id="them_danh_muc"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="them_danh_muc">Thêm danh mục</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="sua_danh_muc" id="sua_danh_muc"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="sua_danh_muc">Sửa danh mục</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="xoa_danh_muc" id="xoa_danh_muc"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="xoa_danh_muc">Xóa danh mục</label>
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-check-label bg-primary badge" for="them_don_vi">Quản lý đơn vị
                                tính</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="them_don_vi" id="them_don_vi"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="them_don_vi">Thêm đơn vị tính</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="sua_don_vi" id="sua_don_vi"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="sua_don_vi">Sửa đơn vị tính</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="xoa_don_vi" id="xoa_don_vi"
                                    name="chuc_nang[]">
                                <label class="form-check-label" for="xoa_don_vi">Xóa đơn vị tính</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="themLoaiSanPham" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>