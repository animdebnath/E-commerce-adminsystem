<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/SellerModel.php';

class CommissionsController extends Controller {
    public function index() {
        require_admin();
        $sellers = (new SellerModel($this->db))->all('', '');
        $this->view('commissions/index', ['pageTitle'=>'Commissions','sellers'=>$sellers]);
    }
    public function save() {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        $rate = (float)($_POST['rate'] ?? 0);
        if ($rate < 0 || $rate > 100) { flash_set('error','Rate must be 0-100'); redirect('commissions'); }
        (new SellerModel($this->db))->setCommission($id, $rate);
        flash_set('success','Commission updated');
        redirect('commissions');
    }
}
