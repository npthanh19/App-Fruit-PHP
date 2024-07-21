<?php
require '../classes/NhaCungCap.php';
require '../classes/PhieuNhapHang.php';
require("../classes/SanPham.php");
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();
?>
<?php
$obj = new PhieuNhapHang();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_phieu_nhap = $_GET['id'];
    $phieuNhapData = $obj->layPhieuNhapHangTheoId($conn, $id_phieu_nhap);
}
$tongTien = 0;
foreach ($phieuNhapData["orderDetails"] as $item) {
    $soLuong = $item['so_luong'];
    $giaNhap = $item['gia_nhap'];
    $thanhTien = $soLuong * $giaNhap;
    $tongTien += $thanhTien;
}
?>
<form action="handle/sua_phieu_nhap_hang.php" method="POST">
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="id_phieu_nhap" value="<?php echo $phieuNhapData['id_phieu_nhap']; ?>">
            <div class="mb-3">
                <label for="ngay_nhap" class="form-label">Ngày Nhập</label>
                <input type="date" class="form-control" id="ngay_nhap" name="ngay_nhap" required
                    value="<?php echo $phieuNhapData["ngay_nhap"] ?>">
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
                    value='<?php echo $phieuNhapData['nguoi_tao'] ?>' required>
            </div>
            <div class="mb-3">
                <label for="ghi_chu" class="form-label">Ghi Chú</label>
                <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="4"
                    required><?php echo $phieuNhapData["ghi_chu"]; ?></textarea>
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
            <?php
            foreach ($phieuNhapData["orderDetails"] as $index => $item) {
                $tenSanPham = $item['ten_san_pham'];
                $soLuong = $item['so_luong'];
                $giaNhap = $item['gia_nhap'];
                $thanhTien = $soLuong * $giaNhap;
                $maSanPham = $item['ma_san_pham'];
            ?>
            <tr>
                <td><?php echo $tenSanPham; ?></td>
                <td><?php echo $soLuong; ?></td>
                <td><?php echo $giaNhap; ?></td>
                <td><?php echo $thanhTien; ?></td>
                <td><button class="btn btn-danger btn-sm nut-xoa" onclick="xoaSanPham(<?php echo $index; ?>)"
                        data-ma-san-pham="<?php echo $maSanPham; ?>">Xóa</button></td>
                <input type="hidden" name="ma_san_pham[]" value="<?php echo $maSanPham; ?>">
                <input type="hidden" name="so_luong[]" value="<?php echo $soLuong; ?>">
                <input type="hidden" name="ten_san_pham[]" value="<?php echo $tenSanPham; ?>">
                <input type="hidden" name="gia_nhap[]" value="<?php echo $giaNhap; ?>">
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <div class="mb-3">
        <label for="tong_tien" class="form-label">Tổng Tiền</label>
        <input type="text" class="form-control" id="tong_tien" disabled value="<?php echo $tongTien; ?>">
    </div>
    <button type="btn" id="luuButton" name="suaPhieuNhap" class="btn btn-primary">Lưu</button>
</form>

<script>
let danhSachSanPham = [];

document.querySelectorAll("#danh_sach_san_pham tr").forEach(function(row) {
    let cells = row.querySelectorAll("td");
    let tenSanPham = cells[0].textContent;
    let soLuong = parseInt(cells[1].textContent);
    let giaNhap = parseFloat(cells[2].textContent);
    let thanhTien = parseFloat(cells[3].textContent);
    let maSanPham = parseInt(row.querySelector(".nut-xoa").getAttribute("data-ma-san-pham"));

    danhSachSanPham.push({
        tenSanPham: tenSanPham,
        soLuong: soLuong,
        giaNhap: giaNhap,
        thanhTien: thanhTien,
        maSanPham: maSanPham
    });
});



document.getElementById("them_san_pham").addEventListener("click", function() {
    let sanPham = document.getElementById("chon_san_pham").value;
    let soLuong = parseInt(document.getElementById("so_luong").value);
    let giaNhap = parseFloat(document.getElementById("gia_nhap").value);

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
    for (let i = index; i < danhSachSanPham.length; i++) {
        danhSachSanPham[i].index = i;
    }
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
            <td><button class="btn btn-danger btn-sm nut-xoa" data-ma-san-pham="<?php echo $maSanPham; ?>" onclick="xoaSanPham(${danhSachSanPham[i].index})">Xóa</button></td>
        `;

        tbody.appendChild(row);

        let hiddenMaSanPhamInput = document.createElement("input");
        hiddenMaSanPhamInput.type = "hidden";
        hiddenMaSanPhamInput.name = "ma_san_pham[]";
        hiddenMaSanPhamInput.value = <?php echo $maSanPham; ?>;
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