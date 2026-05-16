<?php
require_once __DIR__ . '/Model.php';
class CategoryModel extends Model {
    public function all() {
        $sql = "SELECT c.*, p.name AS parent_name FROM categories c
                LEFT JOIN categories p ON c.parent_id = p.id ORDER BY c.id DESC";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id); $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function create($name, $parent_id) {
        $stmt = $this->db->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
        $pid = $parent_id ?: null;
        $stmt->bind_param('si', $name, $pid);
        return $stmt->execute();
    }
    public function update($id, $name, $parent_id) {
        $pid = $parent_id ?: null;
        $stmt = $this->db->prepare("UPDATE categories SET name = ?, parent_id = ? WHERE id = ?");
        $stmt->bind_param('sii', $name, $pid, $id);
        return $stmt->execute();
    }
    public function delete($id) {
        // Prevent delete if products exist
        $stmt = $this->db->prepare("SELECT COUNT(*) c FROM products WHERE category_id = ?");
        $stmt->bind_param('i', $id); $stmt->execute();
        if ((int)$stmt->get_result()->fetch_assoc()['c'] > 0) return false;
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    public function topCategories($limit = 5) {
        $sql = "SELECT c.name, COUNT(p.id) total FROM categories c
                LEFT JOIN products p ON p.category_id = c.id
                GROUP BY c.id ORDER BY total DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $limit); $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
