<?php

// Lấy phần URL sau tên thư mục project, ví dụ: san-pham/ao-thun-nam-abc12
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath   = parse_url(BASE_URL, PHP_URL_PATH); // ví dụ /BaseExam/
$url        = trim(substr($requestUri, strlen($basePath)), '/');

// Tách URL thành từng đoạn theo dấu "/"
$segments = $url === '' ? [] : explode('/', $url);

$segment0 = $segments[0] ?? ''; // đoạn đầu tiên: xác định khu vực (rỗng = trang chủ, "admin" = quản trị)
$segment1 = $segments[1] ?? ''; // đoạn 2: hành động / slug
$segment2 = $segments[2] ?? ''; // đoạn 3: id (dùng cho sửa/xoá)

switch ($segment0) {

    // ===================== KHU VỰC CLIENT (người mua hàng) =====================
    case '': // Trang chủ: http://localhost/BaseExam/
        (new HomeController())->trangChu();
        break;

    case 'danh-muc': // Trang danh sách sản phẩm lọc theo danh mục: /danh-muc/{slug}
        (new SanPhamController())->theoDanhMuc($segment1);
        break;

    case 'san-pham': // Trang chi tiết sản phẩm: /san-pham/{slug}
        if ($segment1 === 'binh-luan') {
            // Form bình luận submit tới: /san-pham/binh-luan (POST)
            (new SanPhamController())->themBinhLuan();
        } else {
            (new SanPhamController())->chiTiet($segment1);
        }
        break;

    case 'tim-kiem': // Tìm kiếm sản phẩm: /tim-kiem?q=...
        (new SanPhamController())->timKiem();
        break;

    // ---- Giỏ hàng ----
    case 'gio-hang':
        if ($segment1 === 'them') (new GioHangController())->them();               // POST
        elseif ($segment1 === 'cap-nhat') (new GioHangController())->capNhat();     // POST
        elseif ($segment1 === 'xoa') (new GioHangController())->xoa($segment2);     // GET
        else (new GioHangController())->xem();                                      // GET /gio-hang
        break;

    case 'thanh-toan': // Trang thanh toán: GET hiện form, POST xử lý đặt hàng
        $_SERVER['REQUEST_METHOD'] === 'POST'
            ? (new GioHangController())->xuLyThanhToan()
            : (new GioHangController())->thanhToan();
        break;

    case 'dat-hang-thanh-cong':
        (new GioHangController())->thanhCong();
        break;

    // ---- Tài khoản khách hàng ----
    case 'dang-ky':
        (new KhachHangController())->dangKy();
        break;

    case 'dang-nhap':
        (new KhachHangController())->dangNhap();
        break;

    case 'dang-xuat':
        (new KhachHangController())->dangXuat();
        break;

    case 'tai-khoan-cua-toi':
        (new KhachHangController())->taiKhoanCuaToi();
        break;

    // ===================== KHU VỰC ADMIN (quản trị) =====================
    case 'admin':
        switch ($segment1) {
            case '': // /admin -> trang dashboard
                (new AdminController())->dashboard();
                break;

            case 'dang-nhap':
                $_SERVER['REQUEST_METHOD'] === 'POST'
                    ? (new AdminController())->xuLyDangNhap()
                    : (new AdminController())->dangNhap();
                break;

            case 'dang-xuat':
                (new AdminController())->dangXuat();
                break;

            // ---- CRUD Danh mục ----
            case 'danh-muc':
                $action = $segment2;
                if ($action === '') (new AdminDanhMucController())->danhSach();
                elseif ($action === 'them') (new AdminDanhMucController())->them();
                elseif ($action === 'sua') (new AdminDanhMucController())->sua($segments[3] ?? 0);
                elseif ($action === 'xoa') (new AdminDanhMucController())->xoa($segments[3] ?? 0);
                break;

            // ---- CRUD Sản phẩm ----
            case 'san-pham':
                $action = $segment2;
                if ($action === '') (new AdminSanPhamController())->danhSach();
                elseif ($action === 'them') (new AdminSanPhamController())->them();
                elseif ($action === 'sua') (new AdminSanPhamController())->sua($segments[3] ?? 0);
                elseif ($action === 'xoa') (new AdminSanPhamController())->xoa($segments[3] ?? 0);
                break;

            // ---- CRUD Tài khoản ----
            case 'tai-khoan':
                $action = $segment2;
                if ($action === '') (new AdminTaiKhoanController())->danhSach();
                elseif ($action === 'them') (new AdminTaiKhoanController())->them();
                elseif ($action === 'sua') (new AdminTaiKhoanController())->sua($segments[3] ?? 0);
                elseif ($action === 'xoa') (new AdminTaiKhoanController())->xoa($segments[3] ?? 0);
                break;

            // ---- Quản lý đơn hàng ----
            case 'don-hang':
                if ($segment2 === '') (new AdminDonHangController())->danhSach();
                elseif ($segment2 === 'chi-tiet') (new AdminDonHangController())->chiTiet($segments[3] ?? 0);
                elseif ($segment2 === 'cap-nhat-trang-thai') (new AdminDonHangController())->capNhatTrangThai($segments[3] ?? 0);
                break;

            default:
                echo 'Trang quản trị không tồn tại (404)';
        }
        break;

    default:
        http_response_code(404);
        echo 'Không tìm thấy trang (404)';
}
