<?php
// Biến $chiTietGioHang, $tongTien, $khachHang truyền từ GioHangController::thanhToan()
?>

<h3 class="mb-4"><i class="bi bi-bag-check"></i> Thông tin đặt hàng</h3>

<div class="row g-4">
    <!-- ===== FORM THÔNG TIN GIAO HÀNG ===== -->
    <div class="col-md-7">
        <form action="<?= BASE_URL ?>thanh-toan" method="POST">
            <div class="mb-3">
                <label class="form-label">Họ tên người nhận</label>
                <input type="text" name="ho_ten" class="form-control"
                       value="<?= htmlspecialchars($khachHang['ho_ten'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa chỉ nhận hàng</label>
                <textarea name="dia_chi" class="form-control" rows="2" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Ghi chú (không bắt buộc)</label>
                <textarea name="ghi_chu" class="form-control" rows="2"></textarea>
            </div>

            <div class="alert alert-info small">
                <i class="bi bi-info-circle"></i> Thanh toán khi nhận hàng (COD).
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100">Xác nhận đặt hàng</button>
        </form>
    </div>

    <!-- ===== TÓM TẮT ĐƠN HÀNG ===== -->
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Đơn hàng của bạn</h5>
                <hr>
                <?php foreach ($chiTietGioHang as $sp): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?= htmlspecialchars($sp['ten_san_pham']) ?> x<?= $sp['so_luong'] ?></span>
                        <span><?= dinh_dang_tien($sp['thanh_tien']) ?></span>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Tổng cộng</span>
                    <span class="text-danger"><?= dinh_dang_tien($tongTien) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
