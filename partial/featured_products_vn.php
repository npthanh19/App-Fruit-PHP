<div class="section">
    <div class="section__title">
        <h3>Sản phẩm bán online</h3>
    </div>
    <p>Đặc sản trái cây miền tây: Xoài cát Hòa lộc, sầu riêng Ri6, vú sữa Lò rèn, cam sành Bến tre v.v....</p>
    <div class="container-fluid">
        <div id="carousel2" class="carousel carousel-multiple-product slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item carousel-multiple-item-product active">
                    <div class="row">
                        <?php
                                $sanPhamArr = $objSanPham->xemSanPhamTheoLoai($conn, 0, 4);
                                foreach ($sanPhamArr as $sanPham) {
                                    echo "<div class='col-12 col-md-3'>";
                                    echo "<div class='card card-product'>";
                                    echo "<div class='card-product-image'>";
                                    echo '<img src="data:image/jpeg;base64,' . $sanPham->anh_san_pham . '" alt="...">';
                                    echo "</div>";
                                    echo "<div class='card-product-image-info'>";
                                    echo '<h3><a href="chi-tiet-san-pham.php?id_san_pham=' . $sanPham->ma_san_pham . '"> ' . $sanPham->ten_san_pham . ' </a></h3>';
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
                                $sanPhamArr = $objSanPham->xemSanPhamTheoLoai($conn, 1, 4);
                                foreach ($sanPhamArr as $sanPham) {
                                    echo "<div class='col-12 col-md-3'>";
                                    echo "<div class='card card-product'>";
                                    echo "<div class='card-product-image'>";
                                    echo '<img src="data:image/jpeg;base64,' . $sanPham->anh_san_pham . '" alt="...">';
                                    echo "</div>";
                                    echo "<div class='card-product-image-info'>";
                                    echo '<h3><a href="chi-tiet-san-pham.php?id_san_pham=' . $sanPham->ma_san_pham . '"> ' . $sanPham->ten_san_pham . ' </a></h3>';
                                    echo "<span>" . $sanPham->gia_ban . "đ</span>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                ?>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel2" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel2" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>