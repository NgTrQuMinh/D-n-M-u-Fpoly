<?php

class BinhLuanModel extends BaseModel
{
    protected $table = 'binh_luan'; // Bảng binh_luan trong CSDL

    // Lấy toàn bộ bình luận của 1 sản phẩm, mới nhất lên đầu
    public function layTheoSanPham($sanPhamId)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE san_pham_id = :san_pham_id
                ORDER BY ngay_tao DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['san_pham_id' => $sanPhamId]);
        return $stmt->fetchAll();
    }

    // Tính điểm đánh giá trung bình + tổng số lượt đánh giá của 1 sản phẩm
    public function tinhDiemTrungBinh($sanPhamId)
    {
        $sql = "SELECT COALESCE(AVG(diem_danh_gia),0) AS diem_trung_binh,
                       COUNT(id) AS so_luot_danh_gia
                FROM {$this->table}
                WHERE san_pham_id = :san_pham_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['san_pham_id' => $sanPhamId]);
        return $stmt->fetch();
    }
}
