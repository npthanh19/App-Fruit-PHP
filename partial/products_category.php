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
                    <h4><a href="chi-tiet-san-pham.php?id_san_pham=<?php echo $sanPham->ma_san_pham; ?>">
                            <?php echo $sanPham->ten_san_pham; ?> </a></h4>
                    <span><?php echo $sanPham->gia_ban; ?>đ</span>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>