<?php
require_once __DIR__ . '/Model.php';

class UserModel extends Model {

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function listByRole($role, $search = '') {
        $like = "%$search%";

        $stmt = $this->db->prepare("
            SELECT * 
            FROM users 
            WHERE role = ? 
            AND (name LIKE ? OR email LIKE ?) 
            ORDER BY id DESC
        ");

        $stmt->bind_param('sss', $role, $like, $like);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create($name, $email, $phone, $role, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("
            INSERT INTO users (name, email, phone, role, password, status) 
            VALUES (?, ?, ?, ?, ?, 'active')
        ");

        $stmt->bind_param('sssss', $name, $email, $phone, $role, $hash);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    // ✅ FIXED: stable + reliable + production-safe
    public function emailExists($email) {
        $stmt = $this->db->prepare("
            SELECT id 
            FROM users 
            WHERE email = ? 
            LIMIT 1
        ");

        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();

        return ($result && $result->num_rows > 0);
    }

    public function setStatus($id, $status) {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET status = ? 
            WHERE id = ?
        ");

        $stmt->bind_param('si', $status, $id);
        return $stmt->execute();
    }

    public function countByRole($role) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS c 
            FROM users 
            WHERE role = ?
        ");

        $stmt->bind_param('s', $role);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();

        return (int)($row['c'] ?? 0);
    }
}