<?php

class AdminTaiKhoanController
{
    // Danh sách tài khoản: /admin/tai-khoan
    public function danhSach()
    {
        kiem_tra_dang_nhap_admin();

        $taiKhoanModel = new TaiKhoanModel();
        $danhSachTaiKhoan = $taiKhoanModel->layTatCa();

        $title = 'Quản lý tài khoản';
        $view  = 'admin/tai_khoan/danh_sach';
        require_once PATH_VIEW_ADMIN;
    }

    // Thêm mới tài khoản: /admin/tai-khoan/them
    public function them()
    {
        kiem_tra_dang_nhap_admin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoTen   = trim($_POST['ho_ten'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $matKhau = trim($_POST['mat_khau'] ?? '');
            $vaiTro  = $_POST['vai_tro'] ?? 'user';

            $taiKhoanModel = new TaiKhoanModel();

            // Validate: đủ thông tin + email chưa từng tồn tại
            if ($hoTen === '' || $email === '' || $matKhau === '') {
                $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Vui lòng nhập đầy đủ thông tin!'];
                header('Location: ' . BASE_URL . 'admin/tai-khoan/them');
                exit;
            }
            if ($taiKhoanModel->timTheoEmail($email)) {
                $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Email này đã được sử dụng!'];
                header('Location: ' . BASE_URL . 'admin/tai-khoan/them');
                exit;
            }

            $taiKhoanModel->them([
                'ho_ten'   => $hoTen,
                'email'    => $email,
                'mat_khau' => password_hash($matKhau, PASSWORD_DEFAULT), // Băm mật khẩu, không lưu dạng thô
                'vai_tro'  => $vaiTro,
                'ngay_tao' => date('Y-m-d H:i:s'),
            ]);

            $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Thêm tài khoản thành công!'];
            header('Location: ' . BASE_URL . 'admin/tai-khoan');
            exit;
        }

        $title = 'Thêm tài khoản';
        $taiKhoan = null;
        $view  = 'admin/tai_khoan/form';
        require_once PATH_VIEW_ADMIN;
    }

    // Sửa tài khoản: /admin/tai-khoan/sua/{id}
    public function sua($id)
    {
        kiem_tra_dang_nhap_admin();

        $taiKhoanModel = new TaiKhoanModel();
        $taiKhoan = $taiKhoanModel->timTheoId($id);

        if (!$taiKhoan) {
            http_response_code(404);
            die('Không tìm thấy tài khoản!');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoTen   = trim($_POST['ho_ten'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $matKhau = trim($_POST['mat_khau'] ?? '');
            $vaiTro  = $_POST['vai_tro'] ?? 'user';

            if ($hoTen === '' || $email === '') {
                $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Vui lòng nhập đầy đủ thông tin!'];
                header('Location: ' . BASE_URL . 'admin/tai-khoan/sua/' . $id);
                exit;
            }

            $du_lieu = [
                'ho_ten'  => $hoTen,
                'email'   => $email,
                'vai_tro' => $vaiTro,
            ];

            // Chỉ đổi mật khẩu nếu admin có nhập mật khẩu mới, để trống thì giữ mật khẩu cũ
            if ($matKhau !== '') {
                $du_lieu['mat_khau'] = password_hash($matKhau, PASSWORD_DEFAULT);
            }

            $taiKhoanModel->capNhat($id, $du_lieu);

            $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Cập nhật tài khoản thành công!'];
            header('Location: ' . BASE_URL . 'admin/tai-khoan');
            exit;
        }

        $title = 'Sửa tài khoản';
        $view  = 'admin/tai_khoan/form';
        require_once PATH_VIEW_ADMIN;
    }

    // Xoá tài khoản: /admin/tai-khoan/xoa/{id}
    public function xoa($id)
    {
        kiem_tra_dang_nhap_admin();

        // Không cho tự xoá chính tài khoản đang đăng nhập, tránh tự khoá mình ra khỏi hệ thống
        if ($_SESSION['admin']['id'] == $id) {
            $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Không thể tự xoá tài khoản đang đăng nhập!'];
            header('Location: ' . BASE_URL . 'admin/tai-khoan');
            exit;
        }

        (new TaiKhoanModel())->xoa($id);

        $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Xoá tài khoản thành công!'];
        header('Location: ' . BASE_URL . 'admin/tai-khoan');
        exit;
    }
}
