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
    $mo_ta_san_pham = $_POST['mo_ta_san_pham_hidden'];
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
$sqlDanhMuc = "SELECT * FROM danh_muc_san_pham";
$resultDanhMuc = $conn->query($sqlDanhMuc);

$selectOptionsDanhMuc = '';
if ($resultDanhMuc->num_rows > 0) {
    while ($row = $resultDanhMuc->fetch_assoc()) {
        $ma_danh_muc = $row['ma_danh_muc'];
        $ten_danh_muc = $row['ten_danh_muc'];
        $selectOptionsDanhMuc .= "<option value='$ma_danh_muc'>$ten_danh_muc</option>";
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
        $selectOptionsDonViTinh .= "<option value='$ma_don_vi_tinh'>$ten_don_vi_tinh</option>";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="ten_san_pham">Tên sản phẩm:</label>
        <input type="text" class="form-control" id="ten_san_pham" name="ten_san_pham" required>
    </div>
    <div class="mb-3">
        <label for="gia_nhap">Giá nhập:</label>
        <input type="number" class="form-control" id="gia_nhap" name="gia_nhap" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="gia_ban">Giá bán:</label>
        <input type="number" class="form-control" id="gia_ban" name="gia_ban" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="xuat_xu">Xuất xứ:</label>
        <input type="text" class="form-control" id="xuat_xu" name="xuat_xu" required>
    </div>
    <div class="mb-3">
        <label for="anh_san_pham">Ảnh sản phẩm:</label>
        <input type="file" class="form-control" id="anh_san_pham" name="anh_san_pham" accept="image" required>
    </div>
    <div class="mb-3">
        <label for="danh_muc_san_pham">Loại sản phẩm:</label>
        <?php 
        $sqlDanhMucSanPham = "SELECT ma_danh_muc, ten_danh_muc FROM danh_muc_san_pham";
            $resultDanhMucSanPham = $conn->query($sqlDanhMucSanPham);

            if ($resultDanhMucSanPham->num_rows > 0) {
                echo '<select class="form-control" id="danh_muc_san_pham" name="danh_muc_san_pham" required>';
                while ($rowDanhMucSanPham = $resultDanhMucSanPham->fetch_assoc()) {
                    $selected = ($rowDanhMucSanPham['ma_danh_muc'] == $row->danh_muc_san_pham) ? 'selected' : '';
                    echo "<option value='{$rowDanhMucSanPham['ma_danh_muc']}' $selected>{$rowDanhMucSanPham['ten_danh_muc']}</option>";
                }
                echo '</select>';
            } else {
                echo 'Không có danh mục sản phẩm nào trong cơ sở dữ liệu.';
            }
        ?>
    </div>
    <div class="mb-3">
        <label for="don_vi_tinh">Đon vị tính</label>
        <?php 
        $sqlDonViTinh = "SELECT ma_don_vi_tinh, ten_don_vi_tinh FROM don_vi_tinh";
            $resultDonViTinh = $conn->query($sqlDonViTinh);
            if ($resultDonViTinh->num_rows > 0) {
                echo '<select class="form-control" id="don_vi_tinh" name="don_vi_tinh" required>';
                while ($rowDonViTinh = $resultDonViTinh->fetch_assoc()) {
                    $selected = ($rowDonViTinh['ma_don_vi_tinh'] == $row->ma_don_vi_tinh) ? 'selected' : '';
                    echo "<option value='{$rowDonViTinh['ma_don_vi_tinh']}' $selected>{$rowDonViTinh['ten_don_vi_tinh']}</option>";
                }
                echo '</select>';
            } else {
                echo 'Không có đơn vị tính nào trong cơ sở dữ liệu.';
            }
        ?>
    </div>
    <div class="mb-3">
        <label for="mo_ta_san_pham">Mô tả sản phẩm:</label>
        <div id="editor">

        </div>
        <input type="hidden" id="mo_ta_san_pham_hidden" name="mo_ta_san_pham_hidden">
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary" name="themSanPham">Thêm sản phẩm</button>
    </div>
</form>

<script>
var options = {
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['link', 'image', 'video'],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            ['blockquote', 'code-block'],
            [{
                'align': []
            }],
            ['clean']
        ]
    },
    placeholder: 'Nhập mô tả sản phẩm...',
    theme: 'snow'
};

var quill = new Quill('#editor', options);
document.querySelector('form').addEventListener('submit', function() {
    var mo_ta_san_pham_hidden = document.getElementById('mo_ta_san_pham_hidden');
    mo_ta_san_pham_hidden.value = quill.root.innerHTML;
});
</script>