<?php

class AdminDonHangController
{
    // Danh sách đơn hàng: /admin/don-hang
    public function danhSach()
    {
        kiem_tra_dang_nhap_admin();

        $danhSachDonHang = (new DonHangModel())->layTatCa();

        $title = 'Quản lý đơn hàng';
        $view  = 'admin/don_hang/danh_sach';
        require_once PATH_VIEW_ADMIN;
    }

    // Chi tiết 1 đơn hàng: /admin/don-hang/chi-tiet/{id}
    public function chiTiet($id)
    {
        kiem_tra_dang_nhap_admin();

        $donHang = (new DonHangModel())->timTheoId($id);
        if (!$donHang) {
            http_response_code(404);
            die('Không tìm thấy đơn hàng!');
        }

        $danhSachChiTiet = (new DonHangChiTietModel())->layTheoDonHang($id);

        $title = 'Chi tiết đơn hàng #' . $id;
        $view  = 'admin/don_hang/chi_tiet';
        require_once PATH_VIEW_ADMIN;
    }

    // Cập nhật trạng thái đơn hàng: POST /admin/don-hang/cap-nhat-trang-thai/{id}
    public function capNhatTrangThai($id)
    {
        kiem_tra_dang_nhap_admin();

        $trangThai = $_POST['trang_thai'] ?? '';
        $trangThaiHopLe = ['cho_xu_ly', 'dang_giao', 'hoan_thanh', 'da_huy'];

        if (in_array($trangThai, $trangThaiHopLe)) {
            (new DonHangModel())->capNhatTrangThai($id, $trangThai);
            $_SESSION['thong_bao'] = ['loai' => 'success', 'noi_dung' => 'Cập nhật trạng thái đơn hàng thành công!'];
        } else {
            $_SESSION['thong_bao'] = ['loai' => 'danger', 'noi_dung' => 'Trạng thái không hợp lệ!'];
        }

        header('Location: ' . BASE_URL . 'admin/don-hang/chi-tiet/' . $id);
        exit;
    }
}
