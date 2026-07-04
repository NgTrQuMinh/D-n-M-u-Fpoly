<?php
// Biến $danhSachSanPham truyền từ AdminSanPhamController::danhSach()
?>

<a href="<?= BASE_URL ?>admin/san-pham/them" class="btn btn-success mb-3">
    <i class="bi bi-plus-lg"></i> Thêm sản phẩm
</a>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-dark">
        <tr>
            <th style="width:60px">Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th style="width:80px">Kho</th>
            <th style="width:180px">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($danhSachSanPham)): ?>
            <tr><td colspan="6" class="text-center text-muted">Chưa có sản phẩm nào</td></tr>
        <?php else: ?>
            <?php foreach ($danhSachSanPham as $sp): ?>
                <tr>
                    <td>
                        <img src="<?= $sp['hinh_anh'] ? BASE_ASSETS_UPLOADS . $sp['hinh_anh'] : BASE_ASSETS_UPLOADS . 'no-image.jpg' ?>"
                             width="50" height="50" style="object-fit:cover" class="rounded">
                    </td>
                    <td><?= htmlspecialchars($sp['ten_san_pham']) ?></td>
                    <td><?= htmlspecialchars($sp['ten_danh_muc']) ?></td>
                    <td><?= dinh_dang_tien($sp['gia']) ?></td>
                    <td><?= (int)$sp['so_luong'] ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>admin/san-pham/sua/<?= $sp['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Sửa
                        </a>
                        <a href="<?= BASE_URL ?>admin/san-pham/xoa/<?= $sp['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn chắc chắn muốn xoá sản phẩm này?')">
                            <i class="bi bi-trash"></i> Xoá
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
