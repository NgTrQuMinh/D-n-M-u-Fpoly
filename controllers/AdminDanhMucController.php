<?php

class AdminDanhMucController
{
    // Danh sách danh mục: /admin/danh-muc
    public function danhSach()
    {
        kiem_tra_dang_nhap_admin();

        $danhMucModel = new DanhMucModel();
        $danhSachDanhMuc = $danhMucModel->layDanhMucKemSoLuong(); // Kèm số lượng sản phẩm mỗi danh mục

        $title = 'Quản lý danh mục';
        $view  = 'admin/danh_muc/danh_sach';
        require_once PATH_VIEW_ADMIN;
    }

    // Thêm mới danh mục: /admin/danh-muc/them (GET hiện form, POST xử lý lưu)
    public function them()
    {
        kiem_tra_dang_nhap_admin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenDanhMuc = trim($_POST['ten_danh_muc'] ?? '');

            // Validate: tên danh mục không được để trống
            if ($tenDanhMuc === '') {
                $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Tên danh mục không được để trống!'];
                header('Location: ' . BASE_URL . 'admin/danh-muc/them');
                exit;
            }

            $danhMucModel = new DanhMucModel();
            $danhMucModel->them([
                'ten_danh_muc' => $tenDanhMuc,
                'slug'         => tao_slug($tenDanhMuc), // Tự sinh slug từ tên
            ]);

            $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Thêm danh mục thành công!'];
            header('Location: ' . BASE_URL . 'admin/danh-muc');
            exit;
        }

        $title = 'Thêm danh mục';
        $danhMuc = null; // form.php dùng chung cho thêm/sửa, null nghĩa là đang ở chế độ thêm mới
        $view  = 'admin/danh_muc/form';
        require_once PATH_VIEW_ADMIN;
    }

    // Sửa danh mục: /admin/danh-muc/sua/{id}
    public function sua($id)
    {
        kiem_tra_dang_nhap_admin();

        $danhMucModel = new DanhMucModel();
        $danhMuc = $danhMucModel->timTheoId($id);

        if (!$danhMuc) {
            http_response_code(404);
            die('Không tìm thấy danh mục!');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenDanhMuc = trim($_POST['ten_danh_muc'] ?? '');

            if ($tenDanhMuc === '') {
                $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Tên danh mục không được để trống!'];
                header('Location: ' . BASE_URL . 'admin/danh-muc/sua/' . $id);
                exit;
            }

            $danhMucModel->capNhat($id, [
                'ten_danh_muc' => $tenDanhMuc,
                // Giữ nguyên slug cũ để không phá vỡ đường link đã chia sẻ trước đó
            ]);

            $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Cập nhật danh mục thành công!'];
            header('Location: ' . BASE_URL . 'admin/danh-muc');
            exit;
        }

        $title = 'Sửa danh mục';
        $view  = 'admin/danh_muc/form';
        require_once PATH_VIEW_ADMIN;
    }

    // Xoá danh mục: /admin/danh-muc/xoa/{id}
    public function xoa($id)
    {
        kiem_tra_dang_nhap_admin();

        $sanPhamModel = new SanPhamModel();
        $danhMucModel = new DanhMucModel();

        // Chặn xoá nếu danh mục còn sản phẩm, tránh sản phẩm bị mồ côi danh mục
        $conSanPham = $sanPhamModel->layTheoDanhMuc($id);
        if (count($conSanPham) > 0) {
            $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Không thể xoá: danh mục vẫn còn sản phẩm!'];
            header('Location: ' . BASE_URL . 'admin/danh-muc');
            exit;
        }

        $danhMucModel->xoa($id);
        $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Xoá danh mục thành công!'];
        header('Location: ' . BASE_URL . 'admin/danh-muc');
        exit;
    }
}
