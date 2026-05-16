<?php
require_once __DIR__ . '/Model.php';
class CouponModel extends Model {
    public function all() { return $this->db->query("SELECT * FROM coupons ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC); }
    public function exists($code) {
        $stmt = $this->db->prepare("SELECT id FROM coupons WHERE code = ?");
        $stmt->bind_param('s', $code); $stmt->execute();
        return (bool)$stmt->get_result()->fetch_assoc();
    }
    public function create($code, $discount, $valid_until) {
        $stmt = $this->db->prepare("INSERT INTO coupons (code, discount_percent, valid_until) VALUES (?, ?, ?)");
        $stmt->bind_param('sds', $code, $discount, $valid_until);
        return $stmt->execute();
    }
    public function setActive($id, $active) {
        $stmt = $this->db->prepare("UPDATE coupons SET is_active = ? WHERE id = ?");
        $stmt->bind_param('ii', $active, $id);
        return $stmt->execute();
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM coupons WHERE id = ?");
        $stmt->bind_param('i', $id); return $stmt->execute();
    }
}
