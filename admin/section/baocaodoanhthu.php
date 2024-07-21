

<?php
include("../config/database.php");
include("../classes/BaoCao.php");
$objBaoCao = new BaoCao();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST["start-date"];
    $endDate = $_POST["end-date"];

    $totalGiaDonHang = $objBaoCao->tinhTongGiaDonHang($conn, $startDate, $endDate);
    $doanhThu = $objBaoCao->tinhDoanhThuDonHang($conn, $startDate, $endDate);
} else {

    $totalGiaDonHang = $objBaoCao->tinhTongGiaDonHang($conn);
    $doanhThu = $objBaoCao->tinhDoanhThuDonHang($conn);
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
        <div class="card text-white bg-primary mb-3" style="max-width: 100%;">
            <div class="card-header">Doanh thu</div>
            <div class="card-body d-flex align-items-center">
                <i class="fa-solid fa-coins"></i>
                <span class="card-title">
                    <?php
                    if ($totalGiaDonHang  !== null) {
                        $price = number_format($totalGiaDonHang, 0, ',', '.') . '.000 VND';
                        echo $price;
                    } else {
                        echo "Không có giá trị tổng giá đơn hàng.";
                    }
                    ?>
                </span>
            </div>
        </div>
        <div class="card bg-secondary mb-3" style="max-width: 100%;">
            <div class="card-header">Lợi nhuận</div>
            <div class="card-body d-flex align-items-center">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <span class="card-title">
                    <?php

                    if ($doanhThu  !== null) {
                        $price = number_format($doanhThu , 0, ',', '.') . '.000 VND';
                        echo $price;
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
$duLieuDoanhThu = $objBaoCao->duLieuDoanhThu($conn);
echo '<script>';
$labels = json_encode(array_keys($duLieuDoanhThu));
$data = json_encode(array_values($duLieuDoanhThu));

echo 'const ctx = document.getElementById("myChart");';
echo 'new Chart(ctx, {';
echo '  type: "bar",';
echo '  data: {';
echo '    labels: ' . $labels . ','; 
echo '    datasets: [';
echo '      {';
echo '        label: "Doanh thu (VND)",';
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