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
                        <p class="text-danger fw-bold mb-0"><?= dinh_dang_tien($sp['gia']) ?></p>
                        <p class="text-muted small mb-0"><i class="bi bi-eye"></i> <?= (int)$sp['luot_xem'] ?> lượt xem</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
