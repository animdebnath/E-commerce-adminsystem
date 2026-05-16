<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/SellerModel.php';

class FeaturedController extends Controller {

    public function index() {
        require_admin();

        $pm = new ProductModel($this->db);
        $sm = new SellerModel($this->db);

        $this->view('featured/index', [
            'pageTitle' => 'Featured Content',
            'products'  => $pm->all(),
            'sellers'   => $sm->all('', ''),
        ]);
    }

    public function toggleProduct($id) {
        require_admin();

        $list = (new ProductModel($this->db))->all();
        $cur = 0;

        foreach ($list as $p) {
            if ($p['id'] == $id) {
                $cur = (int)$p['is_featured'];
            }
        }

        (new ProductModel($this->db))->setFeatured((int)$id, $cur ? 0 : 1);

        flash_set('success', 'Featured status updated');
        redirect('featured');
    }

    public function uploadBanner() {
        require_admin();

        $sid = (int)($_POST['seller_id'] ?? 0);

        $file = save_uploaded_image('banner', 'banners');

        if (!$file) {
            flash_set('error', 'Invalid image (jpg/png/webp, ≤2MB)');
            redirect('featured');
        }

        $stmt = $this->db->prepare("UPDATE sellers SET banner = ? WHERE id = ?");
        $stmt->bind_param('si', $file, $sid);
        $stmt->execute();

        flash_set('success', 'Banner uploaded');
        redirect('featured');
    }

    // ⭐ NEW FUNCTION: DELETE BANNER
    public function deleteBanner($id)
    {
        require_admin();

        // SAFE query (FIXED)
        $stmt = $this->db->prepare("SELECT banner FROM sellers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $seller = $stmt->get_result()->fetch_assoc();

        // delete file from folder
        if (!empty($seller['banner'])) {
            $file = __DIR__ . "/../public/uploads/" . $seller['banner'];

            if (file_exists($file)) {
                unlink($file); // delete image file
            }
        }

        // remove from DB
        $stmt = $this->db->prepare("UPDATE sellers SET banner = NULL WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        flash_set('success', 'Banner deleted successfully');
        redirect('featured');
    }
}