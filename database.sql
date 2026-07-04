-- ============================================
-- CSDL: baseexam_shop - Website bán hàng MVC OOP
-- Import file này vào MySQL trước khi chạy dự án
-- ============================================

CREATE DATABASE IF NOT EXISTS baseexam_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE baseexam_shop;

-- ===== BẢNG DANH MỤC =====
CREATE TABLE danh_muc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_danh_muc VARCHAR(150) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- ===== BẢNG SẢN PHẨM =====
CREATE TABLE san_pham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    danh_muc_id INT NOT NULL,
    ten_san_pham VARCHAR(255) NOT NULL,
    slug VARCHAR(280) NOT NULL UNIQUE,
    mo_ta TEXT,
    gia DECIMAL(12,0) NOT NULL DEFAULT 0,
    so_luong INT NOT NULL DEFAULT 0,
    hinh_anh VARCHAR(255),
    luot_xem INT NOT NULL DEFAULT 0,
    ngay_tao DATETIME NOT NULL,
    FOREIGN KEY (danh_muc_id) REFERENCES danh_muc(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ===== BẢNG TÀI KHOẢN =====
CREATE TABLE tai_khoan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ho_ten VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mat_khau VARCHAR(255) NOT NULL, -- lưu dạng đã băm bằng password_hash()
    vai_tro ENUM('admin','user') NOT NULL DEFAULT 'user',
    ngay_tao DATETIME NOT NULL
) ENGINE=InnoDB;

-- ===== BẢNG BÌNH LUẬN + ĐÁNH GIÁ =====
CREATE TABLE binh_luan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    san_pham_id INT NOT NULL,
    ho_ten VARCHAR(150) NOT NULL,
    noi_dung TEXT NOT NULL,
    diem_danh_gia TINYINT NOT NULL DEFAULT 5, -- từ 1 đến 5 sao
    ngay_tao DATETIME NOT NULL,
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- DỮ LIỆU MẪU
-- ============================================

-- Tài khoản admin mặc định: email admin@shop.com / mật khẩu 123456
INSERT INTO tai_khoan (ho_ten, email, mat_khau, vai_tro, ngay_tao) VALUES
('Quản trị viên', 'admin@shop.com', '$2b$10$T1HwvtD.LscllZgv3ShSZuSJoAc5nHlt5T0HwsBXiX6ffl4kobtA2', 'admin', NOW()),
('Nguyễn Văn A', 'nguyenvana@gmail.com', '$2b$10$T1HwvtD.LscllZgv3ShSZuSJoAc5nHlt5T0HwsBXiX6ffl4kobtA2', 'user', NOW());
-- Ghi chú: chuỗi băm trên tương ứng mật khẩu "123456"

-- Danh mục
INSERT INTO danh_muc (ten_danh_muc, slug) VALUES
('Áo thun', 'ao-thun-a1b2c'),
('Quần jean', 'quan-jean-d3e4f'),
('Giày dép', 'giay-dep-g5h6i'),
('Phụ kiện', 'phu-kien-j7k8l');

-- Sản phẩm mẫu (cột hinh_anh trỏ tới ảnh có sẵn trong assets/uploads/san-pham/)
INSERT INTO san_pham (danh_muc_id, ten_san_pham, slug, mo_ta, gia, so_luong, hinh_anh, luot_xem, ngay_tao) VALUES
(1, 'Áo thun nam basic trắng', 'ao-thun-nam-basic-trang-m1n2o', 'Áo thun cotton 100%, form regular fit, thoáng mát.', 150000, 50, 'san-pham/ao-thun-nam-basic-trang.jpg', 0, NOW()),
(1, 'Áo thun nữ croptop đen', 'ao-thun-nu-croptop-den-p3q4r', 'Chất liệu cotton co giãn 4 chiều, form ôm nhẹ.', 180000, 30, 'san-pham/ao-thun-nu-croptop-den.jpg', 0, NOW()),
(2, 'Quần jean nam slimfit xanh', 'quan-jean-nam-slimfit-xanh-s5t6u', 'Quần jean co giãn nhẹ, form slimfit hiện đại.', 350000, 20, 'san-pham/quan-jean-nam-slimfit-xanh.jpg', 0, NOW()),
(2, 'Quần jean nữ ống rộng', 'quan-jean-nu-ong-rong-v7w8x', 'Phong cách streetwear, chất jean dày dặn.', 320000, 25, 'san-pham/quan-jean-nu-ong-rong.jpg', 0, NOW()),
(3, 'Giày sneaker trắng unisex', 'giay-sneaker-trang-unisex-y9z0a', 'Đế cao su êm ái, phù hợp mọi trang phục.', 550000, 15, 'san-pham/giay-sneaker-trang-unisex.jpg', 0, NOW()),
(4, 'Balo laptop chống nước', 'balo-laptop-chong-nuoc-b1c2d', 'Ngăn chứa laptop 15.6 inch, chống thấm nước.', 280000, 40, 'san-pham/balo-laptop-chong-nuoc.jpg', 0, NOW());

-- Bình luận & đánh giá mẫu
INSERT INTO binh_luan (san_pham_id, ho_ten, noi_dung, diem_danh_gia, ngay_tao) VALUES
(1, 'Trần Thị B', 'Áo mặc rất thoáng mát, form chuẩn, sẽ ủng hộ tiếp!', 5, NOW()),
(1, 'Lê Văn C', 'Chất vải ổn so với giá tiền.', 4, NOW()),
(3, 'Phạm Thị D', 'Quần đẹp nhưng hơi rộng so với size thường mặc.', 4, NOW()),
(5, 'Hoàng Văn E', 'Giày êm, đi cả ngày không đau chân, quá ưng ý!', 5, NOW()),
(5, 'Đỗ Thị F', 'Giao hàng nhanh, giày y hình.', 5, NOW());
