<?php

// Bật session để dùng cho đăng nhập Admin, giỏ hàng (nếu cần mở rộng)
session_start();

// Tự động load class Model/Controller khi được gọi tới (không cần require tay)
spl_autoload_register(function ($class) {
    $fileName = "$class.php";

    $fileModel      = PATH_MODEL . $fileName;
    $fileController = PATH_CONTROLLER . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } else if (is_readable($fileController)) {
        require_once $fileController;
    }
});

// Nạp file cấu hình hằng số (đường dẫn, thông tin CSDL...)
require_once './configs/env.php';
// Nạp file các hàm tiện ích dùng chung
require_once './configs/helper.php';

// Nạp bộ điều hướng URL -> Controller/Action
require_once './routes/index.php';
