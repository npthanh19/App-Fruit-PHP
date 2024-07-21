<?php include('./partial/header.php'); ?>
<?php include('./classes/SanPham.php') ?>
<?php include('./config/database.php') ?>
<?php
$id_san_pham = $_GET['id_san_pham'];
$san_pham = new SanPham();
$san_pham->xemChiTietSanPham($conn, $id_san_pham);


$ma_danh_muc_san_pham = $san_pham->danh_muc_san_pham;
$sqlDanhMucSanPham = "SELECT ten_danh_muc FROM danh_muc_san_pham WHERE ma_danh_muc = $ma_danh_muc_san_pham";
$resultDanhMucSanPham = $conn->query($sqlDanhMucSanPham);
$ten_danh_muc_san_pham = ""; 

if ($resultDanhMucSanPham->num_rows > 0) {
    $row = $resultDanhMucSanPham->fetch_assoc();
    $ten_danh_muc_san_pham = $row['ten_danh_muc'];
}
?>
<?php
$gioHang = new GioHang();
$gioHang->themSanPhamVaoGio();

?>
<main class="detail-page">
    <div class="container">
        <div class="d-flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="./">Sản phẩm</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $san_pham->ten_san_pham?></li>
                </ol>
            </nav>
        </div>
        <div class="product__detail">
            <div class="row">
                <div class="col-4">
                    <div class="product__detail__img">
                        <img src="data:image/jpeg;base64,<?php echo $san_pham->anh_san_pham ?>" alt="...">
                    </div>
                </div>
                <div class="col-4">
                    <div class="product__detail__info">
                        <div class="product__detail__name">
                            <h3><?php echo $san_pham->ten_san_pham ?></h3>
                        </div>
                        <div class="product__detail__state">
                            <span>Trạng thái</span>
                            <?php if ($san_pham->so_luong <= 0) { ?>
                            <h3 class="out-of-stock">hết hàng</h3>
                            <?php } else { ?>
                            <h3 class="stocking">còn hàng</h3>
                            <?php } ?>
                        </div>
                        <div class="product__detail__price">
                            <span><?php echo $san_pham->gia_ban ?>đ</span>
                        </div>
                        <div class="product__detail__order">
                            <?php if ($san_pham->so_luong <= 0) { ?>
                            <?php if ($ten_danh_muc_san_pham == "Sản phẩm chỉ bán tại quầy") { ?>
                            <div class="product-note">Sản phẩm chỉ bán tại quầy</div>
                            <?php } else { ?>
                            <button class="add-to-cart-button" data-product-id="<?php echo $san_pham->ma_san_pham ?>"
                                disabled>
                                <?php echo "Liên hệ"; ?>
                            </button>
                            <?php } ?>
                            <?php } else { ?>
                            <?php if ($ten_danh_muc_san_pham == "Sản phẩm chỉ bán tại quầy") { ?>
                            <div class="product-note">Sản phẩm chỉ bán tại quầy</div>
                            <?php } else { ?>
                            <button class="add-to-cart-button" data-product-id="<?php echo $san_pham->ma_san_pham ?>">
                                <?php echo "Thêm vào giỏ"; ?>
                            </button>
                            <?php } ?>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="products__category">
                        <div class="products__category__item">
                        </div>
                        <div class="products__category__item">
                            <h3>SẢN PHẨM NỔI BẬT</h3>
                            <ul>
                                <?php
                                $objSanPham = new SanPham();
                                $sanPhamArr = $objSanPham->layTatCaSanPham($conn);
                                $count = 0;
                                foreach ($sanPhamArr as $sanPham) {
                                    if ($count >= 5) {
                                        break;
                                    }
                                    $count++;
                                ?>
                                <li>
                                    <img src="data:image/jpeg;base64,<?php echo $sanPham->anh_san_pham; ?>" alt="">
                                    <div class="info">
                                        <h4><a
                                                href="chi-tiet-san-pham.php?id_san_pham=<?php echo $sanPham->ma_san_pham; ?>">
                                                <?php echo $sanPham->ten_san_pham; ?> </a></h4>
                                        <span><?php echo $sanPham->gia_ban; ?>đ</span>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__detail__desc">
            <h3>Mô tả sản phẩm</h3>
            <div class="wrap">
                <?php echo $san_pham->mo_ta_san_pham ?>
            </div>
        </div>
        <div class="section">
            <div class="section__title">
                <h3>Sản phẩm liên quan</h3>
            </div>
            <p>Đặc sản trái cây miền tây: Xoài cát Hòa lộc, sầu riêng Ri6, vú sữa Lò rèn, cam sành Bến tre v.v....</p>
            <div class="container-fluid">
                <div id="carousel2" class="carousel carousel-multiple-product slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item carousel-multiple-item-product active">
                            <div class="row">
                                <?php
                                $sanPhamArr = $objSanPham->xemSanPhamTheoLoai($conn, 'vn', 4);
                                foreach ($sanPhamArr as $sanPham) {
                                    echo "<div class='col-12 col-md-3'>";
                                    echo "<div class='card card-product'>";
                                    echo "<div class='card-product-image'>";
                                    echo '<img src="data:image/jpeg;base64,' . $sanPham->anh_san_pham . '" alt="...">';
                                    echo "</div>";
                                    echo "<div class='card-product-image-info'>";
                                    echo "<h3>" . $sanPham->ten_san_pham . "</h3>";
                                    echo "<span>" . $sanPham->gia_ban . "đ</span>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="carousel-item carousel-multiple-item-product">
                            <div class="row">
                                <?php
                                $sanPhamArr = $objSanPham->xemSanPhamTheoLoai($conn, 'vn', 4);
                                foreach ($sanPhamArr as $sanPham) {
                                    echo "<div class='col-12 col-md-3'>";
                                    echo "<div class='card card-product'>";
                                    echo "<div class='card-product-image'>";
                                    echo '<img src="data:image/jpeg;base64,' . $sanPham->anh_san_pham . '" alt="...">';
                                    echo "</div>";
                                    echo "<div class='card-product-image-info'>";
                                    echo "<h3>" . $sanPham->ten_san_pham . "</h3>";
                                    echo "<span>" . $sanPham->gia_ban . "đ</span>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel2"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel2"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
var notyf = new Notyf();
document.addEventListener('DOMContentLoaded', function() {
    var addToCartButtons = document.querySelectorAll('.add-to-cart-button');

    <?php
        $cartIds = array();

        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $cartIds[] = $cartItem['id'];
            }
        }
        echo 'let arr = ' . json_encode($cartIds) . ';'
        ?>
    let array = arr.slice();

    addToCartButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var product_id = button.getAttribute('data-product-id');

            fetch('san-pham.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'add_to_cart=true&product_id=' + encodeURIComponent(product_id)
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(function(data) {
                    notyf.success('Thêm sản phẩm vào giỏ hàng thành công');
                    let productExists = false;


                    console.log("Trước khi push", array)
                    for (let i = 0; i < array.length; i++) {
                        if (array[i] == product_id) {
                            productExists = true;
                            break;
                        }
                    }

                    if (!productExists) {
                        const quantityElement = document.querySelector('.badge-number');
                        quantityElement.textContent++;
                        array = [...array, product_id]
                        console.log("Sau khi push", array)
                    }
                })
                .catch(function(error) {
                    console.error('Fetch error:', error);
                });
        });
    });
});
</script>

<?php include('./partial/footer.php'); ?>