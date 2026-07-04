<?php
// Biến $donHang truyền từ GioHangController::thanhCong()
?>

<div class="text-center py-5">
    <i class="bi bi-check-circle-fill text-success" style="font-size:70px"></i>
    <h2 class="mt-3">Đặt hàng thành công!</h2>
    <p class="text-muted">Mã đơn hàng của bạn là: <strong>#<?= $donHang['id'] ?></strong></p>
    <p>Tổng tiền: <strong class="text-danger"><?= dinh_dang_tien($donHang['tong_tien']) ?></strong></p>
    <p class="text-muted">Chúng tôi sẽ liên hệ số điện thoại <strong><?= htmlspecialchars($donHang['so_dien_thoai']) ?></strong> để xác nhận đơn hàng.</p>

    <a href="<?= BASE_URL ?>" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
</div>
