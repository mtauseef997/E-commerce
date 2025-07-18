<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    private $productModel;
    private $categoryModel;
    private $orderModel;
    private $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->orderModel = new Order();
        $this->userModel = new User();
        $this->requireAdmin();
    }
    public function dashboard()
    {
        $stats = [
            'total_products' => $this->productModel->count(['status' => 'active']),
            'total_orders' => $this->orderModel->count(),
            'total_users' => $this->userModel->count(['role' => 'user']),
            'pending_orders' => $this->orderModel->count(['status' => 'pending'])
        ];
        $recentOrders = $this->orderModel->getRecent(5);
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');
        $monthlyStats = $this->orderModel->getStats($startOfMonth, $endOfMonth);
        $this->render('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'recent_orders' => $recentOrders,
            'monthly_stats' => $monthlyStats,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ], 'admin');
    }
    public function products()
    {
        $page = (int) $this->request->get('page', 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $filters = [
            'search' => $this->request->get('search'),
            'category_id' => $this->request->get('category'),
            'status' => $this->request->get('status')
        ];
        $filters = array_filter($filters);
        $products = $this->productModel->getProducts($filters, $limit, $offset);
        $totalProducts = $this->productModel->count($filters);
        $totalPages = ceil($totalProducts / $limit);
        $categories = $this->categoryModel->getActive();
        $this->render('admin/products/index', [
            'title' => 'Manage Products',
            'products' => $products,
            'categories' => $categories,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_products' => $totalProducts,
            'filters' => $filters,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ], 'admin');
    }
    public function createProduct()
    {
        $categories = $this->categoryModel->getActive();
        $this->render('admin/products/create', [
            'title' => 'Add New Product',
            'categories' => $categories,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ], 'admin');
    }
    public function storeProduct()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/admin/products');
        }
        $this->validateCsrf();
        $data = [
            'name' => $this->request->post('name'),
            'slug' => $this->generateSlug($this->request->post('name')),
            'description' => $this->request->post('description'),
            'short_description' => $this->request->post('short_description'),
            'sku' => $this->request->post('sku'),
            'price' => $this->request->post('price'),
            'sale_price' => $this->request->post('sale_price') ?: null,
            'stock_quantity' => $this->request->post('stock_quantity'),
            'category_id' => $this->request->post('category_id'),
            'featured' => $this->request->post('featured') ? 1 : 0,
            'status' => $this->request->post('status'),
            'meta_title' => $this->request->post('meta_title'),
            'meta_description' => $this->request->post('meta_description')
        ];
        $errors = $this->request->validate([
            'name' => 'required|min:2|max:200',
            'sku' => 'required|min:2|max:100',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|numeric',
            'category_id' => 'required|numeric'
        ]);
        if (!empty($errors)) {
            $errorMessages = [];
            foreach ($errors as $field => $fieldErrors) {
                $errorMessages = array_merge($errorMessages, $fieldErrors);
            }
            $this->setFlash('error', implode('<br>', $errorMessages));
            $this->redirect('/admin/product/create');
        }
        $productId = $this->productModel->create($data);
        if ($productId) {
            $this->handleProductImageUpload($productId);
            $this->setFlash('success', 'Product created successfully.');
            $this->redirect('/admin/products');
        } else {
            $this->setFlash('error', 'Failed to create product.');
            $this->redirect('/admin/product/create');
        }
    }
    public function editProduct($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            $this->setFlash('error', 'Product not found.');
            $this->redirect('/admin/products');
        }
        $categories = $this->categoryModel->getActive();
        $images = $this->productModel->getImages($id);
        $this->render('admin/products/edit', [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => $categories,
            'images' => $images,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ], 'admin');
    }
    public function updateProduct($id)
    {
        if (!$this->request->isPost()) {
            $this->redirect('/admin/products');
        }
        $product = $this->productModel->find($id);
        if (!$product) {
            $this->setFlash('error', 'Product not found.');
            $this->redirect('/admin/products');
        }
        $this->validateCsrf();
        $data = [
            'name' => $this->request->post('name'),
            'description' => $this->request->post('description'),
            'short_description' => $this->request->post('short_description'),
            'sku' => $this->request->post('sku'),
            'price' => $this->request->post('price'),
            'sale_price' => $this->request->post('sale_price') ?: null,
            'stock_quantity' => $this->request->post('stock_quantity'),
            'category_id' => $this->request->post('category_id'),
            'featured' => $this->request->post('featured') ? 1 : 0,
            'status' => $this->request->post('status'),
            'meta_title' => $this->request->post('meta_title'),
            'meta_description' => $this->request->post('meta_description')
        ];
        if ($data['name'] !== $product['name']) {
            $data['slug'] = $this->generateSlug($data['name']);
        }
        if ($this->productModel->update($id, $data)) {
            $this->handleProductImageUpload($id);
            $this->setFlash('success', 'Product updated successfully.');
        } else {
            $this->setFlash('error', 'Failed to update product.');
        }
        $this->redirect('/admin/product/' . $id . '/edit');
    }
    public function deleteProduct($id)
    {
        if (!$this->request->isPost()) {
            $this->redirect('/admin/products');
        }
        $this->validateCsrf();
        if ($this->productModel->delete($id)) {
            $this->setFlash('success', 'Product deleted successfully.');
        } else {
            $this->setFlash('error', 'Failed to delete product.');
        }
        $this->redirect('/admin/products');
    }
    public function categories()
    {
        $categories = $this->categoryModel->getWithProductCount();
        $this->render('admin/categories/index', [
            'title' => 'Manage Categories',
            'categories' => $categories,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ], 'admin');
    }
    public function orders()
    {
        $page = (int) $this->request->get('page', 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $status = $this->request->get('status');
        if ($status) {
            $orders = $this->orderModel->getByStatus($status, $limit, $offset);
            $totalOrders = $this->orderModel->count(['status' => $status]);
        } else {
            $orders = $this->orderModel->getRecent($limit);
            $totalOrders = $this->orderModel->count();
        }
        $totalPages = ceil($totalOrders / $limit);
        $this->render('admin/orders/index', [
            'title' => 'Manage Orders',
            'orders' => $orders,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_orders' => $totalOrders,
            'status_filter' => $status,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ], 'admin');
    }
    public function users()
    {
        $page = (int) $this->request->get('page', 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $users = $this->userModel->findAll($limit, $offset);
        $totalUsers = $this->userModel->count();
        $totalPages = ceil($totalUsers / $limit);
        $this->render('admin/users/index', [
            'title' => 'Manage Users',
            'users' => $users,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_users' => $totalUsers,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ], 'admin');
    }
    private function generateSlug($name)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $originalSlug = $slug;
        $counter = 1;
        while ($this->productModel->count(['slug' => $slug]) > 0) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
    private function handleProductImageUpload($productId)
    {
        $uploadedFile = $this->request->file('image');
        if ($uploadedFile && $uploadedFile['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (in_array($uploadedFile['type'], $allowedTypes)) {
                $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
                $filename = 'product_' . $productId . '_' . time() . '.' . $extension;
                $uploadPath = UPLOAD_PATH . 'products/' . $filename;
                if (!is_dir(dirname($uploadPath))) {
                    mkdir(dirname($uploadPath), 0755, true);
                }
                if (move_uploaded_file($uploadedFile['tmp_name'], $uploadPath)) {
                    $this->productModel->addImage($productId, 'products/' . $filename, '', true);
                }
            }
        }
    }
}