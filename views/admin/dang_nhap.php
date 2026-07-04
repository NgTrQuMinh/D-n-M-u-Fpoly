<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow" style="width:380px">
        <div class="card-body p-4">
            <h4 class="text-center mb-4"><i class="bi bi-shield-lock"></i> Đăng nhập quản trị</h4>

            <!-- Hiển thị lỗi đăng nhập nếu có (được truyền từ AdminController::dangNhap) -->
            <?php if (!empty($loi)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($loi) ?></div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>admin/dang-nhap" method="POST">
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

            <p class="text-muted small mt-3 mb-0 text-center">
                Tài khoản mẫu: admin@shop.com / 123456
            </p>
        </div>
    </div>

</body>
</html>
