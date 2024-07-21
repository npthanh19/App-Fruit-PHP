<?php
require "../config/database.php";
require '../classes/SanPham.php';
require '../classes/ChiTietVaiTro.php';

$objChiTietVaiTro = new ChiTietVaiTro();
$sanpham_obj = new SanPham();

if (isset($_GET['ma_san_pham'])) {
    $id_san_pham = $_GET['ma_san_pham'];
    $sanpham_obj->xemChiTietSanPham($conn, $id_san_pham);
} else {
    header('Location: ./index.php?p=sanpham');
    exit();
}
?>

<?php
$sqlDanhMuc = "SELECT * FROM danh_muc_san_pham";
$resultDanhMuc = $conn->query($sqlDanhMuc);

$selectOptionsDanhMuc = '';
if ($resultDanhMuc->num_rows > 0) {
    while ($row = $resultDanhMuc->fetch_assoc()) {
        $ma_danh_muc = $row['ma_danh_muc'];
        $ten_danh_muc = $row['ten_danh_muc'];
        $selected = ($ma_danh_muc == $sanpham_obj->danh_muc_san_pham) ? 'selected' : '';
        $selectOptionsDanhMuc .= "<option value='$ma_danh_muc' $selected>$ten_danh_muc</option>";
    }
}
?>

<?php
$sqlDonViTinh = "SELECT * FROM don_vi_tinh";
$resultDonViTinh = $conn->query($sqlDonViTinh);

$selectOptionsDonViTinh = '';
if ($resultDonViTinh->num_rows > 0) {
    while ($row = $resultDonViTinh->fetch_assoc()) {
        $ma_don_vi_tinh = $row['ma_don_vi_tinh'];
        $ten_don_vi_tinh = $row['ten_don_vi_tinh'];
        $selected = ($ma_don_vi_tinh == $sanpham_obj->ma_don_vi_tinh) ? 'selected' : '';
        $selectOptionsDonViTinh .= "<option value='$ma_don_vi_tinh' $selected>$ten_don_vi_tinh</option>";
    }
}
?>


<form method="post" enctype="multipart/form-data" action="handle/sua_san_pham.php">
    <div class="mb-3">
        <label for="ten_san_pham">Tên sản phẩm:</label>
        <input type="text" class="form-control" id="ten_san_pham" name="ten_san_pham" required
            value="<?php echo $sanpham_obj->ten_san_pham; ?>">
    </div>
    <div class="mb-3">
        <label for="gia_nhap">Giá nhập:</label>
        <input type="number" class="form-control" id="gia_nhap" name="gia_nhap" step="0.01" required
            value="<?php echo $sanpham_obj->gia_nhap; ?>">
    </div>
    <div class="mb-3">
        <label for="gia_ban">Giá bán:</label>
        <input type="number" class="form-control" id="gia_ban" name="gia_ban" step="0.01" required
            value="<?php echo $sanpham_obj->gia_ban; ?>">
    </div>
    <div class="mb-3">
        <label for="xuat_xu">Xuất xứ:</label>
        <input type="text" class="form-control" id="xuat_xu" name="xuat_xu" required
            value="<?php echo $sanpham_obj->xuat_xu; ?>">
    </div>
    <div class="mb-3">
        <label for="anh_san_pham">Ảnh sản phẩm:</label>
        <input type="file" class="form-control" id="anh_san_pham" name="anh_san_pham" accept="image"
            value="<?php echo $sanpham_obj->anh_san_pham; ?>">
    </div>
    <div class="mb-3">
        <label for="danh_muc_san_pham">Loại sản phẩm:</label>
        <select class="form-control" id="danh_muc_san_pham" name="danh_muc_san_pham" required
            value="<?php echo $sanpham_obj->danh_muc_san_pham; ?>">
            <?php echo $selectOptionsDanhMuc; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="don_vi_tinh">Đon vị tính</label>
        <select class="form-control" id="don_vi_tinh" name="don_vi_tinh" required
            value="<?php echo $sanpham_obj->ma_don_vi_tinh; ?>">
            <?php echo $selectOptionsDonViTinh; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="mo_ta_san_pham">Mô tả sản phẩm:</label>
        <div id="editor">
            <?php echo $sanpham_obj->mo_ta_san_pham; ?>
        </div>
        <input type="hidden" id="mo_ta_san_pham_hidden" name="mo_ta_san_pham_hidden">
    </div>
    <input type="hidden" id="ma_san_pham" name="ma_san_pham" value="<?php echo $sanpham_obj->ma_san_pham; ?>">
    <div class="mb-3">
        <button type="submit" class="btn btn-primary" name="suaSanPham">Sửa sản phẩm</button>
    </div>
</form>

<script>
var quill = new Quill('#editor', {
    theme: 'snow'
});
document.querySelector('form').addEventListener('submit', function() {
    var mo_ta_san_pham_hidden = document.getElementById('mo_ta_san_pham_hidden');
    mo_ta_san_pham_hidden.value = quill.root.innerHTML;
});
</script>