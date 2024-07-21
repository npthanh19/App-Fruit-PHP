<div class="container">
    <div class="row">
        <div class="col-6">
            <form method="post">
                <div class="form-group">
                    <label for="name-client">Họ tên</label>
                    <input type="text" class="form-control" id="name-client" name="customerName"
                        placeholder="Nhập họ tên của bạn">
                </div>
                <div class="form-group">
                    <label for="address-client">Địa chỉ</label>
                    <input type="text" class="form-control" id="address-client" name="customerAddress"
                        placeholder="Nhập địa chỉ của bạn">
                </div>
                <div class="form-group">
                    <label for="phone-client">Số điện thoại</label>
                    <input type="tel" class="form-control" id="phone-client" name="customerPhone"
                        placeholder="Nhập số điện thoại của bạn">
                </div>
                <button type="submit" class="btn btn-primary" name="dat_hang">Gửi thông tin</button>
            </form>
        </div>
        <div class="col-6">
            <div class="info-payment">
                <h3>Thông tin đơn hàng</h3>
                <?php
                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                        $total_price = 0;
                        echo '<ul>';
                        foreach ($_SESSION['cart'] as $item) {
                            $product_id = $item['id'];
                            $product_name = $item['name'];
                            $product_price = $item['price'];
                            $product_quantity = $item['quantity'];
                            $total_item_price = $product_price * $product_quantity;
                            $total_price += $total_item_price;

                            echo '<li>' . $product_name . ' x ' . $product_quantity . ' - ' . $product_price . ' đồng</li>';
                        }
                        echo '</ul>';
                        echo '<p>Tổng giá tiền: ' . $total_price . '.000đ đồng</p>';
                    } else {
                        echo '<p>Không có sản phẩm nào trong giỏ hàng của bạn</p>';
                    }
                    ?>
            </div>
        </div>
    </div>
</div>