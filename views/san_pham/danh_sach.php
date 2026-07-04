<?php
// Biến $danhMuc, $danhSachSanPham được truyền từ SanPhamController::theoDanhMuc()
?>

<h3 class="mb-4"><i class="bi bi-grid"></i> Danh mục: <?= htmlspecialchars($danhMuc['ten_danh_muc']) ?></h3>

<div class="row g-3">
    <?php if (empty($danhSachSanPham)): ?>
        <p class="text-muted">Danh mục này chưa có sản phẩm nào.</p>
    <?php else: ?>
        <?php foreach ($danhSachSanPham as $sp): ?>
            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm">
                    <a href="<?= BASE_URL ?>san-pham/<?= $sp['slug'] ?>">
                        <img src="<?= $sp['hinh_anh'] ? BASE_ASSETS_UPLOADS . $sp['hinh_anh'] : BASE_ASSETS_UPLOADS . 'no-image.jpg' ?>"
                             class="card-img-top" style="height:180px;object-fit:cover" alt="<?= htmlspecialchars($sp['ten_san_pham']) ?>">
                    </a>
                    <div class="card-body">
                        <h6 class="card-title">
                            <a class="text-decoration-none text-dark" href="<?= BASE_URL ?>san-pham/<?= $sp['slug'] ?>">
                                <?= htmlspecialchars($sp['ten_san_pham']) ?>
                            </a>
                        </h6>
                        <p class="text-danger fw-bold mb-2"><?= dinh_dang_tien($sp['gia']) ?></p>
                        <p class="text-muted small mb-2"><i class="bi bi-eye"></i> <?= (int)$sp['luot_xem'] ?> lượt xem</p>

                        <!-- Nút thêm nhanh vào giỏ, số lượng mặc định = 1 -->
                        <?php if ($sp['so_luong'] > 0): ?>
                            <form action="<?= BASE_URL ?>gio-hang/them" method="POST">
                                <input type="hidden" name="san_pham_id" value="<?= $sp['id'] ?>">
                                <input type="hidden" name="so_luong" value="1">
                                <input type="hidden" name="tro_ve" value="<?= BASE_URL ?>danh-muc/<?= $danhMuc['slug'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="badge bg-secondary">Hết hàng</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
