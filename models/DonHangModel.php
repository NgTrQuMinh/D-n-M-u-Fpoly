<?php

class DonHangModel extends BaseModel
{
    protected $table = 'don_hang'; // Bảng don_hang trong CSDL

    // Danh sách đơn hàng cho Admin, mới nhất lên đầu
    public function layTatCa($orderBy = 'id DESC')
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        return $this->pdo->query($sql)->fetchAll();
    }

    // Danh sách đơn hàng của 1 khách hàng cụ thể (dùng cho trang "Đơn hàng của tôi")
    public function layTheoTaiKhoan($taiKhoanId)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE tai_khoan_id = :tai_khoan_id
                ORDER BY ngay_tao DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['tai_khoan_id' => $taiKhoanId]);
        return $stmt->fetchAll();
    }

    // Cập nhật trạng thái đơn hàng (Admin dùng để duyệt/giao/huỷ đơn)
    public function capNhatTrangThai($id, $trangThai)
    {
        $sql = "UPDATE {$this->table} SET trang_thai = :trang_thai WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['trang_thai' => $trangThai, 'id' => $id]);
    }
}
