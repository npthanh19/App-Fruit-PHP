<?php require "../config/database.php" ?>
<?php
require '../classes/Voucher.php';
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();
$obj = new Voucher();

if (isset($_POST['themVoucher'])) {
    $ma_voucher = $_POST['ma_voucher'];
    $loai_voucher = $_POST['loai_voucher'];
    $gia_tri_don_hang_ap_dung = $_POST['gia_tri_don_hang_ap_dung'];
    $gia_tri = $_POST['gia_tri'];
    $phan_tram_giam_gia = $_POST['phan_tram_giam_gia'];
    $ngay_bat_dau = $_POST['ngay_bat_dau'];
    $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
    $mo_ta = $_POST['mo_ta'];
    $so_luong_giam_gia = $_POST['so_luong_giam_gia'];
    $ngay_tao = date('Y-m-d');
    $ngay_cap_nhat = date('Y-m-d');
    $hieu_luc = 1;

    $chi_tiet_san_pham = $_POST['chi_tiet_san_pham'];
    try {
        $obj->themVoucher($conn, $ma_voucher, $loai_voucher, $gia_tri_don_hang_ap_dung, $gia_tri, $phan_tram_giam_gia, $ngay_bat_dau, $ngay_ket_thuc, $mo_ta, $so_luong_giam_gia, $ngay_tao, $ngay_cap_nhat, $hieu_luc, $chi_tiet_san_pham);
        $objLSHD->taoLichSuHoatDong($conn, $_SESSION['id_tai_khoan'], "Thêm voucher " . $ma_voucher);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    } catch (Exception $e) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo $e->getMessage();
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}

?>
<?php
if (isset($_GET['delete_error']) && $_GET['delete_error'] === 'true') {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo 'Không được phép xóa do voucher đang tồn tại ở dữ liệu khác';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

if (isset($_GET['delete_success']) && $_GET['delete_success'] === 'true') {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo 'Đã xóa voucher thành công.';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>
<style>
#selected_products {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    flex-direction: row !important;
}

#selected_products li {
    flex: 1;
    list-style: none;
    padding: 5px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: fit-content;
    white-space: nowrap;
}

#selected_products_sua {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    flex-direction: row !important;
}

#selected_products_sua li {
    flex: 1;
    list-style: none;
    padding: 5px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: fit-content !important;
    white-space: nowrap;
}
</style>
<div class="head-page">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#themVoucherModal">Thêm voucher</button>
    <form method="post" action="">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="search_query">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <input type="hidden" name="search" />
    </form>
</div>
<table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center bg-primary text-light">Mã voucher</th>
            <th scope="col" class="text-center bg-primary text-light">Ngày bắt đầu</th>
            <th scope="col" class="text-center bg-primary text-light">Ngày kết thúc</th>
            <th scope="col" class="text-center bg-primary text-light">Số lượng giảm giá</th>
            <th scope="col" colspan="3" class="text-center bg-primary text-light">Cập nhật</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $products = array();
        $query = "SELECT * FROM san_pham";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
        }
        ?>
        <?php
        $data = $obj->layDanhSachVoucher($conn);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["search"])) {
            $searchQuery = $_POST['search_query'];
            $data = $obj->timVoucher($searchQuery);
        }

        foreach ($data as $row) {
            echo '<tr>';
            echo '<td class="text-center">' . $row['ma_voucher'] . '</td>';
            echo '<td class="text-center">' . $row['ngay_bat_dau'] . '</td>';
            echo '<td class="text-center">' . $row['ngay_ket_thuc'] . '</td>';
            echo '<td class="text-center">' . $row['so_luong_giam_gia'] . '</td>';
            echo '<td class="text-center edit"><a href="./index.php?p=suavoucher&id=' . $row['id_voucher'] . '">Sửa</a></td>';
            echo '<td class="text-center remove"><a href="handle/xoa_voucher.php?id_voucher=' . $row['id_voucher'] . '">Xóa</a></td>';
            echo '</tr>';

            /* include "./partial/modalSuaVoucher.php"; */

        }
        ?>
    </tbody>
</table>
<div class="modal fade" id="themVoucherModal" tabindex="-1" aria-labelledby="themVoucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="themVoucherModalLabel">Thêm voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="ma_voucher" class="form-label">Mã voucher</label>
                        <input type="text" class="form-control" id="ma_voucher" name="ma_voucher" required>
                    </div>
                    <div class="mb-3">
                        <label for="loai_voucher" class="form-label">Loại voucher</label>
                        <select class="form-select" id="loai_voucher" name="loai_voucher" required>
                            <option value="Giảm giá phần trăm">Giảm giá theo phần trăm</option>
                            <option value="Giảm giá trực tiếp">Giảm giá trực tiếp theo số tiền</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="gia_tri_don_hang_ap_dung" class="form-label">Giá trị đơn hàng áp dụng</label>
                        <input type="text" class="form-control" id="gia_tri_don_hang_ap_dung"
                            name="gia_tri_don_hang_ap_dung" required>
                    </div>
                    <div class="mb-3">
                        <label for="gia_tri" class="form-label">Giá trị</label>
                        <input type="text" class="form-control" id="gia_tri" name="gia_tri">
                    </div>
                    <div class="mb-3">
                        <label for="phan_tram_giam_gia" class="form-label">Phần trăm giảm giá</label>
                        <input type="text" class="form-control" id="phan_tram_giam_gia" name="phan_tram_giam_gia">
                    </div>
                    <div class="mb-3">
                        <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau" required>
                    </div>
                    <div class="mb-3">
                        <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
                        <input type="date" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc" required>
                    </div>
                    <div class="mb-3">
                        <label for="mo_ta" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="mo_ta" name="mo_ta" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="so_luong_giam_gia" class="form-label">Số lượng giảm giá</label>
                        <input type="text" class="form-control" id="so_luong_giam_gia" name="so_luong_giam_gia"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="san_pham_select" class="form-label">Chọn sản phẩm</label>
                        <select class="form-select" id="san_pham_select">
                            <option value="">Chọn sản phẩm</option>
                            <?php foreach ($products as $product) { ?>
                            <option value="<?php echo $product['ma_san_pham']; ?>">
                                <?php echo $product['ten_san_pham']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="button" id="them_san_pham_btn" class="btn btn-primary">Thêm</button>
                    <button type="button" id="them_tat_ca_btn" class="btn btn-secondary">Thêm Tất Cả</button>
                    <button type="button" id="xoa_tat_ca_btn" class="btn btn-danger">Xóa Tất Cả</button>
                    <div class="mb-3">
                        <label for="selected_products" class="form-label">Sản phẩm đã chọn</label>
                        <ul id="selected_products" class="list-group">

                        </ul>
                    </div>
                    <button type="submit" name="themVoucher" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var selectedProducts = [];

    $("#them_san_pham_btn").click(function() {
        var selectedProduct = $("#san_pham_select").val();
        if (selectedProduct) {
            if (selectedProducts.indexOf(selectedProduct) === -1) {
                selectedProducts.push(selectedProduct);
                updateSelectedProducts();
            }
        }
    });

    $("#them_tat_ca_btn").click(function() {
        $("#san_pham_select option").each(function() {
            var selectedProduct = $(this).val();
            if (selectedProduct && selectedProducts.indexOf(selectedProduct) === -1) {
                selectedProducts.push(selectedProduct);
            }
        });
        updateSelectedProducts();
    });


    $("#xoa_tat_ca_btn").click(function() {
        selectedProducts = [];
        updateSelectedProducts();
    });


    $("#selected_products").on("click", "li", function() {
        var removedProductText = $(this).text().trim();
        var removedProductId = selectedProducts.indexOf(removedProductText);
        if (removedProductId !== -1) {
            selectedProducts.splice(removedProductId, 1);
            updateSelectedProducts();
        }
    });



    function updateSelectedProducts() {
        var selectedProductsList = $("#selected_products");
        selectedProductsList.empty();

        selectedProducts.forEach(function(productId) {
            var productText = $("#san_pham_select option[value='" + productId + "']").text();
            var listItem = $("<li class='list-group-item'></li>");
            var hiddenInput = $("<input type='hidden' name='chi_tiet_san_pham[]' value='" + productId +
                "'>");
            listItem.append(hiddenInput);
            listItem.append(productText);
            listItem.attr("data-id", productId);
            var deleteButton = $(
                "<button type='button' class='btn btn-danger btn-sm ms-2'>Xóa</button>");


            deleteButton.click(function() {
                var removedProductId = listItem.data("id");
                var removedProductIndex = selectedProducts.indexOf(String(removedProductId));
                if (removedProductIndex !== -1) {
                    selectedProducts.splice(removedProductIndex,
                        1);
                    updateSelectedProducts();
                }
            });

            listItem.append(deleteButton);

            selectedProductsList.append(listItem);
        });

        $("#chi_tiet_voucher").val(selectedProducts.join(","));
    }


    function getKeyByValue(array, value) {
        for (var key in array) {
            if (array[key] === value) {
                return key;
            }
        }
        return null;
    }
});
</script>