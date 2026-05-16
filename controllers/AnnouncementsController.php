<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/AnnouncementModel.php';

class AnnouncementsController extends Controller {
    public function index() {
        require_admin();
        $this->view('announcements/index', ['pageTitle'=>'Announcements','list'=>(new AnnouncementModel($this->db))->all()]);
    }
    public function save() {
        require_admin();
        $title = trim($_POST['title'] ?? '');
        $body  = trim($_POST['body'] ?? '');
        if ($title === '' || $body === '') { flash_set('error','All fields required'); redirect('announcements'); }
        (new AnnouncementModel($this->db))->create($title, $body);
        flash_set('success','Announcement posted');
        redirect('announcements');
    }
    public function delete($id) {
        require_admin();
        (new AnnouncementModel($this->db))->delete((int)$id);
        flash_set('success','Deleted');
        redirect('announcements');
    }
}
