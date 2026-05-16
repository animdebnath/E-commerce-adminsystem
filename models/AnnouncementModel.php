<?php
require_once __DIR__ . '/Model.php';
class AnnouncementModel extends Model {
    public function all() { return $this->db->query("SELECT * FROM announcements ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC); }
    public function create($title, $body) {
        $stmt = $this->db->prepare("INSERT INTO announcements (title, body) VALUES (?, ?)");
        $stmt->bind_param('ss', $title, $body); return $stmt->execute();
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->bind_param('i', $id); return $stmt->execute();
    }
}
