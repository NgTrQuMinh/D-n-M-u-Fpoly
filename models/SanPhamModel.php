<?php

class SanPhamModel extends BaseModel
{
    protected $table = 'san_pham'; // Bảng san_pham trong CSDL

    // Danh sách sản phẩm mới nhất (cho trang chủ), kèm tên danh mục
    public function layMoiNhat($gioiHan = 8)
    {
        $sql = "SELECT sp.*, dm.ten_danh_muc
                FROM san_pham sp
                JOIN danh_muc dm ON dm.id = sp.danh_muc_id
                ORDER BY sp.ngay_tao DESC
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$gioiHan, PDO::PARAM_INT); // ép kiểu int để tránh lỗi bind LIMIT
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Danh sách sản phẩm được yêu thích nhất = điểm đánh giá trung bình từ bảng bình_luận cao nhất
    public function layYeuThichNhat($gioiHan = 8)
    {
        $sql = "SELECT sp.*, dm.ten_danh_muc,
                       COALESCE(AVG(bl.diem_danh_gia), 0) AS diem_trung_binh,
                       COUNT(bl.id) AS so_luot_danh_gia
                FROM san_pham sp
                JOIN danh_muc dm ON dm.id = sp.danh_muc_id
                LEFT JOIN binh_luan bl ON bl.san_pham_id = sp.id
                GROUP BY sp.id
                ORDER BY diem_trung_binh DESC, so_luot_danh_gia DESC
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$gioiHan, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Danh sách sản phẩm lọc theo danh mục (dùng cho trang /danh-muc/{slug})
    public function layTheoDanhMuc($danhMucId)
    {
        $sql = "SELECT sp.*, dm.ten_danh_muc
                FROM san_pham sp
                JOIN danh_muc dm ON dm.id = sp.danh_muc_id
                WHERE sp.danh_muc_id = :danh_muc_id
                ORDER BY sp.ngay_tao DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['danh_muc_id' => $danhMucId]);
        return $stmt->fetchAll();
    }

    // Tìm 1 sản phẩm theo slug, kèm tên danh mục (dùng cho trang chi tiết)
    public function timTheoSlug($slug)
    {
        $sql = "SELECT sp.*, dm.ten_danh_muc
                FROM san_pham sp
                JOIN danh_muc dm ON dm.id = sp.danh_muc_id
                WHERE sp.slug = :slug LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    // Tăng lượt xem thêm 1 mỗi khi có người vào trang chi tiết
    public function tangLuotXem($id)
    {
        $sql = "UPDATE san_pham SET luot_xem = luot_xem + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    // Danh sách sản phẩm kèm tên danh mục, dùng cho trang quản trị (admin)
    public function layTatCaKemDanhMuc()
    {
        $sql = "SELECT sp.*, dm.ten_danh_muc
                FROM san_pham sp
                JOIN danh_muc dm ON dm.id = sp.danh_muc_id
                ORDER BY sp.id DESC";
        return $this->pdo->query($sql)->fetchAll();
    }
}
