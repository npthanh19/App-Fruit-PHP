<?php

class VaiTro
{
    public $id_vai_tro;
    public $ten_vai_tro;

     public function themVaiTro($conn, $ten_vai_tro, $id_tai_khoan, $chucNang)
    {
        $message = "Đã có vai trò có tên là $ten_vai_tro";

        $checkQuery = "SELECT * FROM vai_tro WHERE ten_vai_tro = '$ten_vai_tro'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $sql = "INSERT INTO vai_tro (ten_vai_tro) VALUES ('$ten_vai_tro')";

           if (mysqli_query($conn, $sql)) {
            $message =  "Thêm voucher thành công!";

            $vaiTroId = mysqli_insert_id($conn);

            foreach ($chucNang as $ten_vai_tro) {
                $id_chi_tiet_vai_tro = rand();

                $sqlChiTiet = "INSERT INTO chi_tiet_vai_tro (id_chi_tiet_vai_tro, id_tai_khoan, id_vai_tro, chuc_nang) 
                                VALUES ('$id_chi_tiet_vai_tro', '$id_tai_khoan','$vaiTroId', '$ten_vai_tro')";

                mysqli_query($conn, $sqlChiTiet);
            }

            return $message;
        } else {
            $message = "Thêm voucher thất bại!";
            return $message;
        }
        }
    }

    public function xoaVaiTro($conn, $id_vai_tro)
    {
        $message = "Xóa vai trò thành công!";
        $sqlChiTiet = "DELETE FROM chi_tiet_vai_tro WHERE id_vai_tro = '$id_vai_tro'";

        if (mysqli_query($conn, $sqlChiTiet)) {
        $sql = "DELETE FROM vai_tro WHERE id_vai_tro = '$id_vai_tro'";
        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            $message = "Xóa voucher thất bại!";
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
    }
}

    public function layVaiTro($conn)
{
    $sql = "SELECT * FROM vai_tro";
    $result = mysqli_query($conn, $sql);

    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $idVaiTro = $row['id_vai_tro'];
            $sqlChiTiet = "SELECT chuc_nang FROM chi_tiet_vai_tro WHERE id_vai_tro = $idVaiTro";
            $resultChiTiet = mysqli_query($conn, $sqlChiTiet);

            $chucNang = array();
            while ($rowChiTiet = mysqli_fetch_assoc($resultChiTiet)) {
                $chucNang[] = $rowChiTiet['chuc_nang'];
            }

            $row['chuc_nang'] = $chucNang;

            $data[] = $row;
        }
    }
    return $data;
}


    public function suaVaiTro($conn, $id_vai_tro, $id_tai_khoan, $ten_vai_tro, $chucNang)
{
    $deleteChiTietQuery = "DELETE FROM chi_tiet_vai_tro WHERE id_vai_tro = '$id_vai_tro'";
    mysqli_query($conn, $deleteChiTietQuery);

    $sql = "UPDATE vai_tro SET ten_vai_tro = '$ten_vai_tro' WHERE id_vai_tro = $id_vai_tro";
    if (mysqli_query($conn, $sql)) {
        foreach ($chucNang as $ten_chuc_nang) {
            $id_chi_tiet_vai_tro = rand();
            $sqlChiTiet = "INSERT INTO chi_tiet_vai_tro (id_chi_tiet_vai_tro, id_tai_khoan, id_vai_tro, chuc_nang) 
                            VALUES ('$id_chi_tiet_vai_tro', '$id_tai_khoan', '$id_vai_tro', '$ten_chuc_nang')";
            mysqli_query($conn, $sqlChiTiet);
        }

        $message = "Chỉnh sửa vai trò thành công!";
        echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
    } else {
        $message = "Chỉnh sửa vai trò thất bại!";
        echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
    }
}


    public function timVaiTro($conn, $searchTerm)
    {
        $query = "SELECT * FROM vai_tro WHERE ten_vai_tro LIKE '%$searchTerm%'";
        $result = mysqli_query($conn, $query);
        $vaiTroArr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $id_vai_tro = $row['id_vai_tro'];
            $ten_vai_tro = $row['ten_vai_tro'];
            $vaiTro = array(
                'id_vai_tro' => $id_vai_tro,
                'ten_vai_tro' => $ten_vai_tro
            );
            $vaiTroArr[] = $vaiTro;
        }
        return $vaiTroArr;
    }
}