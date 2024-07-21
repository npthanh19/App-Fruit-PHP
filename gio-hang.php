<?php session_start(); ?>
<?php include('./partial/header.php'); ?>
<?php
$gioHang = new GioHang();
if (isset($_GET['remove_item'])) {
    $item_id = $_GET['remove_item'];
    $gioHang->xoaSanPhamKhoiGio($conn, $item_id);
}
?>
<?php
$actionUrl = isset($_SESSION['id_tai_khoan']) ? 'thanh-toan.php' : 'gio-hang.php?dang-nhap=false';
?>

<div class="container">
    <?php
if (isset($_GET['dang-nhap']) && $_GET['dang-nhap'] === 'false') {
    echo '<div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">';
    echo 'Vui lòng <span data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="font-weight: 700 !important; cursor: pointer;">đăng nhập</span> để đặt hàng';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
if (isset($_GET['gio-hang']) && $_GET['gio-hang'] === 'null') {
    echo '<div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">';
    echo 'Vui lòng chọn sản phẩm cần mua';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
if (isset($_GET['message']) && isset($_GET['productInfo']) && $_GET['message'] === 'false' && $_GET['productInfo'] !== '') {
    echo '<div class="alert alert-info alert-dismissible fade show mt-5" role="alert">';
    echo  htmlspecialchars($_GET['productInfo']);
    echo '<br/>';
    echo 'Bạn vui lòng giảm số lượng hoặc đặt hàng lại sau giúp shop nhé';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>

</div>
<main>
    <div class="cart">
        <div class="container">
            <div class="cart__item__header">
                <ul>
                    <li> </li>
                    <li>Sản phẩm</li>
                    <li>Thông tin sản phẩm</li>
                    <li>Đơn giá</li>
                    <li>Số lượng</li>
                    <li>Thành tiền</li>
                    <li>Xóa</li>
                </ul>
            </div>
            <form method="POST" action='<?php echo $actionUrl; ?>'>
                <ul class="cart__list">
                    <?php
                    if (isset($_SESSION['id_tai_khoan'])) {
                        $chi_tiet_gio_hang = $gioHang->layTatCaChiTietGioHang();

                        if (!empty($chi_tiet_gio_hang)) {
                            $total_price = 0;
                            foreach ($chi_tiet_gio_hang as $item) {
                                $product_id = $item->ma_san_pham;
                                $product_name = $item->ten_san_pham;
                                $product_price = $item->gia_san_pham;
                                $product_quantity = $item->so_luong;
                                $total_item_price = $product_price * $product_quantity;
                                $total_price += $total_item_price;

                                echo '<li class="cart__item">';
                                echo '<div class="cart__item__checkbox">';
                                echo '<input type="checkbox" name="selected_products[' . $product_id . ']" value="' . $product_quantity . '">';
                                echo '</div>';
                                echo '<div class="cart__item__img">';
                                echo '<img src="data:image/jpeg;base64,' . $item->anh_san_pham . '" alt="...">';
                                echo '</div>';
                                echo '<div class="cart__item__name">';
                                echo '<h3>' . $item->ten_san_pham . '</h3>';
                                echo '</div>';
                                echo '<div class="cart__item__price">';
                                echo '<span>' . $item->gia_san_pham . '</span>';
                                echo '</div>';
                                echo '<div class="cart__item__count">';
                                echo '<input type="number" class="product-quantity text-center mx-auto form-control" value="' . $product_quantity . '" min="1" data-product-id="'.$product_id.'" data-old-quantity="'.$product_quantity.'">';
                                echo '</div>';
                                echo '<div class="cart__item__total">';
                                echo '<span>' . $total_item_price . '.000 ₫</span>';
                                echo '</div>';
                                echo '<div class="cart__item__remove">';
                                echo '<a href="javascript:void(0);" class="remove-product" data-product-id="' . $product_id . '">';
                                echo '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>';
                                echo '</svg>';
                                echo '</a>';
                                echo '</div>';
                                echo '</li>';
                            }
                            echo '<div class="total_price">';
                            echo '<span>Tổng tiền</span>';
                            echo '<h3>0đ</h3>';
                            echo '</div>';
                        } else {
                            echo '<div class="cart_empty">';
                            echo '<span>Không có sản phẩm nào trong giỏ hàng của bạn</span>';
                            echo '</div>';
                        }
                    } else {
                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                            $total_price = 0;
                            foreach ($_SESSION['cart'] as $item) {
                                $product_id = $item['id'];
                                $product_name = $item['name'];
                                $product_price = $item['price'];
                                $product_quantity = $item['quantity'];
                                $total_item_price = $product_price * $product_quantity;
                                $total_price += $total_item_price;

                                echo '<li class="cart__item">';
                                echo '<div class="cart__item__checkbox">';
                                echo '<input type="checkbox" name="selected_products[' . $product_id . ']" value="' . $product_quantity . '">';
                                echo '</div>';
                                echo '<div class="cart__item__img">';
                                echo '<img src="data:image/jpeg;base64,' . $item['image'] . '" alt="...">';
                                echo '</div>';
                                echo '<div class="cart__item__name">';
                                echo '<h3>' . $item['name'] . '</h3>';
                                echo '</div>';
                                echo '<div class="cart__item__price">';
                                echo '<span>' . $item['price'] . '</span>';
                                echo '</div>';
                                echo '<div class="cart__item__count">';
                                echo '<input type="number" class="product-quantity text-center mx-auto form-control" value="' . $product_quantity . '" min="1" data-product-id="'.$product_id.'">';
                                echo '</div>';
                                echo '<div class="cart__item__total">';
                                echo '<span>' . $total_item_price . '.000 ₫</span>';
                                echo '</div>';
                                echo '<div class="cart__item__remove">';
                                echo '<a href="javascript:void(0);" class="remove-product" data-product-id="' . $product_id . '">';
                                echo '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>';
                                echo '</svg>';
                                echo '</a>';
                                echo '</div>';
                                echo '</li>';
                            }
                            echo '<div class="total_price">';
                            echo '<span>Tổng tiền</span>';
                            echo '<h3>0đ</h3>';
                            echo '</div>';
                        } else {
                            echo '<div class="cart_empty">';
                            echo '<span>Không có sản phẩm nào trong giỏ hàng của bạn</span>';
                            echo '</div>';
                        }
                    }
                    ?>
                </ul>
                <div class="order">
                    <button type="submit">Chọn sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
var notyf = new Notyf();
document.addEventListener('DOMContentLoaded', function() {
    const productQuantityInputs = document.querySelectorAll('.product-quantity');

    productQuantityInputs.forEach(function(input) {
        const oldQuantity = input.getAttribute('data-old-quantity');
        input.addEventListener('change', function() {
            const productId = input.dataset.productId;
            const newQuantity = input.value;

            fetch('./handler/cap-nhat-so-luong-gio-hang.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}&new_quantity=${newQuantity}`
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    const productPriceElement = input.closest('.cart__item').querySelector(
                        '.cart__item__price span');
                    const totalPriceElement = input.closest('.cart__item').querySelector(
                        '.cart__item__total span');

                    const productPriceText = productPriceElement.textContent;
                    const productPrice = parseFloat(productPriceText.replace(/[^0-9.]/g,
                        ''));
                    const newTotalPrice = productPrice * newQuantity;

                    totalPriceElement.textContent = formatCurrency(newTotalPrice);
                    return response.text();
                })
                .then(function(data) {
                    input.setAttribute('data-old-quantity', newQuantity);
                    console.log(data)
                })
                .catch(function(error) {
                    input.value = oldQuantity;
                    notyf.error('Số lượng sản phẩm trong kho không đủ');
                    console.error('Fetch error:', error);
                });

        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productQuantityInputs = document.querySelectorAll('.product-quantity');
    const totalPriceElement = document.querySelector('.total_price h3');
    const checkBoxes = document.querySelectorAll('.cart__item__checkbox input');


    let total_price = 0;


    function updateTotalPrice() {
        total_price = 0;
        checkBoxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                const productPriceElement = checkbox.closest('.cart__item').querySelector(
                    '.cart__item__price span');
                const productQuantity = parseInt(checkbox.closest('.cart__item').querySelector(
                    '.product-quantity').value);

                const productPriceText = productPriceElement.textContent;
                const productPrice = parseFloat(productPriceText.replace(/[^0-9.]/g, ''));

                total_price += productPrice * productQuantity;
            }
        });


        total_price = Math.round(total_price * 1000) / 1000;
        console.log(formatCurrency(total_price))
        totalPriceElement.textContent = formatCurrency(total_price);
    }


    checkBoxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateTotalPrice();
        });
    });


    productQuantityInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            updateTotalPrice();
        });
    });


    updateTotalPrice();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const removeButtons = document.querySelectorAll('.remove-product');

    const cart__item__total = document.querySelectorAll(".cart__item__total")

    cart__item__total.forEach((item) => {
        let cleanedText = item.textContent.replace(/[₫.\s]/g, '');
        cleanedText = cleanedText.replace(/000$/, '');
        item.textContent = formatCurrency(cleanedText)
    })

    removeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const productId = button.dataset.productId;
            const cartItem = button.closest('.cart__item');
            cartItem.remove();

            fetch('gio-hang.php?remove_item=' + productId, {
                    method: 'GET',
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    const productPriceElement = input.closest('.cart__item').querySelector(
                        '.cart__item__price span');
                    const totalPriceElement = input.closest('.cart__item').querySelector(
                        '.cart__item__total span');

                    const productPriceText = productPriceElement.textContent;
                    const productPrice = parseFloat(productPriceText.replace(/[^0-9.]/g,
                        ''));
                    const newTotalPrice = productPrice * newQuantity;

                    totalPriceElement.textContent = formatCurrency(newTotalPrice);
                    return response.text();
                })
                .then(function(data) {
                    const quantityElement = document.querySelector('.badge-number');
                    quantityElement.textContent--;
                })
                .catch(function(error) {
                    console.error('Fetch error:', error);
                });
        });
    });
});
</script>
<script>
function formatCurrency(amount) {
    const formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 3,
    });

    const formattedString = formatter.formatToParts(amount)
        .map(part => part.value === ',' ? '.' : part.value)
        .join('');

    return formattedString;
}
</script>

<?php include('./partial/footer.php'); ?>