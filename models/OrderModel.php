<?php
require_once __DIR__ . '/Model.php';
class OrderModel extends Model {
    public function all($status = '', $seller_id = '', $customer_id = '', $from = '', $to = '') {
        $sql = "SELECT o.*, u.name AS customer_name, s.shop_name FROM orders o
                JOIN users u ON o.customer_id = u.id
                JOIN sellers s ON o.seller_id = s.id WHERE 1=1";
        $types = ''; $params = [];
        if ($status !== '')      { $sql .= " AND o.status = ?";       $types .= 's'; $params[] = $status; }
        if ($seller_id !== '')   { $sql .= " AND o.seller_id = ?";    $types .= 'i'; $params[] = (int)$seller_id; }
        if ($customer_id !== '') { $sql .= " AND o.customer_id = ?";  $types .= 'i'; $params[] = (int)$customer_id; }
        if ($from !== '')        { $sql .= " AND DATE(o.created_at) >= ?"; $types .= 's'; $params[] = $from; }
        if ($to !== '')          { $sql .= " AND DATE(o.created_at) <= ?"; $types .= 's'; $params[] = $to; }
        $sql .= " ORDER BY o.id DESC";
        $stmt = $this->db->prepare($sql);
        if ($types) $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    public function todayCount() {
        return (int)$this->db->query("SELECT COUNT(*) c FROM orders WHERE DATE(created_at)=CURDATE()")->fetch_assoc()['c'];
    }
    public function monthlyRevenue() {
        $r = $this->db->query("SELECT COALESCE(SUM(total_amount),0) s FROM orders WHERE MONTH(created_at)=MONTH(CURDATE()) AND YEAR(created_at)=YEAR(CURDATE())")->fetch_assoc();
        return (float)$r['s'];
    }
public function revenueByMonth() {
    $sql = "
        SELECT 
            DATE_FORMAT(created_at, '%Y-%m') AS ym,
            COALESCE(SUM(total_amount), 0) AS total
        FROM orders
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY ym ASC
    ";

    $result = $this->db->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ym' => $row['ym'],
            'total' => (float)$row['total']   // 🔥 FORCE NUMBER
        ];
    }

    return $data;
}
    public function recent($limit = 5) {
        $stmt = $this->db->prepare("SELECT o.*, u.name AS customer_name, s.shop_name FROM orders o JOIN users u ON o.customer_id=u.id JOIN sellers s ON o.seller_id=s.id ORDER BY o.id DESC LIMIT ?");
        $stmt->bind_param('i', $limit); $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
}