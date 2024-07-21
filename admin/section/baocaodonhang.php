<?php
include("../config/database.php");
include("../classes/BaoCao.php");
$objBaoCao = new BaoCao();
// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST["start-date"];
    $endDate = $_POST["end-date"];

    $demSoLuongDonDatHang = $objBaoCao->demSoLuongDonDatHang($conn, $startDate, $endDate);
    $tinhPhanTramDonHangThanhCong = $objBaoCao->tinhPhanTramDonHangThanhCong($conn, $startDate, $endDate);
} else {

    $demSoLuongDonDatHang = $objBaoCao->demSoLuongDonDatHang($conn);
    $tinhPhanTramDonHangThanhCong = $objBaoCao->tinhPhanTramDonHangThanhCong($conn);
}
?>

<div class="row">
    <form method="post" class="d-flex gap-10">
        <div class="form-group">
            <label for="start-date">Từ ngày:</label>
            <input type="date" class="form-control" id="start-date" name="start-date"
                value="<?php echo isset($startDate) ? $startDate : ''; ?>">
        </div>
        <div class="form-group mx-2">
            <label for="end-date">Đến ngày:</label>
            <input type="date" class="form-control" id="end-date" name="end-date"
                value="<?php echo isset($endDate) ? $endDate : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Lọc</button>
    </form>
    <div class="col-6">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-6">
        <div class="card bg-success mb-3" style="max-width: 100%;">
            <div class="card-header">Đơn hàng</div>
            <div class="card-body d-flex align-items-center">
                <i class="fa-solid fa-truck-fast"></i>
                <span class="card-title">
                    <?php
                    if ($demSoLuongDonDatHang !== null) {
                        echo $demSoLuongDonDatHang;
                    } else {
                        echo "Không có giá trị tổng giá đơn hàng.";
                    }
                    ?>
                </span>
            </div>
        </div>
        <div class="card bg-info mb-3" style="max-width: 100%;">
            <div class="card-header">Ti lệ đơn hàng</div>
            <div class="card-body d-flex align-items-center">
                <i class="fa-solid fa-percent"></i>
                <span class="card-title">
                    <?php

                    if ($tinhPhanTramDonHangThanhCong !== null) {
                        echo $tinhPhanTramDonHangThanhCong;
                    } else {
                        echo "Không có giá trị tổng giá đơn hàng.";
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
</div>


<?php
$duLieuDonHang = $objBaoCao->duLieuDonHang($conn);
echo '<script>';
$labels = json_encode(array_keys($duLieuDonHang));
$data = json_encode(array_values($duLieuDonHang));

echo 'const ctx = document.getElementById("myChart").getContext("2d");';
echo 'new Chart(ctx, {';
echo '  type: "bar",';
echo '  data: {';
echo '    labels: ' . $labels . ','; 
echo '    datasets: [';
echo '      {';
echo '        label: "Số lượng đơn hàng thành công",';
echo '        data: ' . $data . ','; 
echo '        backgroundColor: "rgba(75, 192, 192, 0.2)",';
echo '        borderColor: "rgba(75, 192, 192, 1)",';
echo '        borderWidth: 1,';
echo '      },';
echo '    ],';
echo '  },';
echo '  options: {';
echo '    scales: {';
echo '      y: {';
echo '        beginAtZero: true,';
echo '      },';
echo '    },';
echo '  },';
echo '});';
echo '</script>';
?>