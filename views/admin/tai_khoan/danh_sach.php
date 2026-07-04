<?php
// Biến $danhSachTaiKhoan truyền từ AdminTaiKhoanController::danhSach()
?>

<a href="<?= BASE_URL ?>admin/tai-khoan/them" class="btn btn-success mb-3">
    <i class="bi bi-plus-lg"></i> Thêm tài khoản
</a>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-dark">
        <tr>
            <th style="width:60px">ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th style="width:120px">Vai trò</th>
            <th style="width:180px">Ngày tạo</th>
            <th style="width:180px">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($danhSachTaiKhoan)): ?>
            <tr><td colspan="6" class="text-center text-muted">Chưa có tài khoản nào</td></tr>
        <?php else: ?>
            <?php foreach ($danhSachTaiKhoan as $tk): ?>
                <tr>
                    <td><?= $tk['id'] ?></td>
                    <td><?= htmlspecialchars($tk['ho_ten']) ?></td>
                    <td><?= htmlspecialchars($tk['email']) ?></td>
                    <td>
                        <span class="badge bg-<?= $tk['vai_tro'] === 'admin' ? 'danger' : 'secondary' ?>">
                            <?= $tk['vai_tro'] === 'admin' ? 'Quản trị' : 'Người dùng' ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($tk['ngay_tao'])) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>admin/tai-khoan/sua/<?= $tk['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Sửa
                        </a>
                        <a href="<?= BASE_URL ?>admin/tai-khoan/xoa/<?= $tk['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn chắc chắn muốn xoá tài khoản này?')">
                            <i class="bi bi-trash"></i> Xoá
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
