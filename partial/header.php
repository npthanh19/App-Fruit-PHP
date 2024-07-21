<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<?php
ob_start() ?>
<!DOCTYPE html>
<html lang="en">
<?php
$baseUrl = $_SERVER['PHP_SELF'];
$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$slug = basename(parse_url($url, PHP_URL_PATH));
$slug = pathinfo($slug, PATHINFO_FILENAME);
?>

<?php include('./config/database.php') ?>
<?php
include('./classes/GioHang.php');
$gioHang = new GioHang();

if (isset($_SESSION['id_tai_khoan'])) {
    $chi_tiet_gio_hang = $gioHang->layTatCaChiTietGioHang();
    $soLuongSanPham = count($chi_tiet_gio_hang);
} elseif (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $soLuongSanPham = count($_SESSION['cart']);
} else {
    $soLuongSanPham = 0;
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruit Home - Trái Cây Cần Thơ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="icon" type="image/x-icon" href="./public/images/logo.png">
    <link rel="stylesheet" href="./public/css/reset.css">
    <link rel="stylesheet" href="./public/css/main.css">
    <link rel="stylesheet" href="./public/css/cart.css">
    <link rel="stylesheet" href="./public/css/contact.css">
    <link rel="stylesheet" href="./public/css/introduce.css">
    <link rel="stylesheet" href="./public/css/product.css">
    <link rel="stylesheet" href="./public/css/product_detail.css">
    <link rel="stylesheet" href="./public/css/payment.css">
    <link rel="stylesheet" href="./public/css/history.css">
</head>

<body>
    <div class="wrap">
        <header class="header">
            <div class="header__topbar">
                <div class="container">
                    <div class="topbar__contact">
                        <i class="fa-solid fa-phone"></i>
                        <span>Hotline: 0909131418 - 0798531637</span>
                    </div>
                    <div class="topbar__address">
                        <span>Địa chỉ: 369 Nguyễn Văn Cừ Nối Dài, An Khánh, Ninh Kiều, Cần Thơ</span>
                    </div>
                    <div class="topbar__user">
                        <?php
                        if (isset($_COOKIE['user'])) {
                            $account = json_decode($_COOKIE['user'], true);
                            echo '<i class="fa-regular fa-user"></i>';
                            echo '<div class="topbar__user__info">';
                            echo '<a href="./tai-khoan.php">';
                            echo 'Xin chào ' . $account['username'] .' '. '!';
                            echo '</a>';
                            echo " ";
                            echo '<a href="dang-xuat.php">Đăng xuất</a>';
                            echo '</div>';
                        } else {
                            // Chưa đăng nhập, hiển thị liên kết đăng nhập và đăng ký
                            echo '<i class="fa-regular fa-user"></i>';
                            echo '<div class="topbar__user__choose">';
                            echo '<span data-bs-toggle="modal" data-bs-target="#staticBackdrop">Đăng nhập</span>';
                            echo '<span> hoặc </span>';
                            echo '<span data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Đăng kí</span>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="header__content">
                <div class="container">
                    <div class="header__logo">
                        <h3>FRUIT HOME</h3>
                    </div>
                    <div class="header__info">
                        <div class="header__info__item">
                            <img src="https://theme.hstatic.net/200000157781/1000920666/14/policy1.png?v=220" alt="">
                            <div class="header__info__item__desc">
                                <h3>Miễn phí vận chuyển</h3>
                                <span>Đơn hàng từ 500k</span>
                            </div>
                        </div>
                        <div class="header__info__item">
                            <img src="https://theme.hstatic.net/200000157781/1000920666/14/policy2.png?v=220" alt="">
                            <div class="header__info__item__desc">
                                <h3>Hỗ trợ 24/7</h3>
                                <span>Hotline: 0909131418</span>
                            </div>
                        </div>
                        <div class="header__info__item">
                            <img src="https://theme.hstatic.net/200000157781/1000920666/14/policy3.png?v=220" alt="">
                            <div class="header__info__item__desc">
                                <h3>Giờ làm việc</h3>
                                <span>T2 - Chủ nhật (7:00-19:00)</span>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary position-relative" href="./gio-hang.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Giỏ hàng
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <span class="badge-number"><?php echo$soLuongSanPham ?></span>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                </div>
            </div>
            <div class="header__nav">
                <div class="container">
                    <div class="header__nav__list">
                        <ul>
                            <li <?php if ($slug == 'shoptraicay' || $slug == 'index' || $slug == '') {
                                    echo 'class="active"';
                                } ?>><a href="./">Trang
                                    chủ</a></li>
                            <li <?php if ($slug == 'san-pham' || $slug == 'search') {
                                    echo 'class="active"';
                                } ?>>
                                <a href="./san-pham.php">Sản phẩm</a>
                            </li>
                            <li <?php if ($slug == 'gioi-thieu') {
                                    echo 'class="active"';
                                } ?>><a href="./gioi-thieu.php">Giới
                                    thiệu</a></li>
                            <li <?php if ($slug == 'lien-he') {
                                    echo 'class="active"';
                                } ?>><a href="./lien-he.php">Liên
                                    hệ</a></li>
                        </ul>
                    </div>
                    <div class="header__nav__search">
                        <form action="tim-kiem.php">
                            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <!-- modal login -->
        <?php
        include('./classes/KhachHang.php');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["form_login"]) && $_POST["form_login"] == "true") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (empty($username) || empty($password)) {
                echo "Vui lòng nhập tên người dùng và mật khẩu.";
            } else {
                $taiKhoan = new KhachHang();
                $result = $taiKhoan->dangNhap($conn, $username, $password);

                if ($result) {
                    $_SESSION['id_tai_khoan'] = $result['id_tai_khoan'];
                    $_SESSION['ten_tai_khoan'] = $result['ten_tai_khoan'];
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['so_dien_thoai'] = $result['so_dien_thoai'];
                    $_SESSION['loai_tai_khoan'] = $result['loai_tai_khoan'];


                    $account = array(
                        "email" => $result['email'],
                        "id" => $result['id_tai_khoan'],
                        "phone" => $result['so_dien_thoai'],
                        "username" => $result['ten_tai_khoan']
                    );

                    $jsonAccount = json_encode($account);
                    setcookie("user", $jsonAccount, time() + (86400 * 30), "/");
                    header("Location: index.php");
                } else {
                    echo "<div class='container' style='margin-top: 20px;'><i class='fa-solid fa-circle-exclamation' style='color: red; margin-right: 5px'></i><span>Tên tài khoản hoặc mật khẩu không đúng.</span></div>";
                }

                mysqli_close($conn);
            }
        }
        ?>
        <?php include('./partial/formLogin.php') ?>
        <!-- modal register -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form_register"]) && $_POST["form_register"] == "true") {
            $taiKhoan = new KhachHang();
            $taiKhoan->ten_tai_khoan = $_POST["ten_tai_khoan"];
            $taiKhoan->tai_khoan = $_POST["tai_khoan"];
            $taiKhoan->mat_khau = $_POST["mat_khau"];
            $taiKhoan->email = $_POST["email"];
            $taiKhoan->so_dien_thoai = $_POST["so_dien_thoai"];

            $taiKhoan->dangKi($conn);
            mysqli_close($conn);
        }
        ?>
        <?php include('./partial/formRegister.php') ?>
        <?php
        ob_end_flush();
        ?>