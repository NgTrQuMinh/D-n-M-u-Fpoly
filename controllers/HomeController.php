<?php

class HomeController
{
    // Xử lý trang chủ: http://localhost/BaseExam/
    public function trangChu()
    {
        $sanPhamModel = new SanPhamModel();

        // Lấy dữ liệu cần thiết cho trang chủ
        $sanPhamMoiNhat   = $sanPhamModel->layMoiNhat(8);     // Danh sách sản phẩm mới nhất
        $sanPhamYeuThich  = $sanPhamModel->layYeuThichNhat(8); // Danh sách sản phẩm được yêu thích nhất

        // Truyền dữ liệu ra layout main.php, layout sẽ include view tương ứng
        $title = 'Trang chủ';
        $view  = 'home/trang_chu';
        require_once PATH_VIEW_MAIN;
    }
}
