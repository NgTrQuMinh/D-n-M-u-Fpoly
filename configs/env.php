<?php

// ==== Đường dẫn gốc của website (sửa lại nếu đổi tên thư mục project) ====
define('BASE_URL',          'http://localhost/BaseExam/');

// ==== Đường dẫn thư mục vật lý trên ổ đĩa ====
define('PATH_ROOT',         __DIR__ . '/../');           // Thư mục gốc dự án
define('PATH_VIEW',         PATH_ROOT . 'views/');        // Thư mục chứa view
define('PATH_VIEW_MAIN',    PATH_ROOT . 'views/main.php'); // Layout cho Client
define('PATH_VIEW_ADMIN',   PATH_ROOT . 'views/admin_main.php'); // Layout cho Admin

define('BASE_ASSETS_UPLOADS',   BASE_URL . 'assets/uploads/');   // URL ảnh upload
define('PATH_ASSETS_UPLOADS',   PATH_ROOT . 'assets/uploads/');  // Đường dẫn vật lý ảnh upload

define('PATH_CONTROLLER',       PATH_ROOT . 'controllers/'); // Nơi autoload tìm Controller
define('PATH_MODEL',            PATH_ROOT . 'models/');      // Nơi autoload tìm Model

// ==== Thông tin kết nối CSDL MySQL (sửa DB_NAME theo máy của bạn) ====
define('DB_HOST',     'localhost');
define('DB_PORT',     '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME',     'baseexam_shop'); // Tên CSDL - import file database.sql trước khi chạy

// Tuỳ chọn PDO: báo lỗi bằng Exception, fetch mặc định trả về mảng gán (assoc)
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
