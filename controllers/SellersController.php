<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/SellerModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class SellersController extends Controller {

    // ================= LIST =================
    public function index() {
        require_admin();

        $search = $_GET['q'] ?? '';
        $status = $_GET['status'] ?? '';

        $sellers = (new SellerModel($this->db))->all($search, $status);

        $this->view('sellers/index', [
            'pageTitle' => 'Sellers',
            'sellers' => $sellers,
            'q' => $search,
            'status' => $status
        ]);
    }

    // ================= CREATE =================
    public function save() {
        require_admin();

        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $shop  = trim($_POST['shop_name'] ?? '');
        $pass  = $_POST['password'] ?? '';

        if (!$name || !$email || !$shop || strlen($pass) < 6) {
            flash_set('error', 'Invalid input');
            redirect('sellers');
        }

        $um = new UserModel($this->db);

        if ($um->emailExists($email)) {
            flash_set('error', 'Email already exists');
            redirect('sellers');
        }

        $um->create($name, $email, $phone, 'seller', $pass);
        $user_id = $this->db->insert_id;

        (new SellerModel($this->db))->create($user_id, $shop);

        flash_set('success', 'Seller added successfully');
        redirect('sellers');
    }

    // ================= UPDATE =================
    public function update() {
        require_admin();

        $id    = (int)($_POST['id'] ?? 0);
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $shop  = trim($_POST['shop_name'] ?? '');

        if (!$id || !$name || !$email || !$shop) {
            flash_set('error', 'Invalid input');
            redirect('sellers');
        }

        $model = new SellerModel($this->db);
        $seller = $model->find($id);

        if (!$seller) {
            flash_set('error', 'Seller not found');
            redirect('sellers');
        }

        $model->updateSeller(
            $id,
            $seller['user_id'],
            $shop,
            $name,
            $email,
            $phone
        );

        flash_set('success', 'Seller updated successfully');
        redirect('sellers');
    }

    // ================= DELETE =================
    public function delete($id) {
        require_admin();

        (new SellerModel($this->db))->delete((int)$id);

        flash_set('success', 'Deleted successfully');
        redirect('sellers');
    }

    // ================= AJAX ACTION (FIXED) =================
    public function ajaxAction() {
        require_admin();

        header('Content-Type: application/json');

        $id = (int)($_POST['id'] ?? 0);
        $action = $_POST['action'] ?? '';

        if (!$id || !$action) {
            echo json_encode(['ok' => false, 'message' => 'Invalid request']);
            return;
        }

        $m = new SellerModel($this->db);

        switch ($action) {

            case 'approve':
                $m->setApproval($id, 'approved');
                echo json_encode(['ok' => true, 'message' => 'Seller approved']);
                break;

            case 'reject':
                $m->setApproval($id, 'rejected');
                echo json_encode(['ok' => true, 'message' => 'Seller rejected']);
                break;

            case 'suspend':
                $m->setSuspended($id, 1);
                echo json_encode(['ok' => true, 'message' => 'Seller suspended']);
                break;

            case 'activate':   // ✅ FIXED (was reactivate)
                $m->setSuspended($id, 0);
                echo json_encode(['ok' => true, 'message' => 'Seller activated']);
                break;

            default:
                echo json_encode(['ok' => false, 'message' => 'Unknown action']);
        }
    }
}