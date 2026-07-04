<?php
// Biến $sanPhamMoiNhat, $sanPhamYeuThich được truyền từ HomeController::trangChu()
?>

<!-- ===== KHỐI SẢN PHẨM MỚI NHẤT ===== -->
<h3 class="mb-3"><i class="bi bi-stars text-warning"></i> Sản phẩm mới nhất</h3>
<div class="row g-3 mb-5">
    <?php if (empty($sanPhamMoiNhat)): ?>
        <p class="text-muted">Chưa có sản phẩm nào.</p>
    <?php else: ?>
        <?php foreach ($sanPhamMoiNhat as $sp): ?>
            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm">
                    <a href="<?= BASE_URL ?>san-pham/<?= $sp['slug'] ?>">
                        <img src="<?= $sp['hinh_anh'] ? BASE_ASSETS_UPLOADS . $sp['hinh_anh'] : BASE_ASSETS_UPLOADS . 'no-image.jpg' ?>"
                             class="card-img-top" style="height:180px;object-fit:cover" alt="<?= htmlspecialchars($sp['ten_san_pham']) ?>">
                    </a>
                    <div class="card-body">
                        <span class="badge bg-secondary mb-1"><?= htmlspecialchars($sp['ten_danh_muc']) ?></span>
                        <h6 class="card-title">
                            <a class="text-decoration-none text-dark" href="<?= BASE_URL ?>san-pham/<?= $sp['slug'] ?>">
                                <?= htmlspecialchars($sp['ten_san_pham']) ?>
                            </a>
                        </h6>
                        <p class="text-danger fw-bold mb-0"><?= dinh_dang_tien($sp['gia']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- ===== KHỐI SẢN PHẨM ĐƯỢC YÊU THÍCH NHẤT (điểm đánh giá trung bình cao nhất) ===== -->
<h3 class="mb-3"><i class="bi bi-heart-fill text-danger"></i> Sản phẩm được yêu thích nhất</h3>
<div class="row g-3">
    <?php if (empty($sanPhamYeuThich)): ?>
        <p class="text-muted">Chưa có sản phẩm nào được đánh giá.</p>
    <?php else: ?>
        <?php foreach ($sanPhamYeuThich as $sp): ?>
            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm">
                    <a href="<?= BASE_URL ?>san-pham/<?= $sp['slug'] ?>">
                        <img src="<?= $sp['hinh_anh'] ? BASE_ASSETS_UPLOADS . $sp['hinh_anh'] : BASE_ASSETS_UPLOADS . 'no-image.jpg' ?>"
                             class="card-img-top" style="height:180px;object-fit:cover" alt="<?= htmlspecialchars($sp['ten_san_pham']) ?>">
                    </a>
                    <div class="card-body">
                        <span class="badge bg-secondary mb-1"><?= htmlspecialchars($sp['ten_danh_muc']) ?></span>
                        <h6 class="card-title">
                            <a class="text-decoration-none text-dark" href="<?= BASE_URL ?>san-pham/<?= $sp['slug'] ?>">
                                <?= htmlspecialchars($sp['ten_san_pham']) ?>
                            </a>
                        </h6>
                        <p class="text-danger fw-bold mb-1"><?= dinh_dang_tien($sp['gia']) ?></p>
                        <p class="mb-0 small text-warning">
                            <?php
                            // Vẽ số sao theo điểm trung bình (làm tròn)
                            $saoDay = round($sp['diem_trung_binh']);
                            for ($i = 1; $i <= 5; $i++):
                            ?>
                                <i class="bi <?= $i <= $saoDay ? 'bi-star-fill' : 'bi-star' ?>"></i>
                            <?php endfor; ?>
                            <span class="text-muted">(<?= (int)$sp['so_luot_danh_gia'] ?>)</span>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
