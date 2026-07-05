<?php

// In dữ liệu ra màn hình để kiểm tra rồi dừng chương trình (chỉ dùng lúc code, debug)
if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';       // Thẻ pre giúp giữ định dạng xuống dòng
        print_r($data);     // In cấu trúc mảng/object ra
        die;                // Dừng luôn để dễ quan sát, tránh chạy tiếp code phía dưới
    }
}

// Upload 1 file lên thư mục assets/uploads, trả về tên file đã lưu
if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        // Ghép tên file = thời gian hiện tại (chống trùng) + tên gốc
        $targetFile = $folder . '/' . time() . '-' . basename($file["name"]);

        // Di chuyển file từ thư mục tạm (tmp_name) vào thư mục uploads thật
        if (move_uploaded_file($file["tmp_name"], PATH_ASSETS_UPLOADS . $targetFile)) {
            return $targetFile; // Trả về đường dẫn tương đối để lưu vào CSDL
        }

        throw new Exception('Upload file không thành công!');
    }
}

// Biến chuỗi tiếng Việt có dấu thành slug không dấu, có gạch ngang (dùng cho URL đẹp)
if (!function_exists('tao_slug')) {
    function tao_slug($str)
    {
        $str = mb_strtolower($str, 'UTF-8'); // Chuyển hết thành chữ thường

        // Bảng quy đổi ký tự có dấu -> không dấu
        $viet = ['à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă','ằ','ắ','ặ','ẳ','ẵ',
                 'è','é','ẹ','ẻ','ẽ','ê','ề','ế','ệ','ể','ễ',
                 'ì','í','ị','ỉ','ĩ',
                 'ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ','ờ','ớ','ợ','ở','ỡ',
                 'ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ',
                 'ỳ','ý','ỵ','ỷ','ỹ','đ'];
        $khong_dau = ['a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a',
                 'e','e','e','e','e','e','e','e','e','e','e',
                 'i','i','i','i','i',
                 'o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o',
                 'u','u','u','u','u','u','u','u','u','u','u',
                 'y','y','y','y','y','d'];

        $str = str_replace($viet, $khong_dau, $str);          // Bỏ dấu
        $str = preg_replace('/[^a-z0-9]+/', '-', $str);        // Ký tự lạ -> gạch ngang
        $str = trim($str, '-');                                 // Bỏ gạch ngang thừa ở 2 đầu

        return $str . '-' . substr(md5(uniqid()), 0, 5); // Thêm mã ngẫu nhiên tránh trùng slug
    }
}

// Định dạng số thành tiền VNĐ, ví dụ 150000 -> "150.000 đ"
if (!function_exists('dinh_dang_tien')) {
    function dinh_dang_tien($so)
    {
        return number_format($so, 0, ',', '.') . ' đ';
    }
}

// Kiểm tra admin đã đăng nhập chưa, chưa thì đá về trang đăng nhập
if (!function_exists('kiem_tra_dang_nhap_admin')) {
    function kiem_tra_dang_nhap_admin()
    {
        if (empty($_SESSION['admin'])) {
            header('Location: ' . BASE_URL . 'admin/dang-nhap');
            exit; // Bắt buộc exit để code phía sau không chạy tiếp
        }
    }
}

// Kiểm tra khách hàng đã đăng nhập chưa (dùng session riêng, khác với session admin)
if (!function_exists('kiem_tra_dang_nhap_khach_hang')) {
    function kiem_tra_dang_nhap_khach_hang()
    {
        if (empty($_SESSION['khach_hang'])) {
            header('Location: ' . BASE_URL . 'dang-nhap');
            exit;
        }
    }
}

// Đếm tổng số sản phẩm đang có trong giỏ hàng (hiển thị badge số lượng trên navbar)
if (!function_exists('dem_so_luong_gio_hang')) {
    function dem_so_luong_gio_hang()
    {
        if (empty($_SESSION['gio_hang'])) {
            return 0;
        }
        return array_sum($_SESSION['gio_hang']); // Cộng dồn số lượng của từng sản phẩm trong giỏ
    }
}
