<?php
require_once __DIR__ . '/Model.php';
class DisputeModel extends Model {
    public function all() {
        return $this->db->query("SELECT d.*, u.name AS customer_name FROM disputes d JOIN users u ON d.customer_id=u.id ORDER BY d.id DESC")->fetch_all(MYSQLI_ASSOC);
    }
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM disputes WHERE id = ?");
        $stmt->bind_param('i', $id); $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function resolve($id, $notes) {
        $stmt = $this->db->prepare("UPDATE disputes SET admin_notes = ?, status='resolved' WHERE id = ?");
        $stmt->bind_param('si', $notes, $id);
        return $stmt->execute();
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM disputes WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}