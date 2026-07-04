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
        $cols  = implode(',', array_keys($data));                       // ten,gia,...
        $binds = implode(',', array_map(fn($c) => ":$c", array_keys($data))); // :ten,:gia,...

        $sql = "INSERT INTO {$this->table} ($cols) VALUES ($binds)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return $this->pdo->lastInsertId(); // Trả về id vừa thêm
    }

    // Cập nhật 1 bản ghi theo id, $data dạng ['cot' => 'gia_tri', ...]
    public function capNhat($id, $data)
    {
        // Ghép chuỗi "cot1 = :cot1, cot2 = :cot2, ..."
        $set = implode(',', array_map(fn($c) => "$c = :$c", array_keys($data)));

        $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
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
