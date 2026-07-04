# Website Bán Hàng - MVC OOP (PHP thuần)

## 1. Cấu trúc dự án (đúng mô hình MVC OOP)
```
BaseExam/
├── index.php              # Front Controller - điểm vào duy nhất
├── .htaccess               # Bật URL đẹp (rewrite về index.php)
├── database.sql            # Script tạo CSDL + dữ liệu mẫu
├── configs/
│   ├── env.php              # Hằng số cấu hình (đường dẫn, DB)
│   └── helper.php           # Hàm dùng chung (upload, slug, format tiền...)
├── routes/
│   └── index.php            # Điều hướng URL -> Controller
├── controllers/             # Xử lý logic (Client + Admin)
├── models/                  # Thao tác CSDL (kế thừa BaseModel)
├── views/                   # Giao diện (Client + Admin)
└── assets/uploads/          # Nơi lưu ảnh sản phẩm upload
```

## 2. Cài đặt
1. Copy thư mục `BaseExam` vào `htdocs` (XAMPP) hoặc `www` (Laragon).
2. Mở phpMyAdmin, tạo CSDL bằng cách import file `database.sql`
   (file này tự tạo CSDL `baseexam_shop`, không cần tạo tay trước).
3. Kiểm tra lại `configs/env.php`, đảm bảo đúng thông tin kết nối MySQL
   (mặc định XAMPP: user `root`, mật khẩu rỗng).
4. Bật `mod_rewrite` trong Apache (XAMPP đã bật sẵn theo mặc định).
5. Truy cập: `http://localhost/BaseExam/`

## 3. Tài khoản Admin mặc định
- Đăng nhập tại: `http://localhost/BaseExam/admin`
- Email: `admin@shop.com`
- Mật khẩu: `123456`

## 4. Chức năng đã hoàn thiện (đối chiếu tiêu chí PASS)

**Client:**
- Trang chủ: danh sách sản phẩm mới nhất + sản phẩm được yêu thích nhất (theo điểm đánh giá trung bình)
- Trang danh mục: lọc sản phẩm theo danh mục (`/danh-muc/{slug}`)
- Trang chi tiết sản phẩm: hiển thị thông tin đầy đủ, có bình luận, có đánh giá sao (gửi bình luận không cần đăng nhập)

**Admin (yêu cầu đăng nhập, có kiểm tra quyền):**
- CRUD Danh mục (`/admin/danh-muc`)
- CRUD Sản phẩm, có upload ảnh (`/admin/san-pham`)
- CRUD Tài khoản, mật khẩu được băm bằng `password_hash` (`/admin/tai-khoan`)

## 5. Ghi chú kỹ thuật
- Mô hình: MVC OOP thuần PHP, không dùng Framework, tự viết Router + Autoload class.
- Kết nối CSDL: PDO, dùng Prepared Statement toàn bộ (chống SQL Injection).
- Mật khẩu: băm bằng `password_hash()` / kiểm tra bằng `password_verify()`.
- Output HTML: dùng `htmlspecialchars()` để chống XSS khi hiển thị dữ liệu người dùng nhập.
