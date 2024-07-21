<?php
include('TaiKhoan.php');

class KhachHang extends TaiKhoan {
    public function dangKi($conn)
    {
        $id_tai_khoan = time();
        $ten_tai_khoan = $this->ten_tai_khoan;
        $tai_khoan = $this->tai_khoan;
        $mat_khau = $this->mat_khau;
        $email = $this->email;
        $so_dien_thoai = $this->so_dien_thoai;
        $loai_tai_khoan = "khachhang";

        $sql_check = "SELECT * FROM tai_khoan WHERE ten_tai_khoan = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $ten_tai_khoan);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            echo "<div class='container' style='margin-top: 20px;'><i class='fa-solid fa-circle-exclamation' style='color: red; margin-right: 5px'></i><span>Tên tài khoản đã tồn tại</span></div>";
        } else {
            $sql_insert = "INSERT INTO tai_khoan (id_tai_khoan, ten_tai_khoan, tai_khoan, mat_khau, email, so_dien_thoai, loai_tai_khoan) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $sql_insert); 

            mysqli_stmt_bind_param($stmt_insert, "sssssss", $id_tai_khoan, $ten_tai_khoan, $tai_khoan, $mat_khau, $email, $so_dien_thoai, $loai_tai_khoan);

            if (mysqli_stmt_execute($stmt_insert)) {
                $ngay_tao_gio_hang = date("Y-m-d H:i:s");
                $sql_gio_hang = "INSERT INTO gio_hang (id_nguoi_dung, ngay_tao) VALUES (?, ?)";
                $stmt_gio_hang = mysqli_prepare($conn, $sql_gio_hang);
                mysqli_stmt_bind_param($stmt_gio_hang, "is", $id_tai_khoan, $ngay_tao_gio_hang);
                mysqli_stmt_execute($stmt_gio_hang);

                echo "<div class='container' style='margin-top: 20px;'><i class='fa-sharp fa-regular fa-circle-check' style='color: #22BB33; margin-right: 5px'></i><span>Đăng ký tài khoản thành công</span></div>";
            } else {
                echo "<div class='container' style='margin-top: 20px;'><i class='fa-solid fa-circle-exclamation' style='color: red; margin-right: 5px'></i><span>Đăng ký tài khoản không thành công</span></div>";
                echo mysqli_error($conn); 
            }
        }
    }
}
?>