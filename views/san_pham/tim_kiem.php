<?php
// Biến $danhSachSanPham truyền từ SanPhamController::timKiem()
$tuKhoa = $_GET['q'] ?? '';
?>

<h3 class="mb-4"><i class="bi bi-search"></i> Kết quả tìm kiếm cho: "<?= htmlspecialchars($tuKhoa) ?>"</h3>

<div class="row g-3">
    <?php if (empty($danhSachSanPham)): ?>
        <p class="text-muted">Không tìm thấy sản phẩm phù hợp.</p>
    <?php else: ?>
        <?php foreach ($danhSachSanPham as $sp): ?>
            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm">
                    <a href="<?= BASE_URL ?>san-pham/<?= $sp['slug'] ?>">
                        <img src="<?= $sp['hinh_anh'] ? BASE_ASSETS_UPLOADS . $sp['hinh_anh'] : BASE_ASSETS_UPLOADS . 'no-image.jpg' ?>"
                             class="card-img-top" style="height:180px;object-fit:cover">
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
