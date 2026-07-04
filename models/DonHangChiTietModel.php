<?php

class DonHangChiTietModel extends BaseModel
{
    protected $table = 'don_hang_chi_tiet'; // Bảng don_hang_chi_tiet trong CSDL

    // Lấy toàn bộ sản phẩm trong 1 đơn hàng (dùng cho trang chi tiết đơn hàng)
    public function layTheoDonHang($donHangId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE don_hang_id = :don_hang_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['don_hang_id' => $donHangId]);
        return $stmt->fetchAll();
    }
}
