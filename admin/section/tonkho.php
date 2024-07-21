<?php require "../config/database.php" ?>
<?php
if (isset($_GET['quyen']) && $_GET['quyen'] === 'null') {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo 'Bạn không được cấp quyền cập nhật hàng tồn';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>
<div class="head-page">
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
            <th scope="col" class="text-center bg-primary text-light">Mã sản phẩm</th>
            <th scope="col" class="text-center bg-primary text-light">Sản phẩm</th>
            <th scope="col" class="text-center bg-primary text-light">Giá trị vốn</th>
            <th scope="col" class="text-center bg-primary text-light">Số lượng</th>
            <th scope="col" colspan="2" class="text-center bg-primary text-light">Cập nhật</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include("../classes/SanPham.php");
        $sanpham_obj = new SanPham();
        $data = $sanpham_obj->layTatCaSanPham($conn);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["search"])) {
            $searchQuery = $_POST['search_query'];
            $data = $sanpham_obj->timSanPham($conn, $searchQuery);
        }

        foreach ($data as $row) {
            $gia_tri_von = ($row->gia_ban * $row->so_luong);
            echo '<form method="POST" action="handle/cap_nhat_hang_ton.php">';
            echo '<tr>';
            echo '<td class="text-center">' . $row->ma_san_pham . '</td>';
            echo '<td class="text-center">' . $row->ten_san_pham . '</td>';
            echo '<td class="text-center remove">'.  number_format($gia_tri_von, 0, ',', '.') . '.000 VND</td>';
            echo '<td class="text-center">';
            echo '<input type="number" class="text-center form-control" name="so_luong" value="' . $row->so_luong . '" min="0">';
            echo '</td>';
            echo '<td class="text-center remove"><button type="submit" class="btn btn-primary" name="capNhatHangTon">Cập nhật</button></td>';
            echo '</tr>';
            echo '<input type="hidden" class="form-control" id="ma_san_pham" name="ma_san_pham" required value="' . $row->ma_san_pham . '">';
            echo '</form>';
        }
        ?>
    </tbody>
</table>

<?php
$sql = "SELECT * FROM danh_muc_san_pham";
$result = $conn->query($sql);

$selectOptions = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ma_danh_muc = $row['ma_danh_muc'];
        $ten_danh_muc = $row['ten_danh_muc'];
        $selectOptions .= "<option value='$ma_danh_muc'>$ten_danh_muc</option>";
    }
}
?>
<div class="modal fade" id="themLoaiSanPhamModal" tabindex="-1" aria-labelledby="themSanPhamModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="themSanPhamModalLabel">Thêm sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="ten_san_pham">Tên sản phẩm:</label>
                        <input type="text" class="form-control" id="ten_san_pham" name="ten_san_pham" required>
                    </div>
                    <div class="mb-3">
                        <label for="gia_san_pham">Giá sản phẩm:</label>
                        <input type="number" class="form-control" id="gia_san_pham" name="gia_san_pham" step="0.01"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="xuat_xu">Xuất xứ:</label>
                        <input type="text" class="form-control" id="xuat_xu" name="xuat_xu" required>
                    </div>
                    <div class="mb-3">
                        <label for="anh_san_pham">Ảnh sản phẩm:</label>
                        <input type="file" class="form-control" id="anh_san_pham" name="anh_san_pham" accept="image"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="danh_muc_san_pham">Loại sản phẩm:</label>
                        <select class="form-control" id="danh_muc_san_pham" name="danh_muc_san_pham" required>
                            <?php echo $selectOptions; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mo_ta_san_pham">Mô tả sản phẩm:</label>
                        <textarea class="form-control" id="mo_ta_san_pham" name="mo_ta_san_pham" required></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="themSanPham">Thêm sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>