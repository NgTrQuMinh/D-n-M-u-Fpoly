<?php
// Nếu $danhMuc có dữ liệu -> đang Sửa, ngược lại đang Thêm mới
// Action của form tự đổi theo trạng thái để dùng chung 1 file cho cả 2 chức năng
$dangSua = !empty($danhMuc);
$action  = $dangSua ? BASE_URL . 'admin/danh-muc/sua/' . $danhMuc['id'] : BASE_URL . 'admin/danh-muc/them';
?>

<div class="card shadow-sm" style="max-width:500px">
    <div class="card-body">
        <form action="<?= $action ?>" method="POST">
            <div class="mb-3">
                <label class="form-label">Tên danh mục</label>
                <input type="text" name="ten_danh_muc" class="form-control"
                       value="<?= htmlspecialchars($danhMuc['ten_danh_muc'] ?? '') ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $dangSua ? 'Cập nhật' : 'Thêm mới' ?>
            </button>
            <a href="<?= BASE_URL ?>admin/danh-muc" class="btn btn-secondary">Huỷ</a>
        </form>
    </div>
</div>
