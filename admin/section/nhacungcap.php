<?php require "../config/database.php" ?>
<?php
require '../classes/NhaCungCap.php';
require '../classes/DanhMucNhaCungCap.php';
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();
$obj = new NhaCungCap();
$danh_muc_ncc = new DanhMucNhaCungCap();

if (isset($_POST['themNhaCungCap'])) {
    if ($_SESSION['id_tai_khoan'] !== "1684481330") {
        if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $_SESSION['id_tai_khoan'], 'them_nha_cung_cap')) {
            header('Location: ./index.php?p=nhacungcap&quyen=null');
            exit();
        }
    }
    $ten_nha_cung_cap = $_POST['ten_nha_cung_cap'];
    $dia_chi = $_POST['dia_chi'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $email = $_POST['email'];
    $ma_danh_muc = $_POST['ma_danh_muc'];

    try {
        $obj->themNhaCungCap($conn, $ten_nha_cung_cap, $dia_chi, $so_dien_thoai, $email, $ma_danh_muc);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Thêm nhà cung cấp " . $ten_nha_cung_cap);
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
    echo 'Không được phép xóa do voucher đang tồn tại ở dữ liệu khác';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

if (isset($_GET['delete_success']) && $_GET['delete_success'] === 'true') {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo 'Đã xóa voucher thành công.';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>
<div class="head-page">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#themNhaCungCapModal">Thêm nhà cung
        cấp</button>
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
            <th scope="col" class="text-center bg-primary text-light">Mã nhà cung cấp</th>
            <th scope="col" class="text-center bg-primary text-light">Tên nhà cung cấp</th>
            <th scope="col" class="text-center bg-primary text-light">Địa chỉ</th>
            <th scope="col" class="text-center bg-primary text-light">Số điện thoại</th>
            <th scope="col" class="text-center bg-primary text-light">Email</th>
            <th scope="col" class="text-center bg-primary text-light">Mã danh mục</th>
            <th scope="col" colspan="3" class="text-center bg-primary text-light">Cập nhật</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $obj->layDanhSachNhaCungCap($conn);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["search"])) {
            $searchQuery = $_POST['search_query'];
            $data = $obj->timNhaCungCap($conn, $searchQuery);
        }

        foreach ($data as $row) {
            echo '<tr>';
            echo '<td class="text-center">' . $row['ma_nha_cung_cap'] . '</td>';
            echo '<td class="text-center">' . $row['ten_nha_cung_cap'] . '</td>';
            echo '<td class="text-center">' . $row['dia_chi'] . '</td>';
            echo '<td class="text-center">' . $row['so_dien_thoai'] . '</td>';
            echo '<td class="text-center">' . $row['email'] . '</td>';
            echo '<td class="text-center">' . $row['ma_danh_muc'] . '</td>';
            echo '<td class="text-center edit"><a href="#" data-bs-toggle="modal" data-bs-target="#suaNhaCungCapModal' . $row['ma_nha_cung_cap'] . '" data-bs-readonly="true">Xem chi tiết</a></td>';
            echo '<td class="text-center edit"><a href="#" data-bs-toggle="modal" data-bs-target="#suaNhaCungCapModal' . $row['ma_nha_cung_cap'] . '">Sửa</a></td>';
            echo '<td class="text-center remove"><a href="handle/xoa_nha_cung_cap.php?ma_nha_cung_cap=' . $row['ma_nha_cung_cap'] . '">Xóa</a></td>';
            echo '</tr>';

            /* modal */
            echo '<div class="modal fade" id="suaNhaCungCapModal' . $row['ma_nha_cung_cap'] . '" tabindex="-1" aria-labelledby="suaNhaCungCapModalLabel' . $row['ma_nha_cung_cap'] . '" aria-hidden="true">';
            echo '<div class="modal-dialog">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="suaNhaCungCapModalLabel' . $row['ma_nha_cung_cap'] . '">Sửa nhà cung cấp</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<form method="post" action="handle/sua_nha_cung_cap.php">';
            echo '<input type="hidden" name="ma_nha_cung_cap" value="' . $row['ma_nha_cung_cap'] . '">';
            echo '<div class="mb-3">';
            echo '<label for="ten_nha_cung_cap" class="form-label">Tên nhà cung cấp</label>';
            echo '<input type="text" class="form-control" id="ten_nha_cung_cap" name="ten_nha_cung_cap" value="' . $row['ten_nha_cung_cap'] . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="dia_chi" class="form-label">Địa chỉ</label>';
            echo '<input type="text" class="form-control" id="dia_chi" name="dia_chi" value="' . $row['dia_chi'] . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="so_dien_thoai" class="form-label">Số điện thoại</label>';
            echo '<input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" value="' . $row['so_dien_thoai'] . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="email" class="form-label">Email</label>';
            echo '<input type="text" class="form-control" id="email" name="email" value="' . $row['email'] . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="ma_danh_muc" class="form-label">Mã danh mục</label>';
            echo '<select class="form-select" id="ma_danh_muc" name="ma_danh_muc">';
            $danhMucData = $danh_muc_ncc->layDanhMucNhaCungCap($conn);
            foreach ($danhMucData as $danhMuc) {
                $selected = ($row['ma_danh_muc'] == $danhMuc['ma_danh_muc']) ? 'selected' : '';
                echo '<option value="' . $danhMuc['ma_danh_muc'] . '" ' . $selected . '>' . $danhMuc['ten_danh_muc'] . '</option>';
            }
            echo '</select>';
            echo '</div>';
            echo '<button type="submit" name="suaNhaCungCap" class="btn btn-primary">Lưu</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        ?>
    </tbody>
</table>

<div class="modal fade" id="themNhaCungCapModal" tabindex="-1" aria-labelledby="themNhaCungCapModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="themNhaCungCapModalLabel">Thêm nhà cung cấp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="ten_nha_cung_cap" class="form-label">Tên nhà cung cấp</label>
                        <input type="text" class="form-control" id="ten_nha_cung_cap" name="ten_nha_cung_cap" required>
                    </div>
                    <div class="mb-3">
                        <label for="dia_chi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="dia_chi" name="dia_chi">
                    </div>
                    <div class="mb-3">
                        <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="ma_danh_muc" class="form-label">Mã danh mục</label>
                        <select class="form-select" id="ma_danh_muc" name="ma_danh_muc">
                            <?php
                            $danhMucData = $danh_muc_ncc->layDanhMucNhaCungCap($conn);
                            foreach ($danhMucData as $danhMuc) {
                                echo '<option value="' . $danhMuc['ma_danh_muc'] . '">' . $danhMuc['ten_danh_muc'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="themNhaCungCap" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
<?php
foreach ($data as $row) {
    echo '$(\'#suaNhaCungCapModal' . $row['ma_nha_cung_cap'] . '\').on(\'show.bs.modal\', function(event) {';
    echo 'var button = $(event.relatedTarget);';
    echo 'var readOnly = button.data(\'bs-readonly\');';
    echo 'var modal = $(this);';

    echo 'if (readOnly) {';
    echo 'modal.find(\'.modal-title\').text(\'Thông Tin Nhà Cung Cấp (Chế độ xem chi tiết)\');';
    echo 'modal.find(\'.modal-body input, .modal-body select\').prop(\'disabled\', true);';
    echo '} else {';
    echo 'modal.find(\'.modal-title\').text(\'Thông Tin Nhà Cung Cấp\');';
    echo 'modal.find(\'.modal-body input, .modal-body select\').prop(\'disabled\', false);';
    echo '}';
    echo '});';
}
?>
</script>