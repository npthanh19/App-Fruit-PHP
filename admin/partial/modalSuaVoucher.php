<div class="modal fade" id="suaVoucherModal<?php echo $row['id_voucher']; ?>" tabindex="-1"
    aria-labelledby="suaVoucherModalLabel<?php echo $row['id_voucher']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suaVoucherModalLabel<?php echo $row['id_voucher']; ?>">Sửa voucher
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_voucher" value="<?php echo $row['id_voucher']; ?>">
                <div class="mb-3">
                    <label for="ma_voucher" class="form-label">Mã voucher</label>
                    <input type="text" class="form-control" id="ma_voucher" name="ma_voucher"
                        value="<?php echo $row['ma_voucher']; ?>" required>
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
                        <?php foreach ($row['chi_tiet_san_pham'] as $san_pham) { ?>
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
                    <input type="text" class="form-control" id="gia_tri_don_hang_ap_dung"
                        name="gia_tri_don_hang_ap_dung" value="<?php echo $row['gia_tri_don_hang_ap_dung']; ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="gia_tri" class="form-label">Giá trị</label>
                    <input type="text" class="form-control" id="gia_tri" name="gia_tri"
                        value="<?php echo $row['gia_tri']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phan_tram_giam_gia" class="form-label">Phần trăm giảm giá</label>
                    <input type="text" class="form-control" id="phan_tram_giam_gia" name="phan_tram_giam_gia"
                        value="<?php echo $row['phan_tram_giam_gia']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
                    <input type="date" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau"
                        value="<?php echo $row['ngay_bat_dau']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
                    <input type="date" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc"
                        value="<?php echo $row['ngay_ket_thuc']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="so_luong_giam_gia" class="form-label">Số lượng giảm giá</label>
                    <input type="text" class="form-control" id="so_luong_giam_gia" name="so_luong_giam_gia"
                        value="<?php echo $row['so_luong_giam_gia']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="mo_ta" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="mo_ta" name="mo_ta"
                        required><?php echo $row['mo_ta']; ?></textarea>
                </div>
                <button type="btn" id="luuButton" name="suaVoucher" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
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
<script>
$(document).ready(function() {
    var selectedProducts = [];
    $("#selected_products_sua li").each(function() {
        var productId = $(this).data("id");
        selectedProducts.push(productId.toString());
    });
    $("#luuButton").click(function() {
        var voucherData = {
            id_voucher: $("#id_voucher").val(),
            ma_voucher: $("#ma_voucher").val(),
            gia_tri_don_hang_ap_dung: $("#gia_tri_don_hang_ap_dung")
                .val(),
            gia_tri: $("#gia_tri").val(),
            phan_tram_giam_gia: $("#phan_tram_giam_gia")
                .val(),
            ngay_bat_dau: $("#ngay_bat_dau").val(),
            ngay_ket_thuc: $("#ngay_ket_thuc").val(),
            so_luong_giam_gia: $("#so_luong_giam_gia")
                .val(),
            mo_ta: $("#mo_ta").val(),
            chi_tiet_san_pham_sua: selectedProducts
        };

        console.log(voucherData)
    });
});
</script>