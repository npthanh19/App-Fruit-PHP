<?php
include("../config/database.php");
include("../classes/BaoCao.php");
$objBaoCao = new BaoCao();

?>

<div class="row">
    <div class="col-6">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-6">
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
        <div class="card bg-warning mb-3" style="max-width: 100%;">
            <div class="card-header">Tỉ lệ chuyển đổi</div>
            <div class="card-body d-flex align-items-center">
                <i class="fa-solid fa-percent"></i>
                <span class="card-title">
                    <?php
                    $value = $objBaoCao->tinhPhanTramNguoiDungDatHang($conn);

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



<?php
$soLuongKhachHang = $objBaoCao->demSoLuongKhachHang($conn);
$tyleChuyenDoi = $objBaoCao->tinhPhanTramNguoiDungDatHang($conn);


echo '<script>';
echo 'const ctx = document.getElementById("myChart").getContext("2d");';
echo 'new Chart(ctx, {';
echo '  type: "doughnut",';
echo '  data: {';
echo '    labels: ["Số lượng khách hàng", "Tỉ lệ chuyển đổi (%)"],'; 
echo '    datasets: [{';
echo '      data: [' . $soLuongKhachHang . ', ' . $tyleChuyenDoi . '],';
echo '      backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)"],';
echo '      borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)"],';
echo '      borderWidth: 1,';
echo '    }],';
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