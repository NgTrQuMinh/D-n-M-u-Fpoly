<?php
// Biến $sanPham, $danhSachBinhLuan, $diemDanhGia, $thongBao truyền từ SanPhamController::chiTiet()
?>

<!-- Thông báo sau khi gửi bình luận (nếu có) -->
<?php if (!empty($thongBao)): ?>
    <div class="alert alert-<?= $thongBao['loai'] ?>"><?= htmlspecialchars($thongBao['noi_dung']) ?></div>
<?php endif; ?>

<div class="row g-4">
    <!-- ===== CỘT TRÁI: HÌNH ẢNH ===== -->
    <div class="col-md-5">
        <img src="<?= $sanPham['hinh_anh'] ? BASE_ASSETS_UPLOADS . $sanPham['hinh_anh'] : BASE_ASSETS_UPLOADS . 'no-image.jpg' ?>"
             class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($sanPham['ten_san_pham']) ?>">
    </div>

    <!-- ===== CỘT PHẢI: THÔNG TIN SẢN PHẨM ===== -->
    <div class="col-md-7">
        <span class="badge bg-secondary"><?= htmlspecialchars($sanPham['ten_danh_muc']) ?></span>
        <h2 class="mt-2"><?= htmlspecialchars($sanPham['ten_san_pham']) ?></h2>

        <!-- Hiển thị số sao đánh giá trung bình -->
        <div class="text-warning mb-2">
            <?php $saoDay = round($diemDanhGia['diem_trung_binh']); for ($i = 1; $i <= 5; $i++): ?>
                <i class="bi <?= $i <= $saoDay ? 'bi-star-fill' : 'bi-star' ?>"></i>
            <?php endfor; ?>
            <span class="text-muted">(<?= (int)$diemDanhGia['so_luot_danh_gia'] ?> đánh giá)</span>
        </div>

        <h3 class="text-danger"><?= dinh_dang_tien($sanPham['gia']) ?></h3>

        <p><strong>Số lượng còn lại:</strong> <?= (int)$sanPham['so_luong'] ?></p>
        <p><strong>Lượt xem:</strong> <?= (int)$sanPham['luot_xem'] ?></p>

        <hr>
        <h5>Mô tả sản phẩm</h5>
        <p style="white-space:pre-line"><?= htmlspecialchars($sanPham['mo_ta']) ?></p>
    </div>
</div>

<hr class="my-4">

<!-- ===== KHỐI BÌNH LUẬN & ĐÁNH GIÁ ===== -->
<div class="row">
    <div class="col-md-7">
        <h4><i class="bi bi-chat-dots"></i> Bình luận (<?= count($danhSachBinhLuan) ?>)</h4>

        <?php if (empty($danhSachBinhLuan)): ?>
            <p class="text-muted">Chưa có bình luận nào. Hãy là người đầu tiên đánh giá sản phẩm này!</p>
        <?php else: ?>
            <?php foreach ($danhSachBinhLuan as $bl): ?>
                <div class="border rounded p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <strong><?= htmlspecialchars($bl['ho_ten']) ?></strong>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($bl['ngay_tao'])) ?></small>
                    </div>
                    <div class="text-warning">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bi <?= $i <= $bl['diem_danh_gia'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="mb-0"><?= htmlspecialchars($bl['noi_dung']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- ===== FORM GỬI BÌNH LUẬN MỚI ===== -->
    <div class="col-md-5">
        <h5>Gửi đánh giá của bạn</h5>
        <form action="<?= BASE_URL ?>san-pham/binh-luan" method="POST">
            <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">

            <div class="mb-2">
                <label class="form-label">Họ tên</label>
                <input type="text" name="ho_ten" class="form-control" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Số sao đánh giá</label>
                <select name="diem_danh_gia" class="form-select">
                    <option value="5">5 sao - Rất tốt</option>
                    <option value="4">4 sao - Tốt</option>
                    <option value="3">3 sao - Bình thường</option>
                    <option value="2">2 sao - Không hài lòng</option>
                    <option value="1">1 sao - Tệ</option>
                </select>
            </div>

            <div class="mb-2">
                <label class="form-label">Nội dung bình luận</label>
                <textarea name="noi_dung" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Gửi đánh giá</button>
        </form>
    </div>
</div>
