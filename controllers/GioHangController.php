<?php

class GioHangController
{
    // Xem giỏ hàng: GET /gio-hang
    public function xem()
    {
        $chiTietGioHang = $this->layChiTietGioHang(); // Lấy thông tin đầy đủ (tên, ảnh, giá...) từ session
        $tongTien = array_sum(array_column($chiTietGioHang, 'thanh_tien'));

        $danhSachDanhMuc = (new DanhMucModel())->layDanhMucKemSoLuong(); // Cho menu navbar
        $title = 'Giỏ hàng của bạn';
        $view  = 'gio_hang/xem';
        require_once PATH_VIEW_MAIN;
    }

    // Thêm sản phẩm vào giỏ: POST /gio-hang/them
    public function them()
    {
        $sanPhamId = (int)($_POST['san_pham_id'] ?? 0);
        $soLuong   = max(1, (int)($_POST['so_luong'] ?? 1)); // Tối thiểu 1 sản phẩm

        $sanPham = (new SanPhamModel())->timTheoId($sanPhamId);
        if (!$sanPham) {
            header('Location: ' . BASE_URL);
            exit;
        }

        // Số lượng đã có trong giỏ (nếu có) + số lượng vừa thêm, không được vượt quá tồn kho
        $daCoTrongGio = $_SESSION['gio_hang'][$sanPhamId] ?? 0;
        $tongSauKhiThem = min($daCoTrongGio + $soLuong, $sanPham['so_luong']);

        if ($tongSauKhiThem <= 0) {
            $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Sản phẩm đã hết hàng!'];
            header('Location: ' . ($_POST['tro_ve'] ?? BASE_URL));
            exit;
        }

        $_SESSION['gio_hang'][$sanPhamId] = $tongSauKhiThem;

        $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Đã thêm "' . $sanPham['ten_san_pham'] . '" vào giỏ hàng!'];
        header('Location: ' . ($_POST['tro_ve'] ?? BASE_URL . 'gio-hang')); // Quay lại trang trước đó
        exit;
    }

    // Cập nhật số lượng trong giỏ: POST /gio-hang/cap-nhat
    public function capNhat()
    {
        $sanPhamModel = new SanPhamModel();

        // $_POST['so_luong'] dạng mảng [san_pham_id => so_luong] nhờ đặt tên input là so_luong[id]
        foreach ($_POST['so_luong'] ?? [] as $sanPhamId => $soLuong) {
            $soLuong = (int)$soLuong;

            if ($soLuong <= 0) {
                unset($_SESSION['gio_hang'][$sanPhamId]); // Số lượng 0 -> xoá luôn khỏi giỏ
                continue;
            }

            // Chặn nhập số lượng vượt quá tồn kho thực tế
            $sanPham = $sanPhamModel->timTheoId($sanPhamId);
            if ($sanPham) {
                $_SESSION['gio_hang'][$sanPhamId] = min($soLuong, $sanPham['so_luong']);
            }
        }

        header('Location: ' . BASE_URL . 'gio-hang');
        exit;
    }

    // Xoá 1 sản phẩm khỏi giỏ: GET /gio-hang/xoa/{id}
    public function xoa($sanPhamId)
    {
        unset($_SESSION['gio_hang'][$sanPhamId]);
        header('Location: ' . BASE_URL . 'gio-hang');
        exit;
    }

    // Trang nhập thông tin đặt hàng: GET /thanh-toan
    public function thanhToan()
    {
        $chiTietGioHang = $this->layChiTietGioHang();

        // Giỏ hàng trống thì không cho vào trang thanh toán
        if (empty($chiTietGioHang)) {
            header('Location: ' . BASE_URL . 'gio-hang');
            exit;
        }

        $tongTien = array_sum(array_column($chiTietGioHang, 'thanh_tien'));
        $khachHang = $_SESSION['khach_hang'] ?? null; // Nếu đã đăng nhập thì điền sẵn thông tin

        $danhSachDanhMuc = (new DanhMucModel())->layDanhMucKemSoLuong();
        $title = 'Thanh toán đơn hàng';
        $view  = 'gio_hang/thanh_toan';
        require_once PATH_VIEW_MAIN;
    }

    // Xử lý submit đặt hàng: POST /thanh-toan
    public function xuLyThanhToan()
    {
        $chiTietGioHang = $this->layChiTietGioHang();
        if (empty($chiTietGioHang)) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $hoTen   = trim($_POST['ho_ten'] ?? '');
        $soDT    = trim($_POST['so_dien_thoai'] ?? '');
        $diaChi  = trim($_POST['dia_chi'] ?? '');
        $ghiChu  = trim($_POST['ghi_chu'] ?? '');

        // Validate thông tin giao hàng bắt buộc
        if ($hoTen === '' || $soDT === '' || $diaChi === '') {
            $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Vui lòng nhập đầy đủ Họ tên, Số điện thoại, Địa chỉ!'];
            header('Location: ' . BASE_URL . 'thanh-toan');
            exit;
        }

        $tongTien = array_sum(array_column($chiTietGioHang, 'thanh_tien'));

        // Kiểm tra lại tồn kho lần cuối trước khi tạo đơn (phòng trường hợp kho thay đổi trong lúc khách đang thanh toán)
        $sanPhamModel = new SanPhamModel();
        foreach ($chiTietGioHang as $sp) {
            $tonKhoHienTai = $sanPhamModel->timTheoId($sp['id']);
            if (!$tonKhoHienTai || $tonKhoHienTai['so_luong'] < $sp['so_luong']) {
                $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Sản phẩm "' . $sp['ten_san_pham'] . '" không đủ số lượng tồn kho, vui lòng cập nhật lại giỏ hàng!'];
                header('Location: ' . BASE_URL . 'gio-hang');
                exit;
            }
        }

        // Tạo đơn hàng, gắn tai_khoan_id nếu khách đã đăng nhập, không thì để NULL (mua khách vãng lai)
        $donHangModel = new DonHangModel();
        $donHangId = $donHangModel->them([
            'tai_khoan_id'  => $_SESSION['khach_hang']['id'] ?? null,
            'ho_ten'        => $hoTen,
            'so_dien_thoai' => $soDT,
            'dia_chi'       => $diaChi,
            'ghi_chu'       => $ghiChu,
            'tong_tien'     => $tongTien,
            'trang_thai'    => 'cho_xu_ly',
            'ngay_tao'      => date('Y-m-d H:i:s'),
        ]);

        // Lưu từng sản phẩm vào chi tiết đơn hàng (snapshot tên/giá tại thời điểm mua) + trừ kho
        $donHangChiTietModel = new DonHangChiTietModel();

        foreach ($chiTietGioHang as $sp) {
            $donHangChiTietModel->them([
                'don_hang_id'  => $donHangId,
                'san_pham_id'  => $sp['id'],
                'ten_san_pham' => $sp['ten_san_pham'],
                'gia'          => $sp['gia'],
                'so_luong'     => $sp['so_luong'],
                'thanh_tien'   => $sp['thanh_tien'],
            ]);
            $sanPhamModel->giamSoLuongKho($sp['id'], $sp['so_luong']); // Trừ tồn kho tương ứng
        }

        unset($_SESSION['gio_hang']); // Xoá sạch giỏ hàng sau khi đặt thành công

        $_SESSION['don_hang_vua_tao'] = $donHangId; // Dùng để hiển thị trang "Đặt hàng thành công"
        header('Location: ' . BASE_URL . 'dat-hang-thanh-cong');
        exit;
    }

    // Trang thông báo đặt hàng thành công: GET /dat-hang-thanh-cong
    public function thanhCong()
    {
        // Không cho truy cập trực tiếp nếu chưa vừa đặt hàng xong
        if (empty($_SESSION['don_hang_vua_tao'])) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $donHangId = $_SESSION['don_hang_vua_tao'];
        unset($_SESSION['don_hang_vua_tao']);

        $donHang = (new DonHangModel())->timTheoId($donHangId);
        $danhSachDanhMuc = (new DanhMucModel())->layDanhMucKemSoLuong();

        $title = 'Đặt hàng thành công';
        $view  = 'gio_hang/thanh_cong';
        require_once PATH_VIEW_MAIN;
    }

    // Hàm dùng chung: chuyển giỏ hàng trong session thành mảng chi tiết đầy đủ (tên, giá, ảnh, thành tiền)
    private function layChiTietGioHang()
    {
        if (empty($_SESSION['gio_hang'])) {
            return [];
        }

        $sanPhamModel = new SanPhamModel();
        $ketQua = [];

        foreach ($_SESSION['gio_hang'] as $sanPhamId => $soLuong) {
            $sanPham = $sanPhamModel->timTheoId($sanPhamId);

            // Sản phẩm có thể đã bị Admin xoá sau khi khách thêm vào giỏ -> tự động bỏ qua
            if (!$sanPham) {
                unset($_SESSION['gio_hang'][$sanPhamId]);
                continue;
            }

            $sanPham['so_luong']   = $soLuong;                    // Ghi đè: số lượng khách chọn (khác cột so_luong tồn kho)
            $sanPham['thanh_tien'] = $sanPham['gia'] * $soLuong;
            $ketQua[] = $sanPham;
        }

        return $ketQua;
    }
}
