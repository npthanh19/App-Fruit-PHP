<?php
include("../config/database.php");
include("../classes/BaoCao.php");
include("../classes/LichSuHoatDong.php");
$objBaoCao = new BaoCao();
?>

<div class="head-page mb-3">
    <form method="post" action="">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="search_query">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <input type="hidden" name="search">
    </form>
</div>

<div class="card bg-light mb-3" style="max-width: 100%;">
    <div class="card-header">Hoạt động trong ngày</div>
    <div class="card-body">
        <ul class="list-group">
            <?php
            $lichSuHoatDongObj = new LichSuHoatDong();


            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
 
                $searchQuery = $_POST["search_query"];

                $lichSuHoatDongArr = $lichSuHoatDongObj->timKiemLichSuHoatDong($conn, null, $searchQuery, null);
            } else {

                $lichSuHoatDongArr = $lichSuHoatDongObj->lietKeLichSuHoatDong($conn);
            }

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