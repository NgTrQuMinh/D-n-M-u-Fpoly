<?php
// Biến $danhSachDonHang truyền từ KhachHangController::taiKhoanCuaToi()

// Ánh xạ trạng thái sang tiếng Việt + màu badge để hiển thị đẹp
$nhanTrangThai = [
    'cho_xu_ly' => ['Chờ xử lý', 'secondary'],
    'dang_giao' => ['Đang giao', 'warning'],
    'hoan_thanh' => ['Hoàn thành', 'success'],
    'da_huy' => ['Đã huỷ', 'danger'],
];
?>

<h3 class="mb-4"><i class="bi bi-receipt"></i> Đơn hàng của tôi</h3>

<?php if (empty($danhSachDonHang)): ?>
    <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
<?php else: ?>
    <table class="table bg-white align-middle">
        <thead class="table-dark">
            <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($danhSachDonHang as $dh): ?>
                <tr>
                    <td>#<?= $dh['id'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($dh['ngay_tao'])) ?></td>
                    <td class="text-danger fw-bold"><?= dinh_dang_tien($dh['tong_tien']) ?></td>
                    <td>
                        <span class="badge bg-<?= $nhanTrangThai[$dh['trang_thai']][1] ?>">
                            <?= $nhanTrangThai[$dh['trang_thai']][0] ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
