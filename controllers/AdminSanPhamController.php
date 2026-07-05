<?php

class AdminSanPhamController
{
    // Danh sách sản phẩm: /admin/san-pham
    public function danhSach()
    {
        kiem_tra_dang_nhap_admin();

        $sanPhamModel = new SanPhamModel();
        $danhSachSanPham = $sanPhamModel->layTatCaKemDanhMuc();

        $title = 'Quản lý sản phẩm';
        $view  = 'admin/san_pham/danh_sach';
        require_once PATH_VIEW_ADMIN;
    }

    // Thêm mới sản phẩm: /admin/san-pham/them
    public function them()
    {
        kiem_tra_dang_nhap_admin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $du_lieu = $this->layDuLieuTuForm();

            // Kiểm tra dữ liệu hợp lệ trước khi lưu
            $loi = $this->kiemTraDuLieu($du_lieu);
            if ($loi !== null) {
                $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => $loi];
                header('Location: ' . BASE_URL . 'admin/san-pham/them');
                exit;
            }

            // Xử lý ảnh upload (nếu người dùng có chọn ảnh)
            $du_lieu['hinh_anh'] = '';
            if (!empty($_FILES['hinh_anh']['name'])) {
                $du_lieu['hinh_anh'] = upload_file('san-pham', $_FILES['hinh_anh']);
            }

            $du_lieu['slug']     = tao_slug($du_lieu['ten_san_pham']);
            $du_lieu['luot_xem'] = 0;
            $du_lieu['ngay_tao'] = date('Y-m-d H:i:s');

            (new SanPhamModel())->them($du_lieu);

            $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Thêm sản phẩm thành công!'];
            header('Location: ' . BASE_URL . 'admin/san-pham');
            exit;
        }

        $title = 'Thêm sản phẩm';
        $sanPham = null; // null = đang ở chế độ thêm mới
        $danhSachDanhMuc = (new DanhMucModel())->layTatCa('ten_danh_muc ASC');
        $view  = 'admin/san_pham/form';
        require_once PATH_VIEW_ADMIN;
    }

    // Sửa sản phẩm: /admin/san-pham/sua/{id}
    public function sua($id)
    {
        kiem_tra_dang_nhap_admin();

        $sanPhamModel = new SanPhamModel();
        $sanPham = $sanPhamModel->timTheoId($id);

        if (!$sanPham) {
            http_response_code(404);
            die('Không tìm thấy sản phẩm!');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $du_lieu = $this->layDuLieuTuForm();

            $loi = $this->kiemTraDuLieu($du_lieu);
            if ($loi !== null) {
                $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => $loi];
                header('Location: ' . BASE_URL . 'admin/san-pham/sua/' . $id);
                exit;
            }

            // Nếu có chọn ảnh mới thì upload và ghi đè, không thì giữ ảnh cũ
            if (!empty($_FILES['hinh_anh']['name'])) {
                $du_lieu['hinh_anh'] = upload_file('san-pham', $_FILES['hinh_anh']);
            } else {
                unset($du_lieu['hinh_anh']); // Không cập nhật cột ảnh -> giữ nguyên giá trị cũ trong CSDL
            }

            $sanPhamModel->capNhat($id, $du_lieu);

            $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Cập nhật sản phẩm thành công!'];
            header('Location: ' . BASE_URL . 'admin/san-pham');
            exit;
        }

        $title = 'Sửa sản phẩm';
        $danhSachDanhMuc = (new DanhMucModel())->layTatCa('ten_danh_muc ASC');
        $view  = 'admin/san_pham/form';
        require_once PATH_VIEW_ADMIN;
    }

    // Xoá sản phẩm: /admin/san-pham/xoa/{id}
    public function xoa($id)
    {
        kiem_tra_dang_nhap_admin();

        (new SanPhamModel())->xoa($id); // Nhờ khoá ngoại ON DELETE CASCADE, bình luận liên quan cũng tự xoá theo

        $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Xoá sản phẩm thành công!'];
        header('Location: ' . BASE_URL . 'admin/san-pham');
        exit;
    }

    // Gom các trường dữ liệu chung của form thêm/sửa để khỏi lặp code
    private function layDuLieuTuForm()
    {
        return [
            'ten_san_pham' => trim($_POST['ten_san_pham'] ?? ''),
            'danh_muc_id'  => (int)($_POST['danh_muc_id'] ?? 0),
            'gia'          => (float)($_POST['gia'] ?? 0),
            'so_luong'     => (int)($_POST['so_luong'] ?? 0),
            'mo_ta'        => trim($_POST['mo_ta'] ?? ''),
        ];
    }

    // Kiểm tra dữ liệu form hợp lệ trước khi lưu, dùng chung cho cả Thêm và Sửa.
    // Trả về null nếu hợp lệ, hoặc trả về chuỗi thông báo lỗi nếu có vấn đề.
    private function kiemTraDuLieu($du_lieu)
    {
        if ($du_lieu['ten_san_pham'] === '') {
            return 'Vui lòng nhập Tên sản phẩm!';
        }

        // Kiểm tra danh mục có thực sự tồn tại trong CSDL, tránh lỗi khi ai đó cố tình sửa giá trị gửi lên
        $danhMuc = (new DanhMucModel())->timTheoId($du_lieu['danh_muc_id']);
        if (!$danhMuc) {
            return 'Danh mục không hợp lệ, vui lòng chọn lại!';
        }

        if ($du_lieu['gia'] < 0 || $du_lieu['so_luong'] < 0) {
            return 'Giá bán và Số lượng phải là số không âm!';
        }

        return null; // Không có lỗi
    }
}
