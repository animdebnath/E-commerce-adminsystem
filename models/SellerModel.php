<?php
require_once __DIR__ . '/Model.php';

class SellerModel extends Model {

    // ===================== GET ALL SELLERS =====================
    public function all($search = '', $status = '')
    {
        $like = "%$search%";

        $sql = "SELECT s.*, u.name AS user_name, u.email, u.phone
                FROM sellers s
                JOIN users u ON s.user_id = u.id
                WHERE (s.shop_name LIKE ? OR u.name LIKE ? OR u.email LIKE ?)";

        $params = [$like, $like, $like];
        $types = "sss";

        if ($status != '') {
            $sql .= " AND s.approval_status=?";
            $params[] = $status;
            $types .= "s";
        }

        $sql .= " ORDER BY s.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ===================== FIND ONE SELLER =====================
    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT s.*, u.name AS user_name, u.email, u.phone, s.user_id
            FROM sellers s
            JOIN users u ON s.user_id = u.id
            WHERE s.id=?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // ===================== CREATE SELLER =====================
    public function create($user_id, $shop_name)
    {
        $stmt = $this->db->prepare("
            INSERT INTO sellers (user_id, shop_name)
            VALUES (?, ?)
        ");

        $stmt->bind_param("is", $user_id, $shop_name);
        return $stmt->execute();
    }

    // ===================== UPDATE SELLER =====================
    public function updateSeller($id, $user_id, $shop_name, $name, $email, $phone)
    {
        // Update USERS table
        $stmt1 = $this->db->prepare("
            UPDATE users 
            SET name = ?, email = ?, phone = ?
            WHERE id = ?
        ");

        $stmt1->bind_param("sssi", $name, $email, $phone, $user_id);
        $stmt1->execute();

        // Update SELLERS table
        $stmt2 = $this->db->prepare("
            UPDATE sellers 
            SET shop_name = ?
            WHERE id = ?
        ");

        $stmt2->bind_param("si", $shop_name, $id);

        return $stmt2->execute();
    }

    // ===================== DELETE SELLER =====================
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM sellers WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ===================== APPROVAL STATUS =====================
    public function setApproval($id, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE sellers 
            SET approval_status=? 
            WHERE id=?
        ");

        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // ===================== SUSPEND / ACTIVE =====================
    public function setSuspended($id, $val)
    {
        $stmt = $this->db->prepare("
            UPDATE sellers 
            SET is_suspended=?
            WHERE id=?
        ");

        $stmt->bind_param("ii", $val, $id);
        return $stmt->execute();
    }

    // ===================== TOP SELLERS (FIX ADDED) =====================
    public function topSellers($limit = 5)
    {
        $sql = "
            SELECT 
                s.id,
                s.shop_name,
                u.name AS seller_name,
                COUNT(o.id) AS total_orders,
                IFNULL(SUM(o.total_amount), 0) AS total_sales
            FROM sellers s
            JOIN users u ON s.user_id = u.id
            LEFT JOIN orders o ON o.seller_id = s.id
            GROUP BY s.id, s.shop_name, u.name
            ORDER BY total_sales DESC
            LIMIT ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}