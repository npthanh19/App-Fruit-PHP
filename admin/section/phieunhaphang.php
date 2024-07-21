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
require '../classes/PhieuNhapHang.php';
require("../classes/SanPham.php");
require '../classes/NhaCungCap.php';
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$nguoi_tao = "";
$id_nguoi_tao = "";

if (isset($_SESSION['username'])) {
    $nguoi_tao = $_SESSION['username'];
    $id = $_SESSION['id_tai_khoan'];
}

$phieuNhapObj = new PhieuNhapHang();

if (isset($_POST['themPhieuNhap'])) {
    if ($_SESSION['id_tai_khoan'] !== "1684481330") {
        if (!$objChiTietVaiTro->kiemTraQuyenTruyCap($conn, $_SESSION['id_tai_khoan'], 'them_phieu_nhap_hang')) {
            header('Location: ./index.php?p=phieunhaphang&quyen=null');
            exit();
        }
    }
    
    $ngay_nhap = $_POST['ngay_nhap'];
    $nguoi_tao = $_POST['nguoi_tao'];
    $ghi_chu = $_POST['ghi_chu'];
    $nha_cung_cap = $_POST['nha_cung_cap'];

    $orderDetails = [];
    if (isset($_POST['ma_san_pham']) && isset($_POST['so_luong']) && isset($_POST['gia_nhap'])) {
        $ma_san_pham = $_POST['ma_san_pham'];
        $so_luong_nhap = $_POST['so_luong'];
        $gia_nhap = $_POST['gia_nhap'];

        foreach ($ma_san_pham as $key => $ma) {
            $orderDetails[] = [
                'ma_san_pham' => $ma,
                'so_luong_nhap' => $so_luong_nhap[$key],
                'gia_nhap' => $gia_nhap[$key]
            ];
        }
    }

    $phieu_nhap = array(
        "ngay_nhap" => $ngay_nhap,
        "nguoi_tao" => $nguoi_tao,
        "ghi_chu" => $ghi_chu,
        "nha_cung_cap" => $nha_cung_cap,
        "orderDetails" => $orderDetails
    );

    try {
        $phieuNhapObj->themPhieuNhapHang($conn, $phieu_nhap);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Thêm phiếu nhập hàng ");

        header('Location: ' . $_SERVER['HTTP_REFERER']);
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
    echo 'Không được phép xóa phiếu nhập kho do đã được sử dụng trong dữ liệu khác.';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

if (isset($_GET['delete_success']) && $_GET['delete_success'] === 'true') {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo 'Đã xóa phiếu nhập kho thành công.';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>
<div class="head-page">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#themPhieuNhapModal">Thêm phiếu
        nhập</button>
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
            <th scope="col" class="text-center bg-primary text-light">ID Phiếu Nhập</th>
            <th scope="col" class="text-center bg-primary text-light">Nhà cung cấp</th>
            <th scope="col" class="text-center bg-primary text-light">Ngày Nhập</th>
            <th scope="col" class="text-center bg-primary text-light">Người tạo</th>
            <th scope="col" colspan="3" class="text-center bg-primary text-light">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $phieuNhapObj->layPhieuNhapHang($conn);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["search"])) {
            $searchQuery = $_POST['search_query'];
            $data = $phieuNhapObj->timPhieuNhapHang($conn, $searchQuery);
        }

        foreach ($data as $row) {
            echo '<tr>';
            echo '<td class="text-center">' . $row['id_phieu_nhap'] . '</td>';
            echo '<td class="text-center">' . $row['ten_nha_cung_cap'] . '</td>';
            echo '<td class="text-center">' . $row['ngay_nhap'] . '</td>';
            echo '<td class="text-center">' . $row['nguoi_tao'] . '</td>';
            echo '<td class="text-center edit"><a href="./index.php?p=suaphieunhaphang&id='. $row['id_phieu_nhap'] . '">Sửa</a></td>';
            echo '<td class="text-center remove"><a href="handle/xoa_phieu_nhap.php?id_phieu_nhap=' . $row['id_phieu_nhap'] . '">Xóa</a></td>';
            echo '<td class="text-center remove"><a href="./index.php?p=chitietphieunhaphang&id='. $row['id_phieu_nhap'] . '">Xem chi tiết</a></td>';
            echo '</tr>';
        }

        ?>
    </tbody>
</table>

<div class="modal fade" id="themPhieuNhapModal" tabindex="-1" aria-labelledby="themPhieuNhapModalLabel"
    aria-hidden="true">
    <form method="post">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themPhieuNhapModalLabel">Thông Tin Phiếu Nhập Hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ngay_nhap" class="form-label">Ngày Nhập</label>
                                <input type="date" class="form-control" id="ngay_nhap" name="ngay_nhap" required>
                            </div>
                            <div class="mb-3">
                                <label for="nha_cung_cap" class="form-label">Chọn Nhà Cung Cấp</label>
                                <select class="form-control" id="nha_cung_cap" name="nha_cung_cap">
                                    <?php
                                    $nhaCungCapObj = new NhaCungCap();
                                    $nhaCungCapArr = $nhaCungCapObj->layDanhSachNhaCungCap($conn);
                                    foreach ($nhaCungCapArr as $nhaCungCap) {
                                        echo '<option value="' . $nhaCungCap['ma_nha_cung_cap'] . '">' . $nhaCungCap['ten_nha_cung_cap'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" class="form-control" id="nguoi_tao" name="nguoi_tao"
                                    value='<?php echo $id ?>' required>
                            </div>
                            <div class="mb-3">
                                <label for="ghi_chu" class="form-label">Ghi Chú</label>
                                <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="chon_san_pham" class="form-label">Chọn Sản Phẩm</label>
                                <select class="form-control" id="chon_san_pham">
                                    <?php
                                    $sanPhamObj = new SanPham();
                                    $sanPhamArr = $sanPhamObj->layTatCaSanPham($conn);
                                    foreach ($sanPhamArr as $sanPham) {
                                        echo '<option value="' . $sanPham->ma_san_pham . '" data-gia-nhap="' . $sanPham->gia_nhap . '">' . $sanPham->ten_san_pham . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="so_luong" class="form-label">Số Lượng</label>
                                <input type="number" class="form-control" id="so_luong" placeholder="Nhập số lượng">
                            </div>
                            <div class="mb-3">
                                <label for="gia_nhap" class="form-label">Giá nhập</label>
                                <input type="number" class="form-control" id="gia_nhap" placeholder="Giá nhập">
                            </div>
                            <button type="button" class="btn btn-primary" id="them_san_pham">Thêm Sản Phẩm</button>
                        </div>
                    </div>
                    <table class="table table-modal table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Sản Phẩm</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col">Giá Nhập</th>
                                <th scope="col">Thành Tiền</th>
                                <th scope="col">Xóa</th>
                            </tr>
                        </thead>
                        <tbody id="danh_sach_san_pham">

                        </tbody>
                    </table>
                    <div class="mb-3">
                        <label for="tong_tien" class="form-label">Tổng Tiền</label>
                        <input type="text" class="form-control" id="tong_tien" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary submit-order" id="luu_don_hang"
                        name="themPhieuNhap">Lưu Đơn Hàng</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let danhSachSanPham = [];

document.getElementById("them_san_pham").addEventListener("click", function() {
    let sanPham = document.getElementById("chon_san_pham").value;
    let soLuong = parseInt(document.getElementById("so_luong").value);
    let giaNhap = parseFloat(document.getElementById("gia_nhap").value);

    console.log(giaNhap)

    let tonTai = false;
    for (let i = 0; i < danhSachSanPham.length; i++) {
        if (danhSachSanPham[i].sanPham === sanPham) {
            danhSachSanPham[i].soLuong += soLuong;
            tonTai = true;
            break;
        }
    }

    if (!tonTai) {
        let tenSanPham = document.getElementById("chon_san_pham").options[document.getElementById(
            "chon_san_pham").selectedIndex].text;

        danhSachSanPham.push({
            sanPham: sanPham,
            tenSanPham: tenSanPham,
            giaNhap: giaNhap,
            soLuong: soLuong
        });
    }

    capNhatBangSanPhamVaTongTien();
});

function xoaSanPham(index) {
    danhSachSanPham.splice(index, 1);
    capNhatBangSanPhamVaTongTien();
}

function capNhatBangSanPhamVaTongTien() {
    let tbody = document.getElementById("danh_sach_san_pham");
    let tongTien = 0;

    tbody.innerHTML = "";

    for (let i = 0; i < danhSachSanPham.length; i++) {
        let maSanPham = danhSachSanPham[i].sanPham;
        let soLuong = danhSachSanPham[i].soLuong;
        let tenSanPham = danhSachSanPham[i].tenSanPham;
        let giaNhap = danhSachSanPham[i].giaNhap;


        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${tenSanPham}</td>
            <td>${soLuong}</td>
            <td>${giaNhap}</td>
            <td>${giaNhap * soLuong}</td>
            <td><button class="btn btn-danger btn-sm nut-xoa" onclick="xoaSanPham(${i})">Xóa</button></td>
        `;

        tbody.appendChild(row);

        let hiddenMaSanPhamInput = document.createElement("input");
        hiddenMaSanPhamInput.type = "hidden";
        hiddenMaSanPhamInput.name = "ma_san_pham[]";
        hiddenMaSanPhamInput.value = maSanPham;
        tbody.appendChild(hiddenMaSanPhamInput);

        let hiddenSoLuongInput = document.createElement("input");
        hiddenSoLuongInput.type = "hidden";
        hiddenSoLuongInput.name = "so_luong[]";
        hiddenSoLuongInput.value = soLuong;
        tbody.appendChild(hiddenSoLuongInput);

        let hiddenTenSanPhamInput = document.createElement("input");
        hiddenTenSanPhamInput.type = "hidden";
        hiddenTenSanPhamInput.name = "ten_san_pham[]";
        hiddenTenSanPhamInput.value = tenSanPham;
        tbody.appendChild(hiddenTenSanPhamInput);

        let hiddenGiaNhapInput = document.createElement("input");
        hiddenGiaNhapInput.type = "hidden";
        hiddenGiaNhapInput.name = "gia_nhap[]";
        hiddenGiaNhapInput.value = giaNhap;
        tbody.appendChild(hiddenGiaNhapInput);

        tongTien += giaNhap * soLuong;
    }

    document.getElementById("tong_tien").value = tongTien;
}
</script>