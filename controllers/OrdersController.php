<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/SellerModel.php';

class OrdersController extends Controller {
    public function index() {
        require_admin();
        $f = $_GET;
        $orders = (new OrderModel($this->db))->all(
            $f['status']??'', $f['seller']??'', $f['customer']??'', $f['from']??'', $f['to']??''
        );
        $sellers = (new SellerModel($this->db))->all('', '');
        $this->view('orders/index', ['pageTitle'=>'Orders','orders'=>$orders,'sellers'=>$sellers,'f'=>$f]);
    }
    public function delete($id) {
        require_admin();
        (new OrderModel($this->db))->delete((int)$id);
        flash_set('success','Order deleted');
        redirect('orders');
    }
}