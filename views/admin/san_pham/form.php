<?php
// Nếu $sanPham có dữ liệu -> đang Sửa, ngược lại đang Thêm mới
$dangSua = !empty($sanPham);
$action  = $dangSua ? BASE_URL . 'admin/san-pham/sua/' . $sanPham['id'] : BASE_URL . 'admin/san-pham/them';
?>

<div class="card shadow-sm" style="max-width:650px">
    <div class="card-body">
        <!-- enctype bắt buộc phải có multipart/form-data để upload được file ảnh -->
        <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="ten_san_pham" class="form-control"
                       value="<?= htmlspecialchars($sanPham['ten_san_pham'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="danh_muc_id" class="form-select" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($danhSachDanhMuc as $dm): ?>
                        <option value="<?= $dm['id'] ?>"
                            <?= (isset($sanPham['danh_muc_id']) && $sanPham['danh_muc_id'] == $dm['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dm['ten_danh_muc']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá bán (đ)</label>
                    <input type="number" step="1000" min="0" name="gia" class="form-control"
                           value="<?= htmlspecialchars($sanPham['gia'] ?? 0) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Số lượng trong kho</label>
                    <input type="number" min="0" name="so_luong" class="form-control"
                           value="<?= htmlspecialchars($sanPham['so_luong'] ?? 0) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả sản phẩm</label>
                <textarea name="mo_ta" class="form-control" rows="4"><?= htmlspecialchars($sanPham['mo_ta'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Hình ảnh <?= $dangSua ? '(để trống nếu không đổi ảnh)' : '' ?></label>
                <input type="file" name="hinh_anh" class="form-control" accept="image/*">

                <?php if ($dangSua && !empty($sanPham['hinh_anh'])): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . $sanPham['hinh_anh'] ?>" width="100" class="mt-2 rounded">
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary"><?= $dangSua ? 'Cập nhật' : 'Thêm mới' ?></button>
            <a href="<?= BASE_URL ?>admin/san-pham" class="btn btn-secondary">Huỷ</a>
        </form>
    </div>
</div>
