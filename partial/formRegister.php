<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">ĐĂNG KÍ TÀI KHOẢN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form__login">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" name="form_register" value="true">
                        <div class="mb-3">
                            <label for="ten_tai_khoan" class="form-label">Tên tài khoản</label>
                            <input type="text" class="form-control" id="ten_tai_khoan" name="ten_tai_khoan" required>
                        </div>
                        <div class="mb-3">
                            <label for="tai_khoan" class="form-label">Tài khoản</label>
                            <input type="text" class="form-control" id="tai_khoan" name="tai_khoan" required>
                        </div>
                        <div class="mb-3">
                            <label for="mat_khau" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="mat_khau" name="mat_khau" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="so_dien_thoai" name="so_dien_thoai" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Đăng kí</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>