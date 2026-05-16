<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/SellerModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/ActivityModel.php';

class DashboardController extends Controller {

    public function index() {
        require_admin();

        $u = new UserModel($this->db);
        $s = new SellerModel($this->db);
        $p = new ProductModel($this->db);
        $o = new OrderModel($this->db);
        $a = new ActivityModel($this->db);

        $data = [
            'pageTitle' => 'Dashboard',

            // USERS
            'totalUsers' => $u->countByRole('customer'),

            // SELLERS (SAFE FALLBACK)
            'totalSellers' => method_exists($s, 'countAll') 
                ? $s->countAll() 
                : $this->countTable('sellers'),

            'pending' => method_exists($s, 'countPending')
                ? $s->countPending()
                : $this->countPendingFallback(),

            // ORDERS
            'todayOrders' => $o->todayCount(),
            'monthRev' => $o->monthlyRevenue(),
            'revenueSeries' => $o->revenueByMonth(),
            'recent' => $o->recent(5),

            // PRODUCTS
            'totalProds' => $p->countAll(),

            // ACTIVITY
            'activity' => $a->recent(8),
        ];

        $this->view('dashboard/index', $data);
    }

    // ================= SAFE FALLBACK FUNCTIONS =================

    private function countTable($table)
    {
        $result = $this->db->query("SELECT COUNT(*) as total FROM $table");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    private function countPendingFallback()
    {
        $result = $this->db->query("
            SELECT COUNT(*) as total 
            FROM sellers 
            WHERE approval_status='pending'
        ");
        return $result->fetch_assoc()['total'] ?? 0;
    }
}