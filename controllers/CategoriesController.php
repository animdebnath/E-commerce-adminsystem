<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoriesController extends Controller {
    public function index() {
        require_admin();
        $m = new CategoryModel($this->db);
        $this->view('categories/index', ['pageTitle'=>'Categories','cats'=>$m->all(),'all'=>$m->all()]);
    }
    public function save() {
        require_admin();
        $name = trim($_POST['name'] ?? '');
        $parent = (int)($_POST['parent_id'] ?? 0);
        $id = (int)($_POST['id'] ?? 0);
        if ($name === '') { flash_set('error','Name is required'); redirect('categories'); }
        $m = new CategoryModel($this->db);
        if ($id) { $m->update($id, $name, $parent); flash_set('success','Category updated'); }
        else     { $m->create($name, $parent); flash_set('success','Category added'); }
        redirect('categories');
    }
    public function delete($id) {
        require_admin();
        $m = new CategoryModel($this->db);
        if ($m->delete((int)$id)) flash_set('success','Category deleted');
        else flash_set('error','Cannot delete: products exist in this category');
        redirect('categories');
    }
}
