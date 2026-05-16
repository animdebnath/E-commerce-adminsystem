<?php
require_once __DIR__ . '/Model.php';
class ActivityModel extends Model {
    public function recent($limit = 8) {
        $stmt = $this->db->prepare("SELECT * FROM activity_log ORDER BY id DESC LIMIT ?");
        $stmt->bind_param('i', $limit); $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
