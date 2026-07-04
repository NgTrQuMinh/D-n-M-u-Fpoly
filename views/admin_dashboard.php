<?php
// Biến $tongSanPham, $tongDanhMuc, $tongTaiKhoan truyền từ AdminController::dashboard()
?>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card text-white bg-primary shadow-sm">
            <div class="card-body">
                <h6><i class="bi bi-box-seam"></i> Tổng sản phẩm</h6>
                <h2><?= $tongSanPham ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success shadow-sm">
            <div class="card-body">
                <h6><i class="bi bi-tags"></i> Tổng danh mục</h6>
                <h2><?= $tongDanhMuc ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning shadow-sm">
            <div class="card-body">
                <h6><i class="bi bi-people"></i> Tổng tài khoản</h6>
                <h2><?= $tongTaiKhoan ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger shadow-sm">
            <div class="card-body">
                <h6><i class="bi bi-receipt"></i> Tổng đơn hàng</h6>
                <h2><?= $tongDonHang ?></h2>
            </div>
        </div>
    </div>
</div>

<p class="text-muted mt-4">Dùng menu bên trái để quản lý Danh mục / Sản phẩm / Tài khoản.</p>
