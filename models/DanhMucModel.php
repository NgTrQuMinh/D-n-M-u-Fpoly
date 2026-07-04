<?php

class DanhMucModel extends BaseModel
{
    protected $table = 'danh_muc'; // Bảng danh_muc trong CSDL

    // Tìm danh mục theo slug (dùng cho URL /danh-muc/{slug})
    public function timTheoSlug($slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    // Đếm số sản phẩm trong từng danh mục, phục vụ hiển thị ở sidebar
    public function layDanhMucKemSoLuong()
    {
        $sql = "SELECT dm.*, COUNT(sp.id) AS so_san_pham
                FROM danh_muc dm
                LEFT JOIN san_pham sp ON sp.danh_muc_id = dm.id
                GROUP BY dm.id
                ORDER BY dm.ten_danh_muc ASC";
        return $this->pdo->query($sql)->fetchAll();
    }
}
