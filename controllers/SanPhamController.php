<?php

class SanPhamController
{
    // Trang danh sách sản phẩm theo danh mục: /danh-muc/{slug}
    public function theoDanhMuc($slug)
    {
        $danhMucModel = new DanhMucModel();
        $sanPhamModel = new SanPhamModel();

        $danhMuc = $danhMucModel->timTheoSlug($slug);

        // Không tìm thấy danh mục -> báo lỗi 404 luôn
        if (!$danhMuc) {
            http_response_code(404);
            die('Không tìm thấy danh mục sản phẩm này!');
        }

        $danhSachSanPham = $sanPhamModel->layTheoDanhMuc($danhMuc['id']); // Lọc sản phẩm theo danh_muc_id

        $title = 'Danh mục: ' . $danhMuc['ten_danh_muc'];
        $view  = 'san_pham/danh_sach';
        require_once PATH_VIEW_MAIN;
    }

    // Trang chi tiết sản phẩm: /san-pham/{slug}
    public function chiTiet($slug)
    {
        $sanPhamModel = new SanPhamModel();
        $binhLuanModel = new BinhLuanModel();

        $sanPham = $sanPhamModel->timTheoSlug($slug);

        if (!$sanPham) {
            http_response_code(404);
            die('Không tìm thấy sản phẩm này!');
        }

        $sanPhamModel->tangLuotXem($sanPham['id']); // Cộng thêm 1 lượt xem mỗi khi vào trang

        $danhSachBinhLuan = $binhLuanModel->layTheoSanPham($sanPham['id']); // Danh sách bình luận & đánh giá
        $diemDanhGia      = $binhLuanModel->tinhDiemTrungBinh($sanPham['id']); // Điểm trung bình

        // Lấy thông báo (nếu vừa gửi bình luận xong được redirect về đây)
        $thongBao = $_SESSION['thong_bao'] ?? null;
        unset($_SESSION['thong_bao']);

        $title = $sanPham['ten_san_pham'];
        $view  = 'san_pham/chi_tiet';
        require_once PATH_VIEW_MAIN;
    }

    // Tìm kiếm sản phẩm theo tên: GET /tim-kiem?q=...
    public function timKiem()
    {
        $tuKhoa = trim($_GET['q'] ?? '');

        $danhSachSanPham = $tuKhoa === '' ? [] : (new SanPhamModel())->timKiem($tuKhoa);

        $title = 'Kết quả tìm kiếm: ' . $tuKhoa;
        $view  = 'san_pham/tim_kiem';
        require_once PATH_VIEW_MAIN;
    }

    // Xử lý form gửi bình luận + đánh giá (POST tới /san-pham/binh-luan)
    public function themBinhLuan()
    {
        // Chỉ chấp nhận phương thức POST, tránh truy cập trực tiếp bằng GET
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $sanPhamId = (int)($_POST['san_pham_id'] ?? 0);
        $hoTen     = trim($_POST['ho_ten'] ?? '');
        $noiDung   = trim($_POST['noi_dung'] ?? '');
        $diemDanhGia = (int)($_POST['diem_danh_gia'] ?? 5);

        $sanPhamModel = new SanPhamModel();
        $sanPham = $sanPhamModel->timTheoId($sanPhamId);

        // Validate dữ liệu cơ bản trước khi lưu
        if (!$sanPham || $hoTen === '' || $noiDung === '' || $diemDanhGia < 1 || $diemDanhGia > 5) {
            $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Vui lòng nhập đầy đủ và đúng thông tin bình luận!'];
            header('Location: ' . BASE_URL . 'san-pham/' . ($sanPham['slug'] ?? ''));
            exit;
        }

        $binhLuanModel = new BinhLuanModel();
        $binhLuanModel->them([
            'san_pham_id'   => $sanPhamId,
            'ho_ten'        => $hoTen,
            'noi_dung'      => $noiDung,
            'diem_danh_gia' => $diemDanhGia,
            'ngay_tao'      => date('Y-m-d H:i:s'),
        ]);

        $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Cảm ơn bạn đã đánh giá sản phẩm!'];
        header('Location: ' . BASE_URL . 'san-pham/' . $sanPham['slug']); // Quay lại đúng trang chi tiết sản phẩm
        exit;
    }
}
