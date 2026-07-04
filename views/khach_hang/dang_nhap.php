<?php
// Biến $loi truyền từ KhachHangController::dangNhap()
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-3 text-center">Đăng nhập</h4>

                <?php if (!empty($loi)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($loi) ?></div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>dang-nhap" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="mat_khau" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    Chưa có tài khoản? <a href="<?= BASE_URL ?>dang-ky">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>
