<?php include("../config/database.php") ?>
<?php include("../classes/DonHangTaiQuay.php") ?>
<?php
if (isset($_GET['id'])) {
    $ma_don_hang = $_GET['id'];

    $donHang = new DonHangTaiQuay();
    $order = $donHang->layChiTietDonHang($conn, $ma_don_hang);
} ?>
<style>
.invoice-title h2 {
    margin-top: 0;
}

.invoice {
    margin-top: 20px;
}

.invoice p {
    font-size: 16px;
}

.table th {
    background-color: #f5f5f5;
}

.btn-print {
    margin-top: 20px;
}
</style>
<div class="row" id="print-content">
    <div class="col-md-12">
        <div class="invoice-title">
            <h2 class="text-center">Phiếu Mua Hàng</h2>
            <p class="text-center">Cửa Hàng: FRUIT HOME</p>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Mã Đơn Hàng:</strong> <?php echo $order['ma_don_hang']; ?></p>
                <p><strong>Tên Khách Hàng:</strong> <?php echo $order['ten_khach_hang']; ?></p>
                <p><strong>Số Điện Thoại:</strong> <?php echo $order['so_dien_thoai']; ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Ngày Đặt Hàng:</strong> <?php echo $order['ngay_dat_hang']; ?></p>
                <p><strong>Nhân Viên Lên Đơn:</strong> <?php echo $order['nhan_vien_len_don']; ?></p>
            </div>
        </div>
        <h3 class="mt-4">Chi Tiết Đơn Hàng</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá Sản Phẩm</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0;
                foreach ($order['orderDetails'] as $orderDetail) :
                    $totalPrice += $orderDetail['giaSanPham'] * $orderDetail['soLuong'];
                ?>
                <tr>
                    <td><?php echo $orderDetail['tenSanPham']; ?></td>
                    <td><?php echo $orderDetail['soLuong']; ?></td>
                    <td><?php echo $orderDetail['giaSanPham']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-right">
            <p><strong>Tổng Tiền:</strong> <?php echo number_format($totalPrice, 0, '', '.') ?></p>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-primary btn-print">In Phiếu</button>
        </div>
    </div>
</div>
<script>
function printContent() {
    var printContents = document.getElementById("print-content").innerHTML;
    var printWindow = window.open('', '', 'width=600,height=600');

    printWindow.document.open();
    /* printWindow.document.write('<html><head><title>Print</title>'); */
    printWindow.document.write(
        '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">'
    );
    printWindow.document.write('<link href="./styles/main.css" rel="stylesheet" />');
    printWindow.document.write(
        '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    printWindow.print();
    printWindow.close();
}

var printButton = document.querySelector(".btn-print");
printButton.addEventListener("click", printContent);
</script>