<?php include('./partial/header.php'); ?>
<?php include('./classes/SanPham.php') ?>
<?php include('./config/database.php') ?>

<main>
    <div class="container">
        <div class="banner">
            <div class="row">
                <div class="col-4">
                    <?php include "./partial/products_category.php" ?>
                </div>
                <div class="col-8">
                    <?php include "./partial/carousel.php" ?>
                </div>
            </div>
        </div>
        <?php include("./partial/banner.php") ?>
        <?php include("./partial/featured_products_vn.php") ?>
        <?php include("./partial/featured_products_nn.php") ?>
        <div class="graphic">
            <div class="row">
                <div class="col-6">
                    <div class="graphic__item">
                        <img src="https://theme.hstatic.net/200000157781/1000920666/14/banner_coltab3_1.png?v=220"
                            alt="">
                    </div>
                </div>
                <div class="col-6">
                    <div class="graphic__item">
                        <img src="https://theme.hstatic.net/200000157781/1000920666/14/banner_coltab3_2.png?v=220"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
        <?php include "./partial/customer.php"?>
</main>
<script src="./public/js/main.js"></script>
<?php include('./partial/footer.php'); ?>