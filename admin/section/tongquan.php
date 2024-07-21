<?php
include("../config/database.php");
include("../classes/BaoCao.php");
include("../classes/LichSuHoatDong.php");
$objBaoCao = new BaoCao();
?>

<div class="alert alert-dark">Báo cáo ngày <?php echo date("d/m/Y"); ?></div>

<div class="row">
    <div class="col-3">
        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">Doanh thu</div>
            <div class="card-body d-flex align-items-center">
                <i class="fa-solid fa-coins"></i>
                <span class="card-title">
                    <?php
                    $value = $objBaoCao->tinhTongGiaDonHang($conn);

                    if ($value !== null) {
                        $price = number_format($value, 0, ',', '.') . '.000 VND';
                        echo $price;
                    } else {
                        echo "Không có giá trị tổng giá đơn hàng.";
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-secondary mb-3" style="max-width: 100%;">
            <div class="card-header">Lợi nhuận</div>
            <div class="card-body d-flex align-items-center">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <span class="card-title">
                    <?php
                    $value = $objBaoCao->tinhDoanhThuDonHang($conn);

                    if ($value !== null) {
                        $price = number_format($value, 0, ',', '.') . '.000 VND';
                        echo $price;
                    } else {
                        echo "Không có giá trị tổng giá đơn hàng.";
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-success mb-3" style="max-width: 100%;">
            <div class="card-header">Đơn hàng</div>
            <div class="card-body d-flex align-items-center">
                <i class="fa-solid fa-truck-fast"></i>
                <span class="card-title">
                    <?php
                    $value = $objBaoCao->demSoLuongDonDatHang($conn);

                    if ($value !== null) {
                        echo $value;
                    } else {
                        echo "Không có giá trị tổng giá đơn hàng.";
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-danger mb-3" style="max-width: 100%;">
            <div class="card-header">Khách hàng mới</div>
            <div class="card-body d-flex align-items-center">
                <i class="fa-solid fa-user-group"></i>
                <span class="card-title">
                    <?php
                    $value = $objBaoCao->demSoLuongKhachHang($conn);

                    if ($value !== null) {
                        echo $value;
                    } else {
                        echo "Không có giá trị tổng giá đơn hàng.";
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>

</div>

<!-- <div class="row">
    <div class="col-6">
        <div class="card bg-light mb-3" style="max-width: 100%;">
            <div class="card-header">Số lượng khách hàng truy cập</div>
            <div class="card-body">
                <h5 class="card-title">20</h5>
                <p class="card-text">Nhiều nhất vào khung giờ 12h.</p>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card bg-light mb-3" style="max-width: 100%;">
            <div class="card-header">Số lượng khách hàng bỏ sản phẩm vào giỏ</div>
            <div class="card-body">
                <h5 class="card-title">34</h5>
                <p class="card-text">Top 3 sản phẩm được bỏ vào giỏ nhiều nhất là Vải, Quít, Nho.</p>
            </div>
        </div>
    </div>
</div> -->
<div class="card bg-light mb-3" style="max-width: 100%;">
    <div class="card-header">Hoạt động hôm nay</div>
    <div class="card-body">
        <ul class="list-group">
            <?php
            $lichSuHoatDongObj = new LichSuHoatDong();
            // Gọi hàm lietKeLichSuHoatDong để lấy danh sách lịch sử hoạt động
            $lichSuHoatDongArr = $lichSuHoatDongObj->lietKeLichSuHoatDong($conn);

            // Lấy 5 phần tử cuối cùng từ mảng lịch sử hoạt động
            $lichSuHoatDongArr = array_slice($lichSuHoatDongArr, -5);

            // Hiển thị thông tin lịch sử hoạt động
            foreach ($lichSuHoatDongArr as $lichSuHoatDong) {
                $tenTaiKhoan = $lichSuHoatDong['ten_tai_khoan'];
                $hanhDong = $lichSuHoatDong['hanh_dong'];
                $thoiGian = $lichSuHoatDong['thoi_gian'];
            ?>
            <li class="list-group-item"><?php echo $thoiGian . ' - ' . $tenTaiKhoan . ' vừa ' . $hanhDong; ?></li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>