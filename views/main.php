<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Trang chủ' ?> - Shop Bán Hàng</title>

    <!-- Bootstrap CSS + Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <!-- ===== MENU ĐIỀU HƯỚNG ===== -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>"><i class="bi bi-shop"></i> ShopMVC</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>">Trang chủ</a>
                    </li>
                    <?php
                    // Lặp qua danh mục để hiện lên menu (biến $danhSachDanhMuc được truyền từ Controller)
                    foreach ($danhSachDanhMuc ?? [] as $dm):
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>danh-muc/<?= $dm['slug'] ?>">
                                <?= htmlspecialchars($dm['ten_danh_muc']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Ô tìm kiếm sản phẩm -->
                <form action="<?= BASE_URL ?>tim-kiem" method="GET" class="d-flex me-2">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Tìm sản phẩm..."
                           value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button class="btn btn-sm btn-outline-light ms-1"><i class="bi bi-search"></i></button>
                </form>

                <!-- Icon giỏ hàng kèm số lượng -->
                <a href="<?= BASE_URL ?>gio-hang" class="btn btn-outline-light btn-sm position-relative me-2">
                    <i class="bi bi-cart3"></i>
                    <?php $soLuongGioHang = dem_so_luong_gio_hang(); ?>
                    <?php if ($soLuongGioHang > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $soLuongGioHang ?>
                        </span>
                    <?php endif; ?>
                </a>

                <!-- Menu tài khoản: đã đăng nhập thì hiện tên + đơn hàng, chưa thì hiện đăng nhập/đăng ký -->
                <?php if (!empty($_SESSION['khach_hang'])): ?>
                    <div class="dropdown me-2">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['khach_hang']['ho_ten']) ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>tai-khoan-cua-toi">Đơn hàng của tôi</a></li>
                            <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>dang-xuat">Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>dang-nhap" class="btn btn-outline-light btn-sm me-2">Đăng nhập</a>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>admin" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-shield-lock"></i> Quản trị
                </a>
            </div>
        </div>
    </nav>

    <!-- ===== NỘI DUNG TRANG (thay đổi theo từng Controller) ===== -->
    <div class="container my-4">
        <?php
        if (isset($view)) {
            require_once PATH_VIEW . $view . '.php'; // Nạp view con tương ứng vào giữa layout
        }
        ?>
    </div>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-dark text-light text-center py-3 mt-5">
        &copy; <?= date('Y') ?> ShopMVC - Đồ án môn học (MVC OOP + PHP thuần)
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
