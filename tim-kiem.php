<?php include('./partial/header.php'); ?>
<?php include('./config/database.php') ?>
<?php include('./classes/SanPham.php') ?>
<?php
$full_link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$queryString = parse_url($full_link, PHP_URL_QUERY);
parse_str($queryString, $queryArray);
$searchTerm = $queryArray["search"];
?>
<main>
    <div class="product">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="products__category">
                        <div class="products__category__item">
                            <h3>DANH MỤC</h3>
                            <ul>
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><a href="index.php">Sản phẩm</a></li>
                                <li><a href="index.php">Giới thiệu</a></li>
                                <li><a href="index.php">Liên hệ</a></li>
                            </ul>
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
                                        <h4><?php echo $sanPham->ten_san_pham; ?></h4>
                                        <span><?php echo $sanPham->gia_ban; ?>đ</span>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="products__list">
                        <div class="row">
                            <?php
                            if (isset($_POST['add_to_cart'])) {
                                $product_id = $_POST['product_id'];
                                $query = "SELECT * FROM san_pham WHERE ma_san_pham = $product_id";
                                include("./config/database.php");
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $sanpham = mysqli_fetch_assoc($result);

                                    if (!isset($_SESSION['cart'])) {
                                        $_SESSION['cart'] = array();
                                    }

                                    $product = array(
                                        'id' => $sanpham['ma_san_pham'],
                                        'name' => $sanpham['ten_san_pham'],
                                        'image' => $sanpham['anh_san_pham'],
                                        'price' => $sanpham['gia_san_pham'],
                                        'quantity' => 1
                                    );

                                    $product_exists = false;
                                    foreach ($_SESSION['cart'] as $key => $item) {
                                        if ($item['id'] == $product['id']) {
                                            $_SESSION['cart'][$key]['quantity']++;
                                            $product_exists = true;
                                            break;
                                        }
                                    }

                                    if (!$product_exists) {
                                        array_push($_SESSION['cart'], $product);
                                    }
                                }
                            }
                            ?>
                            <?php
                            include('./config/database.php');
                            $sanPhamArr = $objSanPham->timSanPham($conn, $searchTerm);
                            if (count($sanPhamArr) > 0) {
                                foreach ($sanPhamArr as $sanPham) {
                                    echo '<div class="col-12 col-md-3">';
                                    echo '<div class="card card-product">';
                                    echo '<div class="card-product-image">';
                                    echo '<img src="data:image/jpeg;base64,' . $sanPham->anh_san_pham . '" alt="...">';
                                    echo '</div>';
                                    echo '<div class="card-product-image-info">';
                                    echo '<h3><a href="chi-tiet-san-pham.php?id_san_pham=' . $sanPham->ma_san_pham . '"> ' . $sanPham->ten_san_pham . ' </a></h3>';
                                    echo '<span>' . $sanPham->gia_ban . '</span>';
                                    echo '</div>';
                                    echo '<div class="card-product-add">';
                                    echo '<form method="post">';
                                    echo '<input type="hidden" name="product_id" value="' . $sanPham->ma_san_pham . '">';
                                    echo '<button type="submit" name="add_to_cart"><i class="fa-light fa-plus"></i></button>';
                                    echo '</form>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo "Không tìm thấy sản phẩm nào phù hợp";
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('./partial/footer.php'); ?>