<?php include("../config/database.php") ?>
<?php include("../classes/DonHangTaiQuay.php") ?>
<?php
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_don_hang = $_POST['ma_don_hang'];
    $trang_thai = $_POST['trang_thai'];

    $donhang_obj = new DonHangTaiQuay();
    $donhang_obj->capNhatTrangThai($conn, $trang_thai, $ma_don_hang);
    $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Cập nhật trạng thái đơn hàng " . $ma_don_hang);
}
?>
<div class="head-page">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#themSanPhamModal">Tạo đơn hàng</button>
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
            <th scope="col" class="text-center bg-primary text-light">Mã đơn hàng</th>
            <th scope="col" class="text-center bg-primary text-light">Nhân viên lên đơn</th>
            <th scope="col" class="text-center bg-primary text-light">Số điện thoại</th>
            <th scope="col" class="text-center bg-primary text-light">Ngày đặt hàng</th>
            <th scope="col" class="text-center bg-primary text-light">Tổng tiền</th>
            <th scope="col" class="text-center bg-primary text-light">Xem chi tiết</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $donhang_obj = new DonHangTaiQuay();
        $don_hang = $donhang_obj->xemTatCaDonHang($conn);

        foreach ($don_hang as $row) {
            echo "<tr>";
            echo "<td class='text-center'>" . $row['ma_don_hang'] . "</td>";
            echo "<td class='text-center'>" . $row['ten_khach_hang'] . "</td>";
            echo "<td class='text-center'>" . $row['so_dien_thoai'] . "</td>";
            echo "<td class='text-center'>" . $row['ngay_dat_hang'] . "</td>";
            echo "<td class='text-center'>" . number_format($row['tong_gia'], 2) . "</td>";
            echo '<td class="text-center remove"><a href="index.php?p=chitietdonhangtaiquay&id=' . $row['ma_don_hang'] . '">Xem chi tiết</a></td>';
            echo "</tr>";
        }
        ?>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="themSanPhamModal" tabindex="-1" aria-labelledby="themSanPhamModalLabel" aria-hidden="true">
    <form method="post" action="handle/dat_hang_tai_quay.php">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông Tin Đơn Hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ten_khach_hang" class="form-label">Tên Khách Hàng</label>
                                <input type="text" class="form-control" id="ten_khach_hang" name="ten_khach_hang"
                                    placeholder="Nhập tên khách hàng">
                            </div>
                            <div class="mb-3">
                                <label for="so_dien_thoai" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                                    placeholder="Nhập số điện thoại">
                            </div>
                            <table class="table table-modal table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Sản Phẩm</th>
                                        <th scope="col">Số Lượng</th>
                                        <th scope="col">Thành Tiền</th>
                                        <th scope="col">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="mb-3">
                                <label for="tong_tien" class="form-label">Tổng Tiền</label>
                                <input type="text" class="form-control" id="tong_tien" disabled>
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
                                    echo '<option value="' . $sanPham->ma_san_pham . '" data-gia="' . $sanPham->gia_ban . '">' . $sanPham->ten_san_pham . '</option>';
                                }
                                ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="so_luong" class="form-label">Số Lượng</label>
                                <input type="number" class="form-control" id="so_luong" placeholder="Nhập số lượng">
                            </div>
                            <button type="button" class="btn btn-primary" id="them_san_pham">Thêm Sản Phẩm</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary submit-order">Lưu Đơn Hàng</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let danhSachSanPham = [];

document.getElementById("them_san_pham").addEventListener("click", function() {
    let sanPham = document.getElementById("chon_san_pham").value;
    let soLuong = parseFloat(document.getElementById("so_luong").value); // Parse the quantity as a float.

    if (isNaN(soLuong) || soLuong <= 0) {
        // Handle invalid quantity (not a number or less than or equal to 0).
        alert("Please enter a valid quantity.");
        return;
    }

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
        let giaSanPham = parseFloat(document.getElementById("chon_san_pham").options[document.getElementById(
            "chon_san_pham").selectedIndex].getAttribute('data-gia'));

        if (isNaN(giaSanPham) || giaSanPham <= 0) {
            // Handle invalid price (not a number or less than or equal to 0).
            alert("Invalid product price. Please check the product data.");
            return;
        }

        danhSachSanPham.push({
            sanPham: sanPham,
            tenSanPham: tenSanPham,
            giaSanPham: giaSanPham,
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
    let tbody = document.querySelector(".table-modal tbody");
    let tongTien = 0;

    tbody.innerHTML = "";

    for (let i = 0; i < danhSachSanPham.length; i++) {
        let maSanPham = danhSachSanPham[i].sanPham;
        let soLuong = danhSachSanPham[i].soLuong;
        let tenSanPham = danhSachSanPham[i].tenSanPham;
        let giaSanPham = danhSachSanPham[i].giaSanPham;

        let option = document.querySelector('#chon_san_pham option[value="' + maSanPham + '"]');

        if (option) {
            let gia = parseFloat(option.getAttribute('data-gia'));
            let thanhTien = gia * soLuong;
            thanhTien = parseFloat(thanhTien.toFixed(2));

            let row = document.createElement("tr");
            row.innerHTML = `
                <td>${option.textContent}</td>
                <td>${soLuong}</td>
                <td>${thanhTien}</td>
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

            let hiddenGiaSanPhamInput = document.createElement("input");
            hiddenGiaSanPhamInput.type = "hidden";
            hiddenGiaSanPhamInput.name = "gia_san_pham[]";
            hiddenGiaSanPhamInput.value = giaSanPham;
            tbody.appendChild(hiddenGiaSanPhamInput);

            tongTien += thanhTien;
        }
    }

    document.getElementById("tong_tien").value = tongTien;
}
</script>