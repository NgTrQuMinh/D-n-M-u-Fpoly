<?php
// Biến $danhSachDonHang truyền từ AdminDonHangController::danhSach()
$nhanTrangThai = [
    'cho_xu_ly' => ['Chờ xử lý', 'secondary'],
    'dang_giao' => ['Đang giao', 'warning'],
    'hoan_thanh' => ['Hoàn thành', 'success'],
    'da_huy' => ['Đã huỷ', 'danger'],
];
?>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-dark">
        <tr>
            <th style="width:70px">Mã đơn</th>
            <th>Khách hàng</th>
            <th>Số điện thoại</th>
            <th>Tổng tiền</th>
            <th style="width:130px">Trạng thái</th>
            <th style="width:150px">Ngày đặt</th>
            <th style="width:100px">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($danhSachDonHang)): ?>
            <tr><td colspan="7" class="text-center text-muted">Chưa có đơn hàng nào</td></tr>
        <?php else: ?>
            <?php foreach ($danhSachDonHang as $dh): ?>
                <tr>
                    <td>#<?= $dh['id'] ?></td>
                    <td><?= htmlspecialchars($dh['ho_ten']) ?></td>
                    <td><?= htmlspecialchars($dh['so_dien_thoai']) ?></td>
                    <td class="text-danger fw-bold"><?= dinh_dang_tien($dh['tong_tien']) ?></td>
                    <td>
                        <span class="badge bg-<?= $nhanTrangThai[$dh['trang_thai']][1] ?>">
                            <?= $nhanTrangThai[$dh['trang_thai']][0] ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($dh['ngay_tao'])) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>admin/don-hang/chi-tiet/<?= $dh['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Xem
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
