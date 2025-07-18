<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
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
        $page = (int) $this->request->get('page', 1);
        $limit = PRODUCTS_PER_PAGE;
        $offset = ($page - 1) * $limit;


        $filters = [
            'category_id' => $this->request->get('category'),
            'search' => $this->request->get('search'),
            'min_price' => $this->request->get('min_price'),
            'max_price' => $this->request->get('max_price'),
            'sort' => $this->request->get('sort', 'created_at'),
            'order' => $this->request->get('order', 'DESC')
        ];
        $filters = array_filter($filters);


        $countFilters = array_filter([
            'category_id' => $this->request->get('category'),
            'search' => $this->request->get('search'),
            'min_price' => $this->request->get('min_price'),
            'max_price' => $this->request->get('max_price')
        ]);

        $products = $this->productModel->getProducts($filters, $limit, $offset);
        $totalProducts = $this->productModel->countProducts($countFilters);
        $totalPages = ceil($totalProducts / $limit);
        $categories = $this->categoryModel->getWithProductCount();
        $this->render('products/index', [
            'title' => 'Products',
            'products' => $products,
            'categories' => $categories,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_products' => $totalProducts,
            'filters' => $filters,
            'limit' => $limit
        ]);
    }
    public function show($id)
    {
        if (is_numeric($id)) {
            $product = $this->productModel->find($id);
        } else {
            $product = $this->productModel->getBySlug($id);
        }
        if (!$product) {
            $this->setFlash('error', 'Product not found.');
            $this->redirect('/products');
        }
        $images = $this->productModel->getImages($product['id']);
        $reviews = $this->productModel->getReviews($product['id'], 5);
        $relatedProducts = $this->productModel->getRelated($product['id'], $product['category_id'], 4);
        $breadcrumb = $this->categoryModel->getBreadcrumb($product['category_id']);
        $this->render('products/show', [
            'title' => $product['name'],
            'product' => $product,
            'images' => $images,
            'reviews' => $reviews,
            'related_products' => $relatedProducts,
            'breadcrumb' => $breadcrumb,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ]);
    }
    public function category($id)
    {
        if (is_numeric($id)) {
            $category = $this->categoryModel->find($id);
        } else {
            $category = $this->categoryModel->getBySlug($id);
        }
        if (!$category) {
            $this->setFlash('error', 'Category not found.');
            $this->redirect('/products');
        }
        $page = (int) $this->request->get('page', 1);
        $limit = PRODUCTS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        $filters = [
            'category_id' => $category['id'],
            'search' => $this->request->get('search'),
            'min_price' => $this->request->get('min_price'),
            'max_price' => $this->request->get('max_price'),
            'sort' => $this->request->get('sort', 'created_at'),
            'order' => $this->request->get('order', 'DESC')
        ];
        $filters = array_filter($filters);
        $products = $this->productModel->getProducts($filters, $limit, $offset);
        $totalProducts = $this->productModel->count(['category_id' => $category['id']]);
        $totalPages = ceil($totalProducts / $limit);
        $categories = $this->categoryModel->getWithProductCount();
        $breadcrumb = $this->categoryModel->getBreadcrumb($category['id']);
        $this->render('products/category', [
            'title' => $category['name'],
            'category' => $category,
            'products' => $products,
            'categories' => $categories,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_products' => $totalProducts,
            'filters' => $filters,
            'breadcrumb' => $breadcrumb,
            'limit' => $limit
        ]);
    }
    public function search()
    {
        $query = $this->request->get('q', '');
        if (empty($query)) {
            $this->redirect('/products');
        }
        $page = (int) $this->request->get('page', 1);
        $limit = PRODUCTS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        $products = $this->productModel->search($query, $limit, $offset);
        $totalProducts = count($this->productModel->search($query, 1000, 0));
        $totalPages = ceil($totalProducts / $limit);
        $categories = $this->categoryModel->getWithProductCount();
        $this->render('products/search', [
            'title' => 'Search Results for "' . htmlspecialchars($query) . '"',
            'query' => $query,
            'products' => $products,
            'categories' => $categories,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_products' => $totalProducts,
            'limit' => $limit
        ]);
    }
}