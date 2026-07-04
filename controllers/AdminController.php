<?php

class AdminController
{
    // Trang dashboard tổng quan sau khi đăng nhập: /admin
    public function dashboard()
    {
        kiem_tra_dang_nhap_admin(); // Chưa đăng nhập thì tự động đá về trang đăng nhập

        $sanPhamModel = new SanPhamModel();
        $danhMucModel = new DanhMucModel();
        $taiKhoanModel = new TaiKhoanModel();

        // Thống kê nhanh: tổng số sản phẩm / danh mục / tài khoản
        $tongSanPham  = count($sanPhamModel->layTatCa());
        $tongDanhMuc  = count($danhMucModel->layTatCa());
        $tongTaiKhoan = count($taiKhoanModel->layTatCa());

        $title = 'Tổng quan hệ thống';
        $view  = 'admin_dashboard';
        require_once PATH_VIEW_ADMIN;
    }

    // Hiển thị form đăng nhập: GET /admin/dang-nhap
    public function dangNhap()
    {
        // Nếu đã đăng nhập rồi thì không cần đăng nhập lại nữa
        if (!empty($_SESSION['admin'])) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }

        $loi = $_SESSION['loi_dang_nhap'] ?? null;
        unset($_SESSION['loi_dang_nhap']);

        require_once PATH_VIEW . 'admin/dang_nhap.php'; // Trang login dùng layout riêng, không qua main
    }

    // Xử lý submit form đăng nhập: POST /admin/dang-nhap
    public function xuLyDangNhap()
    {
        $email    = trim($_POST['email'] ?? '');
        $matKhau  = trim($_POST['mat_khau'] ?? '');

        $taiKhoanModel = new TaiKhoanModel();
        $taiKhoan = $taiKhoanModel->timTheoEmail($email);

        // Kiểm tra: tồn tại tài khoản, đúng mật khẩu (đã băm), và có vai trò admin
        if (!$taiKhoan || !password_verify($matKhau, $taiKhoan['mat_khau']) || $taiKhoan['vai_tro'] !== 'admin') {
            $_SESSION['loi_dang_nhap'] = 'Email hoặc mật khẩu không đúng, hoặc tài khoản không có quyền quản trị!';
            header('Location: ' . BASE_URL . 'admin/dang-nhap');
            exit;
        }

        // Lưu thông tin admin vào session (bỏ mật khẩu ra cho an toàn)
        unset($taiKhoan['mat_khau']);
        $_SESSION['admin'] = $taiKhoan;

        header('Location: ' . BASE_URL . 'admin');
        exit;
    }

    // Đăng xuất: /admin/dang-xuat
    public function dangXuat()
    {
        unset($_SESSION['admin']);
        header('Location: ' . BASE_URL . 'admin/dang-nhap');
        exit;
    }
}
