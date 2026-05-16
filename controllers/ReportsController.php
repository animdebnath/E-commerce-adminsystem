<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/SellerModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class ReportsController extends Controller {
    public function index() {
        require_admin();
        $o = new OrderModel($this->db);
        $s = new SellerModel($this->db);
        $c = new CategoryModel($this->db);
        $this->view('reports/index', [
            'pageTitle'=>'Reports',
            'revenueSeries' => $o->revenueByMonth(),
            'top'     => $s->topSellers(5),
            'topCats' => $c->topCategories(5),
            'monthRev'=> $o->monthlyRevenue(),
            'today'   => $o->todayCount(),
        ]);
    }
    public function printable() {
        require_admin();
        $o = new OrderModel($this->db);
        $s = new SellerModel($this->db);
        $c = new CategoryModel($this->db);
        $data = [
            'revenueSeries' => $o->revenueByMonth(),
            'top'     => $s->topSellers(10),
            'topCats' => $c->topCategories(10),
            'monthRev'=> $o->monthlyRevenue(),
        ];
        $this->viewBare('reports/printable', $data);
    }
}
