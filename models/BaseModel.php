<?php

class BaseModel
{
    protected $table; // Tên bảng, mỗi Model con tự khai báo giá trị này
    protected $pdo;   // Đối tượng kết nối CSDL dùng chung

    // Kết nối CSDL ngay khi Model được khởi tạo (new XxxModel())
    public function __construct()
    {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);

        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            // Xử lý lỗi kết nối, dừng chương trình luôn vì không có CSDL thì không chạy tiếp được
            die("Kết nối cơ sở dữ liệu thất bại: {$e->getMessage()}. Vui lòng thử lại sau.");
        }
    }

    // Lấy toàn bộ bản ghi trong bảng, mới nhất lên đầu
    public function layTatCa($orderBy = 'id DESC')
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        return $this->pdo->query($sql)->fetchAll();
    }

    // Lấy 1 bản ghi theo id
    public function timTheoId($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Thêm mới 1 bản ghi, $data dạng ['cot' => 'gia_tri', ...]
    public function them($data)
    {
        // Bước 1: Ghép danh sách tên cột, ví dụ: "ten_san_pham,gia,so_luong"
        $danhSachCot = implode(',', array_keys($data));

        // Bước 2: Ghép danh sách dấu giữ chỗ (placeholder), ví dụ: ":ten_san_pham,:gia,:so_luong"
        // Dùng vòng lặp foreach cho dễ đọc thay vì hàm rút gọn
        $danhSachGiuCho = [];
        foreach (array_keys($data) as $tenCot) {
            $danhSachGiuCho[] = ':' . $tenCot;
        }
        $danhSachGiuCho = implode(',', $danhSachGiuCho);

        $sql = "INSERT INTO {$this->table} ($danhSachCot) VALUES ($danhSachGiuCho)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return $this->pdo->lastInsertId(); // Trả về id vừa thêm
    }

    // Cập nhật 1 bản ghi theo id, $data dạng ['cot' => 'gia_tri', ...]
    public function capNhat($id, $data)
    {
        // Ghép chuỗi kiểu: "ten_san_pham = :ten_san_pham, gia = :gia, ..."
        $danhSachSet = [];
        foreach (array_keys($data) as $tenCot) {
            $danhSachSet[] = "$tenCot = :$tenCot";
        }
        $danhSachSet = implode(',', $danhSachSet);

        $sql = "UPDATE {$this->table} SET $danhSachSet WHERE id = :id";
        $data['id'] = $id; // Gộp thêm id vào mảng để bind cùng lúc

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    // Xoá 1 bản ghi theo id
    public function xoa($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Hủy kết nối CSDL khi Model không còn dùng nữa
    public function __destruct()
    {
        $this->pdo = null;
    }
}
