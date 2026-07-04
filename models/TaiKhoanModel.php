<?php

class TaiKhoanModel extends BaseModel
{
    protected $table = 'tai_khoan'; // Bảng tai_khoan trong CSDL

    // Tìm tài khoản theo email (dùng để kiểm tra trùng email & đăng nhập)
    public function timTheoEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
