<?php
require_once __DIR__ . '/Model.php';

class ProductModel extends Model {

    public function all($search = '', $category_id = '', $seller_id = '') {
        $like = "%$search%";

        $sql = "SELECT p.*, c.name AS category_name, s.shop_name 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                JOIN sellers s ON p.seller_id = s.id
                WHERE p.name LIKE ?";

        $types = 's';
        $params = [$like];

        if ($category_id !== '') {
            $sql .= " AND p.category_id = ?";
            $types .= 'i';
            $params[] = (int)$category_id;
        }

        if ($seller_id !== '') {
            $sql .= " AND p.seller_id = ?";
            $types .= 'i';
            $params[] = (int)$seller_id;
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ✅ FIXED create()
    public function create($name, $price, $stock, $category_id, $seller_id, $description = '') {

        $stmt = $this->db->prepare("
            INSERT INTO products 
            (name, price, stock, category_id, seller_id, description, status) 
            VALUES (?, ?, ?, ?, ?, ?, 'active')
        ");

        // FIX: correct type mapping
        $stmt->bind_param(
            'sdiiis',
            $name,
            $price,
            $stock,
            $category_id,
            $seller_id,
            $description
        );

        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function setStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE products SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $status, $id);
        return $stmt->execute();
    }

    public function setFeatured($id, $featured) {
        $stmt = $this->db->prepare("UPDATE products SET is_featured = ? WHERE id = ?");
        $stmt->bind_param('ii', $featured, $id);
        return $stmt->execute();
    }

    public function countAll() {
        return (int)$this->db->query("SELECT COUNT(*) c FROM products")
            ->fetch_assoc()['c'];
    }

    public function featured() {
        return $this->db->query("
            SELECT p.*, s.shop_name 
            FROM products p 
            JOIN sellers s ON p.seller_id=s.id 
            WHERE p.is_featured=1
        ")->fetch_all(MYSQLI_ASSOC);
    }
}