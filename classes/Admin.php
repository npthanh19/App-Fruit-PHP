<?php include('TaiKhoan.php') ?>


<?php class Admin extends TaiKhoan
{
    public $vai_tro;

    public function createTaiKhoan($conn, $ten_tai_khoan, $taiKhoan, $mat_khau, $email, $so_dien_thoai, $loai_tai_khoan, $vai_tro)
    {
        $message = "Tạo tài khoản thành công";
        $id_tai_khoan = time();

        $sql = "INSERT INTO tai_khoan (id_tai_khoan, ten_tai_khoan, tai_khoan, mat_khau, email, so_dien_thoai, loai_tai_khoan, vai_tro) 
            VALUES ('$id_tai_khoan', '$ten_tai_khoan','$taiKhoan','$mat_khau', '$email', '$so_dien_thoai', '$loai_tai_khoan', '$vai_tro')";
        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Tạo tài khoản thất bại";
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        }
    }

    /* xoá tài khoản */
    public function xoaTaiKhoan($conn, $id_tai_khoan)
    {
        $message = "Xóa tài khoản thành công";
        $sql = "DELETE FROM tai_khoan WHERE id_tai_khoan = $id_tai_khoan";
        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Xóa tài khoản thất bại";
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        }
    }

    public function lietKeTaiKhoan($conn)
    {
        $sql = "SELECT * FROM tai_khoan";
        $result = mysqli_query($conn, $sql);
        $taiKhoans = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $taiKhoan = new Admin();
                $taiKhoan->id_tai_khoan = $row["id_tai_khoan"];
                $taiKhoan->ten_tai_khoan = $row["ten_tai_khoan"];
                $taiKhoan->mat_khau = $row["mat_khau"];
                $taiKhoan->email = $row["email"];
                $taiKhoan->so_dien_thoai = $row["so_dien_thoai"];
                $taiKhoan->loai_tai_khoan = $row["loai_tai_khoan"];
                $taiKhoan->vai_tro = $row["vai_tro"];

                $taiKhoans[] = $taiKhoan;
            }
        }

        return $taiKhoans;
    }

    public function layTaiKhoanTheoRole($conn, $role)
    {
        $sql = "SELECT * FROM tai_khoan WHERE loai_tai_khoan = '$role'";
        $result = mysqli_query($conn, $sql);
        $taiKhoans = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $taiKhoan = new Admin();
                $taiKhoan->id_tai_khoan = $row["id_tai_khoan"];
                $taiKhoan->ten_tai_khoan = $row["ten_tai_khoan"];
                $taiKhoan->tai_khoan = $row["tai_khoan"];
                $taiKhoan->mat_khau = $row["mat_khau"];
                $taiKhoan->email = $row["email"];
                $taiKhoan->so_dien_thoai = $row["so_dien_thoai"];
                $taiKhoan->loai_tai_khoan = $row["loai_tai_khoan"];
                $taiKhoan->vai_tro = $row["vai_tro"];
                
                $taiKhoans[] = $taiKhoan;
            }
        }

        return $taiKhoans;
    }
}