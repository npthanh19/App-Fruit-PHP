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
<?php
require '../config/database.php';
require '../classes/Voucher.php';
require '../classes/LichSuHoatDong.php';
$objLSHD = new LichSuHoatDong();

$obj = new Voucher();

$id_voucher = "";
$ma_voucher = "";
$gia_tri_don_hang_ap_dung = "";
$gia_tri = "";
$phan_tram_giam_gia = "";
$ngay_bat_dau = "";
$ngay_ket_thuc = "";
$so_luong_giam_gia = "";
$mo_ta = "";
$selected_products = array();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_voucher = $_GET['id'];
    $voucherData = $obj->layVoucherTheoId($conn, $id_voucher);
    if ($voucherData) {
        $ma_voucher = isset($voucherData['ma_voucher']) ? $voucherData['ma_voucher'] : "";
        $gia_tri_don_hang_ap_dung = isset($voucherData['gia_tri_don_hang_ap_dung']) ? $voucherData['gia_tri_don_hang_ap_dung'] : "";
        $gia_tri = isset($voucherData['gia_tri']) ? $voucherData['gia_tri'] : "";
        $phan_tram_giam_gia = isset($voucherData['phan_tram_giam_gia']) ? $voucherData['phan_tram_giam_gia'] : "";
        $ngay_bat_dau = isset($voucherData['ngay_bat_dau']) ? $voucherData['ngay_bat_dau'] : "";
        $ngay_ket_thuc = isset($voucherData['ngay_ket_thuc']) ? $voucherData['ngay_ket_thuc'] : "";
        $so_luong_giam_gia = isset($voucherData['so_luong_giam_gia']) ? $voucherData['so_luong_giam_gia'] : "";
        $mo_ta = isset($voucherData['mo_ta']) ? $voucherData['mo_ta'] : "";
        $loai_voucher = isset($voucherData['loai_voucher']) ? $voucherData['loai_voucher'] : "";
        $selected_products = isset($voucherData['chi_tiet_san_pham']) ? $voucherData['chi_tiet_san_pham'] : array();
    } else {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
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
<form method="POST" action="handle/sua_voucher.php">
    <input type="hidden" name="id_voucher" value="<?php echo $id_voucher; ?>">
    <div class="mb-3">
        <label for="ma_voucher" class="form-label">Mã voucher</label>
        <input type="text" class="form-control" id="ma_voucher" name="ma_voucher" value="<?php echo $ma_voucher; ?>"
            required>
    </div>
    <div class="mb-3">
        <label for="loai_voucher" class="form-label">Loại voucher</label>
        <select class="form-select" id="loai_voucher" name="loai_voucher" required>
            <option value="Giảm giá phần trăm" <?php echo ($loai_voucher == 'Giảm giá phần trăm') ? 'selected' : ''; ?>>
                Giảm giá theo phần trăm
            </option>
            <option value="Giảm giá trực tiếp" <?php echo ($loai_voucher == 'Giảm giá trực tiếp') ? 'selected' : ''; ?>>
                Giảm giá trực tiếp theo số tiền
            </option>
        </select>
    </div>

    <div class="mb-3">
        <label for="san_pham_select_sua" class="form-label">Chọn sản phẩm</label>
        <select class="form-select" id="san_pham_select_sua">
            <option value="">Chọn sản phẩm</option>
            <?php foreach ($products as $product) { ?>
            <option value="<?php echo $product['ma_san_pham']; ?>">
                <?php echo $product['ten_san_pham']; ?>
            </option>
            <?php } ?>
        </select>
    </div>
    <button type="button" id="them_san_pham_btn_sua" class="btn btn-primary">Thêm</button>
    <button type="button" id="them_tat_ca_btn_sua" class="btn btn-secondary">Thêm Tất Cả</button>
    <button type="button" id="xoa_tat_ca_btn_sua" class="btn btn-danger">Xóa Tất Cả</button>
    <div class="mb-3">
        <label for="selected_products_sua" class="form-label">Sản phẩm đã chọn</label>
        <ul id="selected_products_sua" class="list-group">
            <?php foreach ($selected_products as $san_pham) { ?>
            <li class="list-group-item" data-id="<?php echo $san_pham['id']; ?>">
                <?php echo $san_pham['ten_san_pham']; ?>
                <input type="hidden" name="chi_tiet_san_pham_sua[]" value="<?php echo $san_pham['id']; ?>">
                <button type='button' class='btn btn-danger btn-sm ms-2'>Xóa</button>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="mb-3">
        <label for="gia_tri_don_hang_ap_dung" class="form-label">Giá trị đơn hàng áp
            dụng</label>
        <input type="text" class="form-control" id="gia_tri_don_hang_ap_dung" name="gia_tri_don_hang_ap_dung"
            value="<?php echo $gia_tri_don_hang_ap_dung ?>" required>
    </div>
    <div class="mb-3">
        <label for="gia_tri" class="form-label">Giá trị</label>
        <input type="text" class="form-control" id="gia_tri" name="gia_tri" value="<?php echo $gia_tri; ?>" required>
    </div>
    <div class="mb-3">
        <label for="phan_tram_giam_gia" class="form-label">Phần trăm giảm giá</label>
        <input type="text" class="form-control" id="phan_tram_giam_gia" name="phan_tram_giam_gia"
            value="<?php echo $phan_tram_giam_gia; ?>" required>
    </div>
    <div class="mb-3">
        <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
        <input type="date" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau"
            value="<?php echo $ngay_bat_dau; ?>" required>
    </div>
    <div class="mb-3">
        <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
        <input type="date" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc"
            value="<?php echo $ngay_ket_thuc; ?>" required>
    </div>
    <div class="mb-3">
        <label for="so_luong_giam_gia" class="form-label">Số lượng giảm giá</label>
        <input type="text" class="form-control" id="so_luong_giam_gia" name="so_luong_giam_gia"
            value="<?php echo $so_luong_giam_gia; ?>" required>
    </div>
    <div class="mb-3">
        <label for="mo_ta" class="form-label">Mô tả</label>
        <textarea class="form-control" id="mo_ta" name="mo_ta" required><?php echo $mo_ta; ?></textarea>
    </div>
    <button type="btn" id="luuButton" name="suaVoucher" class="btn btn-primary">Lưu</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var selectedProducts = [];
    $("#selected_products_sua li").each(function() {
        var productId = $(this).data("id");
        selectedProducts.push(productId.toString());
    });

    $("#them_san_pham_btn_sua").click(function() {
        var selectedProduct = $("#san_pham_select_sua").val();
        if (selectedProduct) {
            if (selectedProducts.indexOf(selectedProduct) === -1) {
                selectedProducts.push(selectedProduct);
                updateSelectedProducts();
            }
        }
    });

    $("#them_tat_ca_btn_sua").click(function() {
        $("#san_pham_select_sua option").each(function() {
            var selectedProduct = $(this).val();
            if (selectedProduct && selectedProducts.indexOf(selectedProduct) === -1) {
                selectedProducts.push(selectedProduct);
            }
        });
        updateSelectedProducts();
    });

    $("#xoa_tat_ca_btn_sua").click(function() {
        selectedProducts = [];
        updateSelectedProducts();
    });

    $("#selected_products_sua").on("click", ".btn-danger", function() {
        var listItem = $(this).closest("li");
        var removedProductId = listItem.data("id");
        var removedProductIndex = selectedProducts.indexOf(removedProductId.toString());

        console.log(typeof selectedProducts[0])
        if (removedProductIndex !== -1) {
            selectedProducts.splice(removedProductIndex, 1);
            updateSelectedProducts();
        }
    });


    function updateSelectedProducts() {
        var selectedProductsList = $("#selected_products_sua");
        selectedProductsList.empty();

        selectedProducts.forEach(function(productId) {
            var productText = $("#san_pham_select_sua option[value='" + productId + "']").text();
            var listItem = $("<li class='list-group-item'></li>");
            var hiddenInput = $("<input type='hidden' name='chi_tiet_san_pham_sua[]' value='" +
                productId +
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

        $("#chi_tiet_voucher_sua").val(selectedProducts.join(","));
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