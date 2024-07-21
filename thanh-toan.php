<?php
include("./config/database.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_POST['selected_products']) || empty($_POST['selected_products'])) {
    header("Location: gio-hang.php?gio-hang=null");
    exit;
}
$selectedProducts = $_POST['selected_products'];
$notEnoughProducts = [];

foreach ($selectedProducts as $productId => $productQuantity) {
    $sql = "SELECT * FROM san_pham WHERE ma_san_pham = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productPrice = $row['gia_ban'];
        $availableQuantity = $row['so_luong'];

        if ($productQuantity > $availableQuantity) {
            $productName = $row['ten_san_pham'];
            $notEnoughProducts[] = [
                'name' => $productName,
                'availableQuantity' => $availableQuantity,
            ];
        }
    }
}

if (!empty($notEnoughProducts)) {
    $message = "false";
    $productInfo = "";

    foreach ($notEnoughProducts as $product) {
        $productInfo .= "Sản phẩm " . $product['name'] . " không đủ số lượng (Số lượng hiện có: " . $product['availableQuantity'] . "). ";
    }

    header("Location: gio-hang.php?message=$message&productInfo=$productInfo");
    exit;
}

?>
<?php include('./partial/header.php'); ?>
<?php include('./config/database.php') ?>
<?php
$selectedProducts = $_POST['selected_products'];
$_SESSION['selected_products'] = $_POST['selected_products'];

$totalPrice = 0;
foreach ($selectedProducts as $productId => $productQuantity) {
    $sql = "SELECT * FROM san_pham WHERE ma_san_pham = $productId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productPrice = $row['gia_ban'];

        $totalPrice += $productPrice * $productQuantity;
    }
}
?>
<div class="thanh-toan py-5">
    <div class="container p-10">
        <div class="row">
            <div class="col-6">
                <h1>Trang nhập thông tin giao hàng</h1>
                <form action="./handler/xu-ly-thong-tin-giao-hang.php" method="post" id="myForm"
                    enctype=" application/x-www-form-urlencoded">
                    <input type="hidden" id="totalPriceInput" name="total-price" value="<?php echo $totalPrice ?>">
                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên</label>
                        <input type="text" class="form-control" id="ten" name="ten" required>
                    </div>
                    <div class="mb-3">
                        <label for="so-dien-thoai" class="form-label">Số điện thoại</label>
                        <input type="number" class="form-control" id="so-dien-thoai" name="so-dien-thoai" required>
                    </div>
                    <div class="mb-3">
                        <label for="dia-chi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="dia-chi" name="dia-chi" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phương thức thanh toán</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="phuong-thuc-thanh-toan" id="tien-mat"
                                value="Tiền mặt" required>
                            <label class="form-check-label" for="tien-mat">Thanh toán khi nhận hàng</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="phuong-thuc-thanh-toan"
                                id="chuyen-khoan-qr" value="Chuyển khoản QR Code" required>
                            <label class="form-check-label" for="chuyen-khoan-qr">Chuyển khoản QR Code</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="phuong-thuc-thanh-toan"
                                id="chuyen-khoan-atm" value="Chuyển khoản ATM" required>
                            <label class="form-check-label" for="chuyen-khoan-atm">Chuyển khoản ATM</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tiếp tục đến phương thức thanh toán</button>
                </form>
            </div>
            <div class="col-6">
                <form id="voucher-form" class="mb-3">
                    <div class="mb-3">
                        <label for="ma-voucher" class="form-label">Nhập mã voucher (nếu có)</label>
                        <input type="text" class="form-control" id="ma-voucher" name="ma-voucher">
                    </div>
                    <button class="btn btn-primary">Áp dụng voucher ( nếu có )</button>
                    <div id="voucher-info"></div>
                </form>
                <div class="applied-vouchers-container mb-3">
                    <h3>Voucher đã áp dụng</h3>
                    <div class="applied-vouchers"></div>
                </div>
                <?php
                if (isset($_POST['selected_products'])) {
                    $selectedProducts = $_POST['selected_products'];
                    $_SESSION['selected_products'] = $_POST['selected_products'];

                    $totalPrice = 0;
                    foreach ($selectedProducts as $productId => $productQuantity) {
                        $sql = "SELECT * FROM san_pham WHERE ma_san_pham = $productId";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $productPrice = $row['gia_ban'];

                            $totalPrice += $productPrice * $productQuantity;

                            echo '<li class="cart__item">';
                            echo '<div class="cart__item__img">';
                            echo '<img src="data:image/jpeg;base64,' . $row['anh_san_pham'] . '" alt="...">';
                            echo '</div>';
                            echo '<div class="cart__item__name">';
                            echo '<h3>' . $row['ten_san_pham'] . '</h3>';
                            echo '</div>';
                            echo '<div class="cart__item__price">';
                            echo '<span>' .  $row['gia_ban'] . '</span>';
                            echo '</div>';
                            echo '<div class="cart__item__count">';
                            echo '<span>' . $productQuantity . '</span>';
                            echo '</div>';
                            echo '<div class="cart__item__total">';
                            echo '<span>' . $row['gia_ban'] * $productQuantity . '.000đ</span>';
                            echo '</div>';
                            echo '</li>';
                        }
                    }
                }
                $_SESSION['total_price'] = $totalPrice;
                echo '<div class="total d-flex justify-content-between"><span>Tổng tiền đơn hàng :</span> <span id="total">' . $totalPrice . '.000 VNĐ</span></div>';
                ?>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
var notyf = new Notyf();
document.getElementById('voucher-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var voucherCode = document.getElementById('ma-voucher').value;

    var selectedProductsElements = document.querySelectorAll('.cart__item__name');
    var selectedProducts = [];

    selectedProductsElements.forEach(function(element) {
        var productName = element.querySelector("h3").textContent

        selectedProducts.push({
            name: productName
        });
    });


    fetch('handler/ap-dung-voucher.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'ma-voucher=' + encodeURIComponent(voucherCode)
        })
        .then(response => response.json())
        .then(data => {
            if (data.hasOwnProperty('message')) {
                notyf.error(data.message);
                return;
            }
            if (data.hasOwnProperty('voucher_info')) {
                var voucherInfo = data.voucher_info;
                var productList = data.product_list;

                const currentDate = new Date();
                const startDate = new Date(voucherInfo.ngay_bat_dau);
                const endDate = new Date(voucherInfo.ngay_ket_thuc);
                const isVoucherValid = currentDate >= startDate && currentDate <= endDate;

                var totalPriceInput = document.getElementById('totalPriceInput');
                var totalPrice = parseFloat(totalPriceInput.value);
                const isTotalPriceValid = totalPrice >= parseFloat(voucherInfo.gia_tri_don_hang_ap_dung);

                const isVoucherQuantityValid = parseInt(voucherInfo.so_luong_giam_gia) > 0;

                const isProductValid = productList.some(product => product.ma_san_pham === voucherInfo
                    .ma_san_pham);


                const isProductInList = selectedProducts.some(product => {
                    return productList.some(p => p.ten_san_pham === product.name);
                });


                if (isVoucherValid && isTotalPriceValid && isVoucherQuantityValid && isProductValid &&
                    isProductInList) {
                    console.log(voucherInfo.loai_voucher)
                    if (voucherInfo.loai_voucher === 'Giảm giá trực tiếp theo số tiền') {
                        totalPrice -= voucherInfo.gia_tri;
                        console.log()
                    } else if (voucherInfo.loai_voucher === 'Giảm giá theo phần trăm') {
                        totalPrice -= totalPrice * (voucherInfo.phan_tram_giam_gia / 100);
                    }

                    totalPrice = Math.max(0, totalPrice);
                    totalPriceInput.value = totalPrice;
                    document.getElementById('total').textContent = 'Tổng tiền đơn hàng: ' + totalPrice +
                        '.000 VNĐ';

                    notyf.success('Áp dụng voucher thành công');

                    function updateAppliedVouchers(appliedVouchers) {
                        var appliedVouchersContainer = document.querySelector('.applied-vouchers');
                        var ul = appliedVouchersContainer.querySelector('ul');
                        if (!ul) {
                            ul = document.createElement('ul');
                            ul.className = "list-group"
                            appliedVouchersContainer.appendChild(ul);
                        }

                        if (appliedVouchers) {
                            var li = document.createElement('li');
                            li.textContent = appliedVouchers;
                            li.className = "list-group-item"
                            ul.appendChild(li);
                        }
                    }

                    updateAppliedVouchers(voucherInfo.ma_voucher);
                } else {

                    if (!isVoucherValid) notyf.error('Voucher đã hết hạn sử dụng.');
                    if (!isTotalPriceValid) notyf.error('Giá tiền không đủ để áp dụng voucher.');
                    if (!isVoucherQuantityValid) notyf.error('Số lượng của voucher không hợp lệ.');
                    if (!isProductValid) notyf.error('Sản phẩm không đủ để áp dụng voucher.');
                    if (!isProductInList) notyf.error(
                        'Sản phẩm của voucher không nằm trong danh sách sản phẩm đang mua.');
                }
            } else {
                notyf.error('Voucher bạn áp dụng không hợp lệ');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
</script>
<script>
window.addEventListener('beforeunload', function(event) {
    fetch('handler/xoa-session-voucher.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Session về voucher đã được xóa.');
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
</script>