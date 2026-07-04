<?php
// Biến $danhSachDanhMuc truyền từ AdminDanhMucController::danhSach()
?>

<a href="<?= BASE_URL ?>admin/danh-muc/them" class="btn btn-success mb-3">
    <i class="bi bi-plus-lg"></i> Thêm danh mục
</a>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-dark">
        <tr>
            <th style="width:60px">ID</th>
            <th>Tên danh mục</th>
            <th style="width:130px">Số sản phẩm</th>
            <th style="width:180px">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($danhSachDanhMuc)): ?>
            <tr><td colspan="4" class="text-center text-muted">Chưa có danh mục nào</td></tr>
        <?php else: ?>
            <?php foreach ($danhSachDanhMuc as $dm): ?>
                <tr>
                    <td><?= $dm['id'] ?></td>
                    <td><?= htmlspecialchars($dm['ten_danh_muc']) ?></td>
                    <td><?= $dm['so_san_pham'] ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>admin/danh-muc/sua/<?= $dm['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Sửa
                        </a>
                        <a href="<?= BASE_URL ?>admin/danh-muc/xoa/<?= $dm['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn chắc chắn muốn xoá danh mục này?')">
                            <i class="bi bi-trash"></i> Xoá
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
