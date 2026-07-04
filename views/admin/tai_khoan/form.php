<?php
// Nếu $taiKhoan có dữ liệu -> đang Sửa, ngược lại đang Thêm mới
$dangSua = !empty($taiKhoan);
$action  = $dangSua ? BASE_URL . 'admin/tai-khoan/sua/' . $taiKhoan['id'] : BASE_URL . 'admin/tai-khoan/them';
?>

<div class="card shadow-sm" style="max-width:500px">
    <div class="card-body">
        <form action="<?= $action ?>" method="POST">
            <div class="mb-3">
                <label class="form-label">Họ tên</label>
                <input type="text" name="ho_ten" class="form-control"
                       value="<?= htmlspecialchars($taiKhoan['ho_ten'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= htmlspecialchars($taiKhoan['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu <?= $dangSua ? '(để trống nếu không đổi)' : '' ?></label>
                <input type="password" name="mat_khau" class="form-control" <?= $dangSua ? '' : 'required' ?>>
            </div>

            <div class="mb-3">
                <label class="form-label">Vai trò</label>
                <select name="vai_tro" class="form-select">
                    <option value="user"  <?= (($taiKhoan['vai_tro'] ?? '') === 'user')  ? 'selected' : '' ?>>Người dùng</option>
                    <option value="admin" <?= (($taiKhoan['vai_tro'] ?? '') === 'admin') ? 'selected' : '' ?>>Quản trị</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><?= $dangSua ? 'Cập nhật' : 'Thêm mới' ?></button>
            <a href="<?= BASE_URL ?>admin/tai-khoan" class="btn btn-secondary">Huỷ</a>
        </form>
    </div>
</div>
