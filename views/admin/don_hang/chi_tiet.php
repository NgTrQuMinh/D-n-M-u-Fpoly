<?php
// Biến $donHang, $danhSachChiTiet truyền từ AdminDonHangController::chiTiet()
?>

<a href="<?= BASE_URL ?>admin/don-hang" class="btn btn-secondary btn-sm mb-3">
    <i class="bi bi-arrow-left"></i> Quay lại danh sách
</a>

<div class="row g-4">
    <!-- ===== THÔNG TIN GIAO HÀNG ===== -->
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Thông tin giao hàng</h5>
                <p><strong>Họ tên:</strong> <?= htmlspecialchars($donHang['ho_ten']) ?></p>
                <p><strong>SĐT:</strong> <?= htmlspecialchars($donHang['so_dien_thoai']) ?></p>
                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($donHang['dia_chi']) ?></p>
                <p><strong>Ghi chú:</strong> <?= htmlspecialchars($donHang['ghi_chu'] ?: 'Không có') ?></p>
                <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($donHang['ngay_tao'])) ?></p>

                <!-- Form đổi trạng thái đơn hàng -->
                <form action="<?= BASE_URL ?>admin/don-hang/cap-nhat-trang-thai/<?= $donHang['id'] ?>" method="POST" class="mt-3">
                    <label class="form-label">Trạng thái đơn hàng</label>
                    <div class="input-group">
                        <select name="trang_thai" class="form-select">
                            <option value="cho_xu_ly" <?= $donHang['trang_thai'] === 'cho_xu_ly' ? 'selected' : '' ?>>Chờ xử lý</option>
                            <option value="dang_giao" <?= $donHang['trang_thai'] === 'dang_giao' ? 'selected' : '' ?>>Đang giao</option>
                            <option value="hoan_thanh" <?= $donHang['trang_thai'] === 'hoan_thanh' ? 'selected' : '' ?>>Hoàn thành</option>
                            <option value="da_huy" <?= $donHang['trang_thai'] === 'da_huy' ? 'selected' : '' ?>>Đã huỷ</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== DANH SÁCH SẢN PHẨM TRONG ĐƠN ===== -->
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Sản phẩm đã đặt</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>SL</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($danhSachChiTiet as $ct): ?>
                            <tr>
                                <td><?= htmlspecialchars($ct['ten_san_pham']) ?></td>
                                <td><?= dinh_dang_tien($ct['gia']) ?></td>
                                <td><?= $ct['so_luong'] ?></td>
                                <td><?= dinh_dang_tien($ct['thanh_tien']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Tổng cộng</td>
                            <td class="text-danger"><?= dinh_dang_tien($donHang['tong_tien']) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
