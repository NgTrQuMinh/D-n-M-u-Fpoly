<?php

class KhachHangController
{
    // Trang đăng ký: GET /dang-ky
    public function dangKy()
    {
        if (!empty($_SESSION['khach_hang'])) {
            header('Location: ' . BASE_URL);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoTen   = trim($_POST['ho_ten'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $matKhau = trim($_POST['mat_khau'] ?? '');

            $taiKhoanModel = new TaiKhoanModel();

            // Validate: đủ thông tin + email chưa tồn tại
            if ($hoTen === '' || $email === '' || $matKhau === '') {
                $_SESSION['loi_dang_ky'] = 'Vui lòng nhập đầy đủ thông tin!';
                header('Location: ' . BASE_URL . 'dang-ky');
                exit;
            }
            if ($taiKhoanModel->timTheoEmail($email)) {
                $_SESSION['loi_dang_ky'] = 'Email này đã được đăng ký, vui lòng dùng email khác!';
                header('Location: ' . BASE_URL . 'dang-ky');
                exit;
            }

            $id = $taiKhoanModel->them([
                'ho_ten'   => $hoTen,
                'email'    => $email,
                'mat_khau' => password_hash($matKhau, PASSWORD_DEFAULT),
                'vai_tro'  => 'user', // Đăng ký từ Client luôn là user, không thể tự đăng ký thành admin
                'ngay_tao' => date('Y-m-d H:i:s'),
            ]);

            // Tự động đăng nhập luôn sau khi đăng ký thành công
            $_SESSION['khach_hang'] = [
                'id'     => $id,
                'ho_ten' => $hoTen,
                'email'  => $email,
            ];

            header('Location: ' . BASE_URL);
            exit;
        }

        $loi = $_SESSION['loi_dang_ky'] ?? null;
        unset($_SESSION['loi_dang_ky']);
        $danhSachDanhMuc = (new DanhMucModel())->layDanhMucKemSoLuong();
        $title = 'Đăng ký tài khoản';
        $view  = 'khach_hang/dang_ky';
        require_once PATH_VIEW_MAIN;
    }

    // Trang đăng nhập: GET /dang-nhap
    public function dangNhap()
    {
        if (!empty($_SESSION['khach_hang'])) {
            header('Location: ' . BASE_URL);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email   = trim($_POST['email'] ?? '');
            $matKhau = trim($_POST['mat_khau'] ?? '');

            $taiKhoan = (new TaiKhoanModel())->timTheoEmail($email);

            // Chỉ cho phép vai_tro = user đăng nhập ở phía Client (admin đăng nhập riêng ở /admin)
            if (!$taiKhoan || !password_verify($matKhau, $taiKhoan['mat_khau'])) {
                $_SESSION['loi_dang_nhap_kh'] = 'Email hoặc mật khẩu không đúng!';
                header('Location: ' . BASE_URL . 'dang-nhap');
                exit;
            }

            $_SESSION['khach_hang'] = [
                'id'     => $taiKhoan['id'],
                'ho_ten' => $taiKhoan['ho_ten'],
                'email'  => $taiKhoan['email'],
            ];

            header('Location: ' . BASE_URL);
            exit;
        }

        $loi = $_SESSION['loi_dang_nhap_kh'] ?? null;
        unset($_SESSION['loi_dang_nhap_kh']);
        $danhSachDanhMuc = (new DanhMucModel())->layDanhMucKemSoLuong();
        $title = 'Đăng nhập';
        $view  = 'khach_hang/dang_nhap';
        require_once PATH_VIEW_MAIN;
    }

    // Đăng xuất: /dang-xuat
    public function dangXuat()
    {
        unset($_SESSION['khach_hang']);
        header('Location: ' . BASE_URL);
        exit;
    }

    // Lịch sử đơn hàng của khách: GET /tai-khoan-cua-toi
    public function taiKhoanCuaToi()
    {
        kiem_tra_dang_nhap_khach_hang(); // Bắt buộc đăng nhập mới xem được

        $donHangModel = new DonHangModel();
        $danhSachDonHang = $donHangModel->layTheoTaiKhoan($_SESSION['khach_hang']['id']);

        $danhSachDanhMuc = (new DanhMucModel())->layDanhMucKemSoLuong();
        $title = 'Đơn hàng của tôi';
        $view  = 'khach_hang/don_hang_cua_toi';
        require_once PATH_VIEW_MAIN;
    }
}
