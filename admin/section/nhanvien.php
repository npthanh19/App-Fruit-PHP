<?php require "../config/database.php" ?>
<?php
require '../classes/Admin.php';
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();
$obj = new Admin();
if (isset($_POST['themUser'])) {
    $ten_tai_khoan = $_POST['ten_tai_khoan'];
    $tai_khoan = $_POST['ten_tai_khoan'];
    $mat_khau = $_POST['mat_khau'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $loai_tai_khoan = $_POST['loai_tai_khoan'];
    $vai_tro = $_POST['vai_tro'];
    try {
        $obj->createTaiKhoan($conn, $ten_tai_khoan, $tai_khoan, $mat_khau, $email, $so_dien_thoai, $loai_tai_khoan, $vai_tro);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Thêm tài khoản " . $ten_tai_khoan);
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
    echo 'Không được phép xóa do tài khoản đang tồn tại ở dữ liệu kho';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

if (isset($_GET['delete_success']) && $_GET['delete_success'] === 'true') {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo 'Đã xóa tài khoản thành công.';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>
<?php 
$sql = "SELECT * FROM vaI_tro";
$result = $conn->query($sql);
$selectOptions = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_vai_tro = $row['id_vai_tro'];
        $ten_vai_tro = $row['ten_vai_tro'];
        $selectOptions .= "<option value='$id_vai_tro'>$ten_vai_tro</option>";
    }
}
?>
<div class="head-page">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#themLoaiSanPhamModal">Thêm tài
        khoản</button>
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
            <th scope="col" class="text-center bg-primary text-light">Username</th>
            <th scope="col" class="text-center bg-primary text-light">Password</th>
            <th scope="col" class="text-center bg-primary text-light">Số điện thoại</th>
            <th scope="col" class="text-center bg-primary text-light">Role</th>
            <th scope="col" class="text-center bg-primary text-light">Vai trò</th>
            <th scope="col" colspan="2" class="text-center bg-primary text-light">Cập nhật</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $obj->layTaiKhoanTheoRole($conn, "nhanvien");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["search"])) {
            $searchQuery = $_POST['search_query'];
            /* $data = $obj->timUser($conn, $searchQuery); */
        }

        foreach ($data as $row) {
            echo '<tr>';
            echo '<td class="text-center">' . $row->id_tai_khoan . '</td>';
            echo '<td class="text-center">' . $row->ten_tai_khoan . '</td>';
            echo '<td class="text-center">' . $row->email . '</td>';
            echo '<td class="text-center">' . $row->so_dien_thoai . '</td>';
            echo '<td class="text-center">' . $row->loai_tai_khoan . '</td>';
            echo '<td class="text-center">' . $row->vai_tro . '</td>';
            echo '<td class="text-center edit"><a href="#" data-bs-toggle="modal" data-bs-target="#suaLoaiSanPhamModal' . $row->id_tai_khoan . '">Sửa</a></td>';
            echo '<td class="text-center remove"><a href="handle/xoa_user.php?id_tai_khoan=' . $row->id_tai_khoan . '">Xóa</a></td>';
            echo '</tr>';

            /* modal */
            echo '<div class="modal fade" id="suaLoaiSanPhamModal' . $row->id_tai_khoan . '" tabindex="-1" aria-labelledby="suaLoaiSanPhamModalLabel' . $row->id_tai_khoan . '" aria-hidden="true">';
            echo '<div class="modal-dialog">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="suaLoaiSanPhamModalLabel' . $row->id_tai_khoan . '">Sửa tài khoản</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<form method="post" action="handle/sua_user.php">';
            echo '<input type="hidden" name="user_id" value="' . $row->id_tai_khoan . '">';
            echo '<div class="mb-3">';
            echo '<label for="ten_tai_khoan" class="form-label">Tên tài khoản</label>';
            echo '<input type="text" class="form-control" id="ten_tai_khoan" name="ten_tai_khoan" value="' . $row->ten_tai_khoan . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="tai_khoan" class="form-label">Tài khoản</label>';
            echo '<input type="text" class="form-control" id="tai_khoan" name="tai_khoan" value="' . $row->tai_khoan . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="mat_khau" class="form-label">Mật khẩu</label>';
            echo '<input type="text" class="form-control" id="mat_khau" name="mat_khau" value="' . $row->mat_khau . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="email" class="form-label">Email</label>';
            echo '<input type="text" class="form-control" id="email" name="email" value="' . $row->email . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="so_dien_thoai" class="form-label">Số điện thoại</label>';
            echo '<input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" value="' . $row->so_dien_thoai . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="role" class="form-label">Role</label>';
            echo '<select class="form-select" id="role" name="role" required>';
            echo '<option value="admin" ' . ($row->loai_tai_khoan === 'admin' ? 'selected' : '') . '>Admin</option>';
            echo '<option value="quản lí kho" ' . ($row->loai_tai_khoan === 'quản lí kho' ? 'selected' : '') . '>Quản lí kho</option>';
            echo '</select>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="vai_tro" class="form-label">Vai trò</label>';
            $sqlVaiTro = "SELECT * FROM vai_tro";
            $resultVaiTro = $conn->query($sqlVaiTro);

            if ($resultVaiTro->num_rows > 0) {
                echo '<select class="form-control" id="vai_tro" name="vai_tro" required>';
                while ($rowVaiTro = $resultVaiTro->fetch_assoc()) {
                    $selected = ($rowVaiTro['id_vai_tro'] == $row->vai_tro) ? 'selected' : '';
                    echo "<option value='{$rowVaiTro['id_vai_tro']}' $selected>{$rowVaiTro['ten_vai_tro']}</option>";
                }
                echo '</select>';
            } else {
                echo 'Không có danh mục sản phẩm nào trong cơ sở dữ liệu.';
            }

            echo '</div>';
            echo '<button type="submit" name="suaUser" class="btn btn-primary">Lưu</button>';
            echo '</form>';
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
                <h5 class="modal-title" id="themLoaiSanPhamModalLabel">Thêm tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="index.php?p=nhanvien">
                    <div class="mb-3">
                        <label for="ten_tai_khoan" class="form-label">Tên tài khoản</label>
                        <input type="text" class="form-control" id="ten_tai_khoan" name="ten_tai_khoan" required>
                    </div>
                    <div class="mb-3">
                        <label for="ai_khoan" class="form-label">Tài khoản</label>
                        <input type="text" class="form-control" id="tai_khoan" name="tai_khoan" required>
                    </div>
                    <div class="mb-3">
                        <label for="mat_khau" class="form-label">Mật khẩu</label>
                        <input type="text" class="form-control" id="mat_khau" name="mat_khau" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" required>
                    </div>
                    <div class="mb-3">
                        <label for="loai_tai_khoan" class="form-label">Loại tài khoản</label>
                        <select class="form-select" id="loai_tai_khoan" name="loai_tai_khoan" required>
                            <option value="admin">Admin</option>
                            <option value="nhanvien">Nhân viên</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="vai_tro">Vai trò</label>
                        <select class="form-control" id="vai_tro" name="vai_tro" required>
                            <?php echo $selectOptions; ?>
                        </select>
                    </div>
                    <button type="submit" name="themUser" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>