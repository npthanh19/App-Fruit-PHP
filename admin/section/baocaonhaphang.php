<?php
include("../config/database.php");
include("../classes/BaoCao.php");

$objBaoCao = new BaoCao();
$duLieuNhapHang = $objBaoCao->duLieuNhapHang($conn);
$topNhaCungCap = $objBaoCao->topNhaCungCapNhapHang($conn);
?>
<div class="row">
    <div class="col-6">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col">
        <div class="card bg-light mb-3" style="max-width: 100%;">
            <div class="card-header">Top 5 nhà cung cấp nhập hàng nhiều nhất</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    foreach ($topNhaCungCap as $nhacungcap) {
                        echo '<li class="list-group-item">' . $nhacungcap['ten_nha_cung_cap'] . ' - ' . $nhacungcap['so_lan_nhap'] . ' sản phẩm đã bán</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
$data = [];
foreach ($duLieuNhapHang as $item) {
    $data[] = $item['so_luong'];
}
$labels = json_encode(array_column($duLieuNhapHang, 'ngay_nhap'));

echo '<script>';
echo 'const ctx = document.getElementById("myChart").getContext("2d");';
echo 'new Chart(ctx, {';
echo '  type: "bar",';
echo '  data: {';
echo '    labels: ' . $labels . ','; 
echo '    datasets: [';
echo '      {';
echo '        label: "Số lượng hàng nhập",';
echo '        data: ' . json_encode($data) . ','; 
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