<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Quản trị' ?> - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <div class="d-flex">
        <!-- ===== SIDEBAR MENU QUẢN TRỊ ===== -->
        <div class="bg-dark text-light vh-100 p-3" style="width:230px;position:sticky;top:0">
            <h5 class="mb-4"><i class="bi bi-shop"></i> ShopMVC Admin</h5>
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= BASE_URL ?>admin"><i class="bi bi-speedometer2"></i> Tổng quan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= BASE_URL ?>admin/danh-muc"><i class="bi bi-tags"></i> Danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= BASE_URL ?>admin/san-pham"><i class="bi bi-box-seam"></i> Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= BASE_URL ?>admin/tai-khoan"><i class="bi bi-people"></i> Tài khoản</a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link text-light" href="<?= BASE_URL ?>" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Xem website</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= BASE_URL ?>admin/dang-xuat"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
                </li>
            </ul>
        </div>

        <!-- ===== NỘI DUNG TRANG QUẢN TRỊ ===== -->
        <div class="flex-fill p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0"><?= $title ?? '' ?></h3>
                <span class="text-muted">
                    Xin chào, <strong><?= htmlspecialchars($_SESSION['admin']['ho_ten'] ?? '') ?></strong>
                </span>
            </div>

            <!-- Hiển thị thông báo dùng chung (thêm/sửa/xoá thành công hay lỗi) -->
            <?php if (!empty($_SESSION['thong_bao'])): ?>
                <div class="alert alert-<?= $_SESSION['thong_bao']['loai'] ?>">
                    <?= htmlspecialchars($_SESSION['thong_bao']['noi_dung']) ?>
                </div>
                <?php unset($_SESSION['thong_bao']); ?>
            <?php endif; ?>

            <?php
            if (isset($view)) {
                require_once PATH_VIEW . $view . '.php'; // Nạp nội dung con tương ứng
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
