<?php

class TaiKhoan
{
    public $id_tai_khoan;
    public $ten_tai_khoan;
    public $tai_khoan;
    public $mat_khau;
    public $email;
    public $anh_san_pham;

    public $so_dien_thoai;
    public $loai_tai_khoan;

    public function dangNhap($conn, $username, $password)
    {
        $sql = "SELECT * FROM tai_khoan WHERE tai_khoan='$username' AND mat_khau='$password'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return false;
        }
    }

    public function dangXuat()
    {
        session_start();
        $_SESSION = array();
        session_destroy();
        setcookie('user', '', time() - 3600, '/');
        setcookie('session', '', time() - 3600);
        header('Location: index.php');
        exit;
    }
}