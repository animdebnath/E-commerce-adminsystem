<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/DisputeModel.php';

class DisputesController extends Controller {
    public function index() {
        require_admin();
        $list = (new DisputeModel($this->db))->all();
        $this->view('disputes/index', ['pageTitle'=>'Disputes','list'=>$list]);
    }
    public function resolve() {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        $notes = trim($_POST['admin_notes'] ?? '');
        if ($id && $notes !== '') {
            (new DisputeModel($this->db))->resolve($id, $notes);
            flash_set('success','Dispute resolved');
        } else flash_set('error','Notes are required');
        redirect('disputes');
    }
    public function delete($id) {
        require_admin();
        (new DisputeModel($this->db))->delete((int)$id);
        flash_set('success','Dispute deleted');
        redirect('disputes');
    }
}