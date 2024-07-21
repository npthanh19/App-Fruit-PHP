<?php include("../config/database.php") ?>
<?php include("../classes/DonHang.php") ?>

<?php
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cap_nhat'])) {
        $ma_don_hang = $_POST['ma_don_hang'];
        $trang_thai = $_POST['trang_thai'];

        $donhang_obj = new DonHang();
        $donhang_obj->capNhatTrangThai($conn, $trang_thai, $ma_don_hang);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Cập nhật trạng thái đơn hàng " . $ma_don_hang);
        header("Location: ./index.php?p=donhang");
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_don_hang']) && isset($_POST['trang_thai'])) {
    $trang_thai = $_POST['trang_thai'];
    $selected_don_hang = json_decode($_POST['selected_don_hang']);
    $donhang_obj = new DonHang();
    foreach ($selected_don_hang as $ma_don_hang) {
        $donhang_obj->capNhatTrangThai($conn, $trang_thai, $ma_don_hang);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Cập nhật trạng thái đơn hàng " . $ma_don_hang);
    }
    echo 'Cập nhật thành công';
}
?>

<div class="head-page">
    <form method="post" class="form-inline d-flex justify-content-end">
        <div class="form-group">
            <label for="so_trang_hien_thi">Chọn số trang:</label>
            <select name="so_trang_hien_thi" id="so_trang_hien_thi" class="form-control mr-2">
                <option value="10"
                    <?php echo (isset($_POST['so_trang_hien_thi']) && $_POST['so_trang_hien_thi'] == '10') ? 'selected' : ''; ?>>
                    10</option>
                <option value="50"
                    <?php echo (isset($_POST['so_trang_hien_thi']) && $_POST['so_trang_hien_thi'] == '50') ? 'selected' : ''; ?>>
                    50</option>
                <option value="100"
                    <?php echo (isset($_POST['so_trang_hien_thi']) && $_POST['so_trang_hien_thi'] == '100') ? 'selected' : ''; ?>>
                    100</option>
                <option value="200"
                    <?php echo (isset($_POST['so_trang_hien_thi']) && $_POST['so_trang_hien_thi'] == '200') ? 'selected' : ''; ?>>
                    200</option>
                <option value="500"
                    <?php echo (isset($_POST['so_trang_hien_thi']) && $_POST['so_trang_hien_thi'] == '500') ? 'selected' : ''; ?>>
                    500</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-sort"></i></button>
    </form>


    <form method='post' class="d-flex">
        <select name='trang_thai' class='form-select'>
            <option value='Chờ xác nhận'>Chờ xác nhận</option>
            <option value='Đã xác nhận'>Đã xác nhận</option>
            <option value='Đang giao hàng'>Đang giao hàng</option>
            <option value='Đã thanh toán'>Đã thanh toán</option>
            <option value='Thành công'>Thành công</option>
        </select>
        <button type='button' class='btn btn-primary' id='cap_nhat_hang_loat_btn'>Cập nhật hàng loạt</button>
    </form>

    <div class="d-flex justify-content-end" style="margin-left: auto">
        <form method="post" class="form-inline d-flex justify-content-end">
            <div class="form-group">
                <label for="phuong_thuc_thanh_toan">Phương thức thanh toán:</label>
                <select name="phuong_thuc_thanh_toan" id="phuong_thuc_thanh_toan" class="form-control mr-2">
                    <option value="">Tất cả</option>
                    <option value="Tiền mặt">Tiền mặt</option>
                    <option value="Chuyển khoản ATM">Chuyển khoản ATM</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trang_thai">Trạng thái:</label>
                <select name="trang_thai" id="trang_thai" class="form-control mr-2">
                    <option value="">Tất cả</option>
                    <option value="Chờ xác nhận">Chờ xác nhận</option>
                    <option value="Đã xác nhận">Đã xác nhận</option>
                    <option value="Đang giao hàng">Đang giao hàng</option>
                    <option value="Đã thanh toán">Đã thanh toán</option>
                    <option value="Thành công">Thành công</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ngay_loc">Ngày đặt hàng:</label>
                <input type="date" name="ngay_loc" id="ngay_loc" class="form-control mr-2">
            </div>
            <button type="submit" class="btn btn-primary" name='loc'><i class="fa-solid fa-filter"></i></button>
        </form>
    </div>
    <button class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#themLoaiSanPhamModal"><i
            class="fa-solid fa-download"></i></button>

</div>
<table id="myTable" class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center bg-primary text-light"></th>
            <th scope="col" class="text-center bg-primary text-light">Mã đơn hàng</th>
            <th scope="col" class="text-center bg-primary text-light">Tên khách hàng</th>
            <th scope="col" class="text-center bg-primary text-light">Địa chỉ</th>
            <th scope="col" class="text-center bg-primary text-light">Số điện thoại</th>
            <th scope="col" class="text-center bg-primary text-light">Ngày đặt hàng</th>
            <th scope="col" class="text-center bg-primary text-light">Phương thức thanh toán</th>
            <th scope="col" colspan="2" class="text-center bg-primary text-light">Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php
        function getTotalPages($totalRows, $pageSize)
        {
            return ceil($totalRows / $pageSize);
        }
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_POST['so_trang_hien_thi']) ? intval($_POST['so_trang_hien_thi']) : 10; 
        $donhang_obj = new DonHang();
        $don_hang = $donhang_obj->xemTatCaDonHangPhanTrang($conn, $page, $pageSize);
        $tat_ca_don_hang = $donhang_obj->xemTatCaDonHang($conn);

        $totalRows = count($tat_ca_don_hang);
        $totalPages = getTotalPages($totalRows, $pageSize);


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loc'])) {
            if (isset($_POST['loc'])) {
                $trang_thai_filter = $_POST['trang_thai'];
                $ngay_loc = $_POST['ngay_loc'];
                $phuong_thuc_thanh_toan_filter = $_POST['phuong_thuc_thanh_toan'];

                $don_hang = $donhang_obj->xemDonHangTheoDieuKien($conn, $ngay_loc, $trang_thai_filter, $phuong_thuc_thanh_toan_filter);
            } else {
                $don_hang = $donhang_obj->xemTatCaDonHangPhanTrang($conn, $page, $pageSize);
            }
        }

        foreach ($don_hang as $row) {
            echo "<tr>";
            echo "<td class='text-center'><input type='checkbox' name='selected_don_hang[]' value='" . $row['ma_don_hang'] . "'></td>";
            echo "<td class='text-center'>" . $row['ma_don_hang'] . "</td>";
            echo "<td class='text-center'>" . $row['ten_khach_hang'] . "</td>";
            echo "<td class='text-center'>" . $row['dia_chi'] . "</td>";
            echo "<td class='text-center'>" . $row['so_dien_thoai'] . "</td>";
            echo "<td class='text-center'>" . $row['ngay_dat_hang'] . "</td>";
            echo "<td class='text-center'>" . $row['phuong_thuc_thanh_toan'] . "</td>";
            echo "<td class='text-center'>";
            echo "<form method='post' class='d-flex justify-content-between'>";
            echo "<input type='hidden' name='ma_don_hang' value='" . $row['ma_don_hang'] . "'>";
            echo "<select name='trang_thai' class='form-select'>";
            echo "<option value='Chờ xác nhận' " . ($row['trang_thai'] == 'Chờ xác nhận' ? 'selected' : '') . ">Chờ xác nhận</option>";
            echo "<option value='Đã xác nhận' " . ($row['trang_thai'] == 'Đã xác nhận' ? 'selected' : '') . ">Đã xác nhận</option>";
            echo "<option value='Đang giao hàng' " . ($row['trang_thai'] == 'Đang giao hàng' ? 'selected' : '') . ">Đang giao hàng</option>";
            echo "<option value='Đã thanh toán' " . ($row['trang_thai'] == 'Đã thanh toán' ? 'selected' : '') . ">Đã thanh toán</option>";
            echo "<option value='Thành công' " . ($row['trang_thai'] == 'Thành công' ? 'selected' : '') . ">Thành công</option>";
            echo "</select>";
            echo "<button type='submit' class='btn btn-primary' name='cap_nhat'>Cập nhật</button>";
            echo "</form>";
            echo "</td>";
            echo "<td class='text-center'><a href='index.php?p=chitietdonhangonline&id=" . $row['ma_don_hang'] . "'><button class='btn btn-primary'><i class='fa-solid fa-print'></i></button></a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<div class="text-center">
    <ul class="pagination justify-content-end">
        <?php if ($page > 1) : ?>
        <li class="page-item"><a class="page-link" href="./index.php?p=donhang&page=<?php echo ($page - 1); ?>">Trang
                trước</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link"
                href="./index.php?p=donhang&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>

        <?php if ($page < $totalPages) : ?>
        <li class="page-item"><a class="page-link" href="./index.php?p=donhang&page=<?php echo ($page + 1); ?>">Trang
                sau</a></li>
        <?php endif; ?>
    </ul>
</div>


<div class="modal fade" id="themLoaiSanPhamModal" tabindex="-1" aria-labelledby="themLoaiSanPhamModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tùy chọn xuất</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Thêm các tùy chọn lựa chọn ở đây -->
                <form id="exportForm" action="./handle/export.php" method="POST">
                    <div class="mb-3">
                        <label for="fromDate" class="form-label">Từ ngày:</label>
                        <input type="date" class="form-control" id="fromDate" name="fromDate">
                    </div>
                    <div class="mb-3">
                        <label for="toDate" class="form-label">Đến ngày:</label>
                        <input type="date" class="form-control" id="toDate" name="toDate">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái đơn:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Tất cả</option>
                            <option value="Chờ xác nhận">Chờ xác nhận</option>
                            <option value="Đã xác nhận">Đã xác nhận</option>
                            <option value="Đang giao hàng">Đang giao hàng</option>
                            <option value="Đã thanh toán">Đã thanh toán</option>
                            <option value="Thành công">Thành công</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Phương thức thanh toán:</label>
                        <select class="form-control" id="paymentMethod" name="paymentMethod">
                            <option value="">Tất cả</option>
                            <option value="Tiền mặt">Tiền mặt</option>
                            <option value="Chuyển khoản ATM">Chuyển khoản ATM</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary submit-order">Xuất</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.getElementById('cap_nhat_hang_loat_btn').addEventListener('click', function() {
    var trang_thai = document.querySelector('select[name="trang_thai"]').value;
    var checkboxes = document.querySelectorAll('input[name="selected_don_hang[]"]');
    var selected_don_hang = [];
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            selected_don_hang.push(checkbox.value);
        }
    });

    if (selected_don_hang.length > 0) {
        var xhr = new XMLHttpRequest();

        xhr.open('POST', './index.php?p=donhang', true);

        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                window.location.reload();
            }
        };

        var data = 'trang_thai=' + encodeURIComponent(trang_thai) + '&selected_don_hang=' + encodeURIComponent(
            JSON.stringify(selected_don_hang));

        xhr.send(data);
    } else {
        alert('Vui lòng chọn ít nhất một đơn hàng để cập nhật.');
    }
});
</script>