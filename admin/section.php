<?php
ob_start();
if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 'tongquan';
}
?>

<div class="section-content">
    <div class="header">
        <button class="btn btn-primary btn-menu"><i class="fa-solid fa-bars"></i></button>
        <h4> <?php echo $pages[$page][0] ?> </h4>
        <?php include('./section/account.php') ?>
    </div>
    <hr />

    <?php
    if ($page == 'loaisp') {
        include('./section/loaisp.php');
    }
    if ($page == 'danhmuc') {
        include('./section/danhmuc.php');
    }
    if ($page == 'nhacungcap') {
        include('./section/nhacungcap.php');
    }
    if ($page == 'nhanvien') {
        include('./section/nhanvien.php');
    }
    if ($page == 'khachhang') {
        include('./section/khachhang.php');
    }
    if ($page == 'sanpham') {
        include('./section/sanpham.php');
    }
    if ($page == 'nhapkho') {
        include('./section/nhapkho.php');
    }
    if ($page == 'xuatkho') {
        include('./section/xuatkho.php');
    }
    if ($page == 'tonkho') {
        include('./section/tonkho.php');
    }
    if ($page == 'tongquan') {
        include('./section/tongquan.php');
    }
    if ($page == 'donhang') {
        include('./section/donhang.php');
    }
    if ($page == 'voucher') {
        include('./section/voucher.php');
    } 
    if ($page == 'phieunhaphang') {
        include('./section/phieunhaphang.php');
    }
    if ($page == 'donhangv2') {
        include('./section/donhangv2.php');
    }
    if ($page == 'chitietdonhangtaiquay') {
        include('./section/chitietdonhangtaiquay.php');
    }
    if ($page == 'danhmucncc') {
        include('./section/danhmucncc.php');
    }
    if ($page == 'chitietdonhangonline') {
        include('./section/chitietdonhangonline.php');
    }
    if ($page == 'donvitinh') {
        include('./section/donvitinh.php');
    }
    if ($page == 'suavoucher') {
        include('./section/suavoucher.php');
    }
    if ($page == 'suaphieunhaphang') {
        include('./section/suaphieunhaphang.php');
    }
    if ($page == 'vaitro') {
        include('./section/vaitro.php');
    }
    if ($page == 'baocaodoanhthu') {
        include('./section/baocaodoanhthu.php');
    }
    if ($page == 'baocaodonhang') {
        include('./section/baocaodonhang.php');
    }
    if ($page == 'baocaokhachhang') {
        include('./section/baocaokhachhang.php');
    }
    if ($page == 'baocaonhaphang') {
        include('./section/baocaonhaphang.php');
    }
    if ($page == 'baocaosanpham') {
        include('./section/baocaosanpham.php');
    }
    if ($page == 'lichsuhoatdong') {
        include('./section/lichsuhoatdong.php');
    }
    if ($page == 'chitietphieunhaphang') {
        include('./section/chitietphieunhaphang.php');
    }
    if ($page == 'themsanpham') {
        include('./section/themsanpham.php');
    }
    if ($page == 'suasanpham') {
        include('./section/suasanpham.php');
    }else {
        include('./section/home.php');
    }
    ?>
</div>