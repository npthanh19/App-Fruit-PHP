<?php session_start(); ?>
<?php include('./partial/header.php'); ?>
<?php include('./classes/SanPham.php') ?>
<main>
    <div class="product">
        <div class="container">
            <div class="d-flex">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                    </ol>
                </nav>
                <select class="form-select" onchange="window.location.href = this.value;">
                    <option selected disabled>Sắp xếp theo</option>
                    <option value="./san-pham.php">Mặc định</option>
                    <option value="./san-pham.php?sap-xep-ten=asc">A -> Z</option>
                    <option value="./san-pham.php?sap-xep-ten=desc">Z -> A</option>
                    <option value="./san-pham.php?sap-xep-gia=asc">Tăng dần</option>
                    <option value="./san-pham.php?sap-xep-gia=desc">Giảm dần</option>
                </select>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="products__category">
                        <div class="products__category__item">
                            <h3>DANH MỤC</h3>
                            <ul>
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><a href="products.php">Sản phẩm</a></li>
                                <li><a href="introduce.php">Giới thiệu</a></li>
                                <li><a href="contact.php">Liên hệ</a></li>
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
                                        <h4><a
                                                href="chi-tiet-san-pham.php?id_san_pham=<?php echo $sanPham->ma_san_pham; ?>">
                                                <?php echo $sanPham->ten_san_pham; ?> </a></h4>
                                        <span><?php echo $sanPham->gia_ban; ?>đ</span>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="products__category__item">
                            <h3>LOẠI</h3>
                            <ul>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="traiCayBanOnline">
                                        <label class="form-check-label" for="traiCayBanOnline">
                                            Trái cây bán online
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="traiCayBanTaiQuay">
                                        <label class="form-check-label" for="traiCayBanTaiQuay">
                                            Trái cây bán tại quầy
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="products__category__item">
                            <h3>GIÁ SẢN PHẨM</h3>
                            <ul id="priceFilters">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="under100kCheckbox"
                                            data-filter="under_100k">
                                        <label class="form-check-label" for="under100kCheckbox">
                                            Giá dưới 100.000đ
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="100kTo200kCheckbox"
                                            data-filter="100k_to_200k">
                                        <label class="form-check-label" for="100kTo200kCheckbox">
                                            100.000đ - 200.000đ
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="200kTo300kCheckbox"
                                            data-filter="200k_to_300k">
                                        <label class="form-check-label" for="200kTo300kCheckbox">
                                            200.000đ - 300.000đ
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="300kTo500kCheckbox"
                                            data-filter="300k_to_500k">
                                        <label class="form-check-label" for="300kTo500kCheckbox">
                                            300.000đ - 500.000đ
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="500kTo1mCheckbox"
                                            data-filter="500k_to_1m">
                                        <label class="form-check-label" for="500kTo1mCheckbox">
                                            500.000đ - 1.000.000đ
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="over1mCheckbox"
                                            data-filter="over_1m">
                                        <label class="form-check-label" for="over1mCheckbox">
                                            Giá trên 1.000.000đ
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="products__list">
                        <div class="row">
                            <?php
                            $gioHang = new GioHang();
                            $gioHang->themSanPhamVaoGio();
                            ?>
                            <?php
                            include('./config/database.php');
                            if (!$conn) {
                                die('Không thể kết nối đến cơ sở dữ liệu: ' . mysqli_connect_error());
                            }
                            $sanpham_obj = new SanPham();
                            $soLuong = isset($_GET['soLuong']) ? $_GET['soLuong'] : 16;
                            $trang = isset($_GET['trang']) ? $_GET['trang'] : 1;
                            $sanpham_list;
                            if (isset($_GET['sap-xep-ten'])) {
                                if ($_GET['sap-xep-ten'] == 'asc') {
                                    $sanpham_list = $sanpham_obj->layTatCaSanPhamASC($conn, $soLuong, $trang);
                                }
                                if ($_GET['sap-xep-ten'] == 'desc') {
                                    $sanpham_list = $sanpham_obj->layTatCaSanPhamDESC($conn, $soLuong, $trang);
                                }
                            } else
                            if (isset($_GET['sap-xep-gia'])) {
                                if ($_GET['sap-xep-gia'] == 'asc') {
                                    $sanpham_list = $sanpham_obj->layTatCaSanPhamGiaTangDan($conn, $soLuong, $trang);
                                }
                                if ($_GET['sap-xep-gia'] == 'desc') {
                                    $sanpham_list = $sanpham_obj->layTatCaSanPhamGiaGiamDan($conn, $soLuong, $trang);
                                }
                            } else if (isset($_GET['loai'])) {
                                if ($_GET['loai'] == 'traicaybanonline') {
                                    $sanpham_list = $sanpham_obj->layTatCaSanPhamVietNam($conn, $soLuong, $trang);
                                }
                                if ($_GET['loai'] == 'traicaybantaiquay') {
                                    $sanpham_list = $sanpham_obj->layTatCaSanPhamNuocNgoai($conn, $soLuong, $trang);
                                }
                            } else if (isset($_GET['gia'])) {
                                $filters = $_GET['gia'];
                                $sanpham_list = $sanpham_obj->layTatCaSanPhamTheoGia($conn, $filters, $soLuong, $trang);
                            } else {
                                $sanpham_list = $sanpham_obj->layTatCaSanPhamPhanTrang($conn, $soLuong, $trang);
                            }
                            foreach ($sanpham_list as $sanpham) {
                                $ma_danh_muc_san_pham = $sanpham->danh_muc_san_pham;
                                $sqlDanhMucSanPham = "SELECT ten_danh_muc FROM danh_muc_san_pham WHERE ma_danh_muc = $ma_danh_muc_san_pham";
                                $resultDanhMucSanPham = $conn->query($sqlDanhMucSanPham);
                                $ten_danh_muc_san_pham = "";

                                if ($resultDanhMucSanPham->num_rows > 0) {
                                    $row = $resultDanhMucSanPham->fetch_assoc();
                                    $ten_danh_muc_san_pham = $row['ten_danh_muc'];
                                }

                                $isQuayOnly = ($ten_danh_muc_san_pham == "Sản phẩm chỉ bán tại quầy");
                                echo '<div class="col-12 col-md-3">';
                                echo '<div class="card card-product' . ($sanpham->so_luong < 0 ? ' disabled' : '') . '">';

                                if ($sanpham->so_luong == 0) {
                                    echo '<div class="card-product-tag">Hết hàng</div>';
                                }

                                echo '<div class="card-product-image">';
                                echo '<img src="data:image/jpeg;base64,' . $sanpham->anh_san_pham . '" alt="...">';
                                echo '</div>';
                                echo '<div class="card-product-image-info">';
                                echo '<h3><a href="chi-tiet-san-pham.php?id_san_pham=' . $sanpham->ma_san_pham . '"> ' . $sanpham->ten_san_pham . ' </a></h3>';
                                echo '<span>' . $sanpham->gia_ban . 'đ</span>';
                                echo '</div>';

                                if ($sanpham->so_luong > 0) {
                                    echo '<div class="card-product-add add-to-cart-button"  data-product-id="' . $sanpham->ma_san_pham . '" data-is-quay-only="' . $isQuayOnly . '">';
                                    echo '<input type="hidden" name="product_id" value="' . $sanpham->ma_san_pham . '">';
                                    echo '<button><i class="fa-light fa-plus"></i></button>';
                                    echo '</div>';
                                }

                                echo '</div>';
                                echo '</div>';
                            }

                            ?>

                        </div>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item">
                                <?php if ($trang > 1) : ?>
                                <a class="page-link" href='./san-pham.php?soLuong=16&trang=<?php echo ($trang - 1); ?>'
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                                <?php else : ?>
                                <span class="page-link" aria-hidden="true">&laquo;</span>
                                <?php endif; ?>
                            </li>
                            <?php
                            $objSanPham = new SanPham();
                            $sanPhamArr = $objSanPham->layTatCaSanPham($conn);

                            $soSanPhamTrenTrang = 16;
                            $soLuongSanPham = count($sanPhamArr);

                            $soTrang = ceil($soLuongSanPham / $soSanPhamTrenTrang);

                            for ($page = 1; $page <= $soTrang; $page++) {
                            ?>
                            <li class="page-item <?php if ($page == $trang) echo 'active'; ?>">
                                <a class="page-link"
                                    href='./san-pham.php?soLuong=16&trang=<?php echo $page; ?>'><?php echo $page; ?></a>
                            </li>
                            <?php
                            }
                            ?>
                            <li class="page-item">
                                <?php if ($trang < $soTrang) : ?>
                                <a class="page-link" href='./san-pham.php?soLuong=16&trang=<?php echo ($trang + 1); ?>'
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                                <?php else : ?>
                                <span class="page-link" aria-hidden="true">&raquo;</span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>

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
            var isQuayOnly = button.getAttribute('data-is-quay-only');

            if (isQuayOnly === "1") {
                notyf.error('Sản phẩm chỉ bán tại quầy');
                return;
            }

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