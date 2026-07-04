<?php
// Biến $chiTietGioHang (mảng sản phẩm), $tongTien được truyền từ GioHangController::xem()
?>

<h3 class="mb-4"><i class="bi bi-cart3"></i> Giỏ hàng của bạn</h3>

<?php if (empty($chiTietGioHang)): ?>
    <p class="text-muted">Giỏ hàng đang trống.</p>
    <a href="<?= BASE_URL ?>" class="btn btn-primary">Tiếp tục mua sắm</a>
<?php else: ?>
    <!-- Form cập nhật số lượng, submit tới /gio-hang/cap-nhat -->
    <form action="<?= BASE_URL ?>gio-hang/cap-nhat" method="POST">
        <table class="table bg-white align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Sản phẩm</th>
                    <th style="width:120px">Đơn giá</th>
                    <th style="width:120px">Số lượng</th>
                    <th style="width:140px">Thành tiền</th>
                    <th style="width:60px"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chiTietGioHang as $sp): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="<?= $sp['hinh_anh'] ? BASE_ASSETS_UPLOADS . $sp['hinh_anh'] : BASE_ASSETS_UPLOADS . 'no-image.jpg' ?>"
                                     width="60" height="60" style="object-fit:cover" class="rounded">
                                <a href="<?= BASE_URL ?>san-pham/<?= $sp['slug'] ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($sp['ten_san_pham']) ?>
                                </a>
                            </div>
                        </td>
                        <td><?= dinh_dang_tien($sp['gia']) ?></td>
                        <td>
                            <!-- Tên input dạng mảng so_luong[id_san_pham] để Controller đọc theo từng dòng -->
                            <input type="number" min="0" name="so_luong[<?= $sp['id'] ?>]" value="<?= $sp['so_luong'] ?>"
                                   class="form-control form-control-sm" style="width:80px">
                        </td>
                        <td class="text-danger fw-bold"><?= dinh_dang_tien($sp['thanh_tien']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>gio-hang/xoa/<?= $sp['id'] ?>" class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Xoá sản phẩm này khỏi giỏ hàng?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-repeat"></i> Cập nhật giỏ hàng
            </button>
            <h4 class="mb-0">Tổng tiền: <span class="text-danger"><?= dinh_dang_tien($tongTien) ?></span></h4>
        </div>
    </form>

    <div class="text-end mt-3">
        <a href="<?= BASE_URL ?>thanh-toan" class="btn btn-success btn-lg">
            <i class="bi bi-bag-check"></i> Tiến hành đặt hàng
        </a>
    </div>
<?php endif; ?>
