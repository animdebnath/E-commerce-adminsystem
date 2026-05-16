<?php
// Base controller — provides shared render() helper
class Controller {
    protected $db;
    public function __construct($db) { $this->db = $db; }
    protected function view($path, $data = []) {
        extract($data);
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/' . $path . '.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
    protected function viewBare($path, $data = []) {
        extract($data);
        require __DIR__ . '/../views/' . $path . '.php';
    }
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data); exit;
    }
}
