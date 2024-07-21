<?php
include("../config/database.php");
include("../classes/BaoCao.php");
$objBaoCao = new BaoCao();
$topSellingProducts = $objBaoCao->layDanhSachSanPhamBanChayNhat($conn);
$sanPhamGioHangNhieuNhat = $objBaoCao->laySanPhamGioHangNhieuNhat($conn);
?>
<div class="row">
    <div class="col-6">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-6">
        <div class="card bg-light mb-3" style="max-width: 100%;">
            <div class="card-header">Top 5 sản phẩm được bán nhiều nhất</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    foreach ($topSellingProducts as $product) {
                        echo '<li class="list-group-item">' . $product['ten_san_pham'] . ' - ' . $product['so_luong_ban'] . ' sản phẩm đã bán</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="card bg-light mb-3" style="max-width: 100%;">
            <div class="card-header">Top 5 sản phẩm được bỏ vào giỏ hàng nhiều nhất</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    foreach ($sanPhamGioHangNhieuNhat as $product) {
                        echo '<li class="list-group-item">' . $product['ten_san_pham'] . ' - ' . $product['so_luong_gio_hang'] . ' lượt bỏ vào giỏ</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
echo '<script>';
$labels = [];
$data = [];

foreach ($objBaoCao->duLieuSanPham($conn) as $tenSanPham => $soLuong) {
    $labels[] = $tenSanPham;
    $data[] = $soLuong;
}

echo 'const ctx = document.getElementById("myChart");';
echo 'new Chart(ctx, {';
echo '  type: "doughnut",';
echo '  data: {';
echo '    labels: ' . json_encode($labels) . ','; 
echo '    datasets: [';
echo '      {';
echo '        label: "Thống kê số lượng sản phẩm được bán",'; 
echo '        data: ' . json_encode($data) . ','; 
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