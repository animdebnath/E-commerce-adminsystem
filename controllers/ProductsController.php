<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/SellerModel.php';

class ProductsController extends Controller {

    public function index() {
        require_admin();

        $q   = $_GET['q'] ?? '';
        $cat = $_GET['cat'] ?? '';
        $sel = $_GET['sel'] ?? '';

        $model = new ProductModel($this->db);

        $list = $model->all($q, $cat, $sel);
        $cats = (new CategoryModel($this->db))->all();
        $sellers = (new SellerModel($this->db))->all('', '');

        $this->view('products/index', [
            'list' => $list,
            'cats' => $cats,
            'sellers' => $sellers,
            'q' => $q,
            'cat' => $cat,
            'sel' => $sel,
            'pageTitle' => 'Products'
        ]);
    }

    public function save() {
        require_admin();

        $name  = trim($_POST['name'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $stock = (int)($_POST['stock'] ?? 0);
        $cat   = $_POST['category_id'] ?? null;
        $sel   = $_POST['seller_id'] ?? null;
        $desc  = trim($_POST['description'] ?? '');

        if ($name === '') {
            flash_set('error', 'Name is required');
            redirect('products');
        }

        if ($price <= 0) {
            flash_set('error', 'Price must be greater than 0');
            redirect('products');
        }

        if (!$sel) {
            flash_set('error', 'Seller is required');
            redirect('products');
        }

        $model = new ProductModel($this->db);

        $ok = $model->create($name, $price, $stock, $cat, $sel, $desc);

        if (!$ok) {
            die("INSERT FAILED: " . $this->db->error);
        }

        flash_set('success', 'Product added successfully');
        redirect('products');
    }

    public function remove($id) {
        require_admin();
        (new ProductModel($this->db))->setStatus((int)$id, 'removed');
        log_activity($this->db, $_SESSION['user_email'] ?? 'system', "Removed product #$id");
        flash_set('success', 'Product removed');
        redirect('products');
    }

    public function restore($id) {
        require_admin();
        (new ProductModel($this->db))->setStatus((int)$id, 'active');
        flash_set('success', 'Product restored');
        redirect('products');
    }

    public function delete($id) {
        require_admin();
        (new ProductModel($this->db))->delete((int)$id);
        log_activity($this->db, $_SESSION['user_email'] ?? 'system', "Deleted product #$id");
        flash_set('success', 'Product permanently deleted');
        redirect('products');
    }
}