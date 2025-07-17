<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Product;
use App\Models\Category;
class HomeController extends Controller
{
    private $productModel;
    private $categoryModel;
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }
    public function index()
    {
        try {
            $featuredProducts = $this->productModel->getFeatured(8);
            $categories = $this->categoryModel->getWithProductCount();
            $latestProducts = $this->productModel->getProducts([], 8, 0);
            $this->render('home/index', [
                'title' => 'Welcome to ' . APP_NAME,
                'featured_products' => $featuredProducts,
                'categories' => $categories,
                'latest_products' => $latestProducts
            ]);
        } catch (\Exception $e) {
            $this->render('home/setup_required', [
                'title' => 'Setup Required - ' . APP_NAME,
                'error' => $e->getMessage()
            ]);
        }
    }
}