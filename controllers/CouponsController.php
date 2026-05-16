<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/CouponModel.php';

class CouponsController extends Controller {
    public function index() {
        require_admin();
        $this->view('coupons/index', ['pageTitle'=>'Coupons','list'=>(new CouponModel($this->db))->all()]);
    }
    public function save() {
        require_admin();
        $code = strtoupper(trim($_POST['code'] ?? ''));
        $disc = (float)($_POST['discount'] ?? 0);
        $until = $_POST['valid_until'] ?? null;
        $errors = [];
        if (!preg_match('/^[A-Z0-9_-]{3,50}$/', $code)) $errors[] = 'Invalid code (3-50, A-Z, 0-9)';
        if ($disc <= 0 || $disc > 100) $errors[] = 'Discount must be 1-100';
        $m = new CouponModel($this->db);
        if (!$errors && $m->exists($code)) $errors[] = 'Code already exists';
        if ($errors) { flash_set('error', implode(', ', $errors)); redirect('coupons'); }
        $m->create($code, $disc, $until);
        flash_set('success','Coupon created');
        redirect('coupons');
    }
    public function toggle($id) {
        require_admin();
        $list = (new CouponModel($this->db))->all();
        $cur = 1;
        foreach ($list as $c) if ($c['id'] == $id) $cur = (int)$c['is_active'];
        (new CouponModel($this->db))->setActive((int)$id, $cur ? 0 : 1);
        redirect('coupons');
    }
    public function delete($id) {
        require_admin();
        (new CouponModel($this->db))->delete((int)$id);
        flash_set('success','Coupon deleted');
        redirect('coupons');
    }
}
