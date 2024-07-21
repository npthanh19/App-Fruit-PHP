<?php
ob_start();
$baseUrl = $_SERVER['PHP_SELF'];
$pages = array(
    'home' => array('Trang Chủ', './section/home.php'),
    'loaisp' => array('Loại sản phẩm', './section/loaisp.php'),
    'danhmuc' => array('Danh mục', './section/danhmuc.php'),
    'nhacungcap' => array('Nhà cung cấp', './section/nhacungcap.php'),
    'nhanvien' => array('Nhân viên', './section/nhanvien.php'),
    'khachhang' => array('Khách hàng', './section/khachhang.php'),
    'sanpham' => array('Sản phẩm', './section/sanpham.php'),
    'nhapkho' => array('Nhập kho', './section/nhapkho.php'),
    'xuatkho' => array('Xuất kho', './section/xuatkho.php'),
    'tonkho' => array('Tồn kho', './section/tonkho.php'),
    'tongquan' => array('Tổng quan', './section/tongquan.php'),
    'donhang' => array('Đơn hàng', './section/donhang.php'),
    'voucher' => array('Voucher', './section/voucher.php'),
    'phieunhaphang' => array('Phiếu nhập hàng', './section/phieunhaphang.php'),
    'donhangv2' => array('Đơn hàng tại cửa hàng', './section/donhangv2.php'),
    'chitietdonhangtaiquay' => array('Chi tiết đơn hàng tại quầy', './section/chitietdonhangtaiquay.php'),
    'chitietdonhangonline' => array('Chi tiết đơn hàng online', './section/chitietdonhangonline.php'),
    'danhmucncc' => array('Danh mục nhà cung cấp', './section/danhmucncc.php'),
    'donvitinh' => array('Đơn vị tính', './section/donvitinh.php'),
    'suavoucher' => array('Sửa voucher', './section/suavoucher.php'),
    'suaphieunhaphang' => array('Sửa phiếu nhập hàng', './section/suaphieunhaphang.php'),
    'vaitro' => array('Vai trò', './section/vaitro.php'),
    'baocaodoanhthu' => array('Báo cáo doanh thu', './section/baocaodoanhthu.php'),
    'baocaodonhang' => array('Báo cáo đơn hàng', './section/baocaodonhang.php'),
    'baocaokhachhang' => array('Báo cáo khách hàng', './section/baocaokhachhang.php'),
    'baocaonhaphang' => array('Báo cáo nhập hàng', './section/baocaonhaphang.php'),
    'baocaosanpham' => array('Báo cáo sản phẩm', './section/baocaosanpham.php'),
    'lichsuhoatdong' => array('Lịch sử hoạt động', './section/lichsuhoatdong.php'),
    'chitietphieunhaphang' => array('Chi tiết phiếu nhập hàng', './section/chitietphieunhaphang.php'),
    'themsanpham' => array('Thêm sản phẩm', './section/themsanpham.php'),
    'suasanpham' => array('Sửa sản phẩm', './section/suasanpham.php'),
);
?>
<?php
$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$queryString = parse_url($url, PHP_URL_QUERY);
if (!empty($queryString)) {
    parse_str($queryString, $params);
    if (isset($params['p'])) {
        $page = $params['p'];
    }
}
?>
<?php
include('../config/database.php');
$username = $_SESSION['username'];
$query = "SELECT loai_tai_khoan FROM tai_khoan WHERE ten_tai_khoan = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$role = $row['loai_tai_khoan'];
?>

<?php
$trang_thai = "Chờ xác nhận";
$sql = "SELECT COUNT(*) AS count FROM don_dat_hang WHERE trang_thai = '$trang_thai'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$_SESSION['orderCount'] = $row['count'];
?>

<?php 
if ($role === 'admin') {
    ?>
<nav class="sidebar card py-2 mb-4">
    <h3 class="dashboard-title">FRUIT HOME</h3>
    <ul class="nav flex-column" id="nav_accordion">
        <li class="nav-item <?php if ($page === 'tongquan') echo 'active--nav' ?>">
            <a class="nav-link" href="<?php echo "$baseUrl?p=tongquan" ?>"><i class="fa-solid fa-chart-pie"></i> Tổng
                quan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-regular fa-lemon"></i> Quản lí hàng hóa <i
                    class="fa-solid fa-chevron-down"></i></a>
            <ul
                class="submenu collapse <?php if ($page === 'danhmuc' || $page === 'sanpham' || $page === 'donvitinh') echo 'show' ?>">
                <li class="<?php if ($page === 'danhmuc') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=danhmuc" ?>">Quản lí danh mục</a>
                </li>
                <li class="<?php if ($page === 'donvitinh') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=donvitinh" ?>">Quản lí đơn vị tính</a>
                </li>
                <li class="<?php if ($page === 'sanpham') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=sanpham" ?>">Quản lí trái cây</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-user"></i> Quản lí tài khoản <i
                    class="fa-solid fa-chevron-down"></i></a>
            <ul
                class="submenu collapse <?php if ($page === 'nhanvien' || $page === 'khachhang' || $page === 'vaitro') echo 'show' ?>">
                <li class="<?php if ($page === 'vaitro') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=vaitro" ?>">Vai trò</a>
                </li>
                <li class="<?php if ($page === 'nhanvien') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=nhanvien" ?>">Nhân viên</a>
                </li>
                <li class="<?php if ($page === 'khachhang') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=khachhang" ?>">Khách hàng</a>
                </li>
            </ul>
        </li>
        <li class="nav-item <?php if ($page === 'tonkho') echo 'active--nav' ?>">
            <a class="nav-link" href="<?php echo "$baseUrl?p=tonkho" ?>"><i class="fa-solid fa-store"></i> Quản lí tồn
                kho</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-box-open"></i> Quản lí đơn hàng
                <i class="fa-solid fa-chevron-down"></i>
            </a>
            <ul class="submenu collapse <?php if ($page === 'donhangv2' || $page === 'donhang') echo 'show' ?>">
                <li class="<?php if ($page === 'donhangv2') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=donhangv2" ?>">Tại cửa hàng</a>
                </li>
                <li class="<?php if ($page === 'donhang') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=donhang" ?>"> Đơn hàng online
                        <button type="button" class="btn bg-danger btn-notify-order">
                            <span class="badge badge-light"><?php echo $_SESSION['orderCount'] ?></span>
                        </button>
                    </a>

                </li>
            </ul>
        </li>
        <li class="nav-item <?php if ($page === 'voucher') echo 'active--nav' ?>">
            <a class="nav-link" href="<?php echo "$baseUrl?p=voucher" ?>"><i class="fa-solid fa-ticket"></i> Quản lí
                voucher</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-truck"></i> Quản lí nhập kho <i
                    class="fa-solid fa-chevron-down"></i></a>
            <ul
                class="submenu collapse <?php if ($page === 'danhmucncc' || $page === 'nhacungcap' || $page === 'phieunhaphang') echo 'show' ?>">
                <li class="<?php if ($page === 'danhmucncc') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=danhmucncc" ?>"> Danh mục NCC</a>
                </li>
                <li class="<?php if ($page === 'nhacungcap') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=nhacungcap" ?>"> Nhà cung cấp</a>
                </li>
                <li class="<?php if ($page === 'phieunhaphang') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=phieunhaphang" ?>"> Tạo phiếu nhập hàng</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-flag"></i> Thống kê và báo cáo <i
                    class="fa-solid fa-chevron-down"></i></a>
            <ul
                class="submenu collapse <?php if ($page === 'baocaodoanhthu' || $page === 'baocaodonhang' || $page === 'baocaokhachhang' || $page === 'baocaonhaphang' || $page === 'baocaosanpham') echo 'show' ?>">
                <li class="<?php if ($page === 'baocaodoanhthu') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=baocaodoanhthu" ?>"> Báo cáo doanh thu</a>
                </li>
                <li class="<?php if ($page === 'baocaodonhang') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=baocaodonhang" ?>"> Báo cáo đơn hàng</a>
                </li>
                <li class="<?php if ($page === 'baocaokhachhang') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=baocaokhachhang" ?>"> Báo cáo khách hàng</a>
                </li>
                <li class="<?php if ($page === 'baocaonhaphang') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=baocaonhaphang" ?>"> Báo cáo nhập hàng</a>
                </li>
                <li class="<?php if ($page === 'baocaosanpham') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=baocaosanpham" ?>"> Báo cáo sản phẩm</a>
                </li>
            </ul>
        </li>
        <li class="nav-item <?php if ($page === 'lichsuhoatdong') echo 'active--nav' ?>">
            <a class="nav-link" href="<?php echo "$baseUrl?p=lichsuhoatdong" ?>"><i
                    class="fa-solid fa-clock-rotate-left"></i>Lịch
                sử hoạt động</a>
        </li>
    </ul>
</nav>
<?php
} else {
    ?>
<nav class="sidebar card py-2 mb-4">
    <h3 class="dashboard-title">FRUIT HOME</h3>
    <ul class="nav flex-column" id="nav_accordion">
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-regular fa-lemon"></i> Quản lí hàng hóa <i
                    class="fa-solid fa-chevron-down"></i></a>
            <ul
                class="submenu collapse <?php if ($page === 'danhmuc' || $page === 'sanpham' || $page === 'donvitinh') echo 'show' ?>">
                <li class="<?php if ($page === 'danhmuc') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=danhmuc" ?>">Quản lí danh mục</a>
                </li>
                <li class="<?php if ($page === 'donvitinh') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=donvitinh" ?>">Quản lí đơn vị tính</a>
                </li>
                <li class="<?php if ($page === 'sanpham') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=sanpham" ?>">Quản lí trái cây</a>
                </li>
            </ul>
        </li>
        <li class="nav-item <?php if ($page === 'tonkho') echo 'active--nav' ?>">
            <a class="nav-link" href="<?php echo "$baseUrl?p=tonkho" ?>"><i class="fa-solid fa-store"></i> Quản lí tồn
                kho</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-box-open"></i> Quản lí đơn hàng
                <i class="fa-solid fa-chevron-down"></i>
            </a>
            <ul class="submenu collapse <?php if ($page === 'donhangv2' || $page === 'donhang') echo 'show' ?>">
                <li class="<?php if ($page === 'donhangv2') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=donhangv2" ?>">Tại cửa hàng</a>
                </li>
                <li class="<?php if ($page === 'donhang') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=donhang" ?>"> Đơn hàng online
                        <button type="button" class="btn bg-danger btn-notify-order">
                            <span class="badge badge-light"><?php echo $_SESSION['orderCount'] ?></span>
                        </button>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-boxes-packing"></i> Quản lí nhập kho <i
                    class="fa-solid fa-chevron-down"></i></a>
            <ul
                class="submenu collapse <?php if ($page === 'danhmucncc' || $page === 'nhacungcap' || $page === 'phieunhaphang') echo 'show' ?>">
                <li class="<?php if ($page === 'danhmucncc') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=danhmucncc" ?>"> Danh mục NCC</a>
                </li>
                <li class="<?php if ($page === 'nhacungcap') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=nhacungcap" ?>"> Nhà cung cấp</a>
                </li>
                <li class="<?php if ($page === 'phieunhaphang') echo 'active--nav' ?>">
                    <a class="nav-link" href="<?php echo "$baseUrl?p=phieunhaphang" ?>"> Tạo phiếu nhập hàng</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<?php
}
?>