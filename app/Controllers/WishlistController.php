<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    private $wishlistModel;
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->wishlistModel = new Wishlist();
        $this->productModel = new Product();
    }

    public function index()
    {
        // Check if user is logged in
        if (!$this->getCurrentUser()) {
            $this->setFlash('error', 'Please login to view your wishlist.');
            $this->redirect('/login');
        }

        $userId = $this->getCurrentUser()['id'];
        
        try {
            // Get wishlist items with product details
            $wishlistItems = $this->wishlistModel->getUserWishlistWithProducts($userId);
            
            $this->render('wishlist/index', [
                'title' => 'My Wishlist - ' . APP_NAME,
                'wishlist_items' => $wishlistItems,
                'total_items' => count($wishlistItems)
            ]);
        } catch (\Exception $e) {
            error_log('WishlistController::index - Error: ' . $e->getMessage());
            $this->setFlash('error', 'Failed to load wishlist. Please try again.');
            $this->redirect('/');
        }
    }

    public function add()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/wishlist');
        }

        // Check if user is logged in
        if (!$this->getCurrentUser()) {
            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Please login to add items to wishlist.'
                ]);
            }
            $this->setFlash('error', 'Please login to add items to wishlist.');
            $this->redirect('/login');
        }

        $userId = $this->getCurrentUser()['id'];
        $productId = (int) $this->request->post('product_id');

        if (!$productId) {
            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Invalid product ID.'
                ]);
            }
            $this->setFlash('error', 'Invalid product.');
            $this->redirect('/wishlist');
        }

        try {
            // Check if product exists
            $product = $this->productModel->find($productId);
            if (!$product) {
                if ($this->request->isAjax()) {
                    return $this->json([
                        'success' => false,
                        'message' => 'Product not found.'
                    ]);
                }
                $this->setFlash('error', 'Product not found.');
                $this->redirect('/wishlist');
            }

            // Check if already in wishlist
            if ($this->wishlistModel->isInWishlist($userId, $productId)) {
                if ($this->request->isAjax()) {
                    return $this->json([
                        'success' => false,
                        'message' => 'Product is already in your wishlist.'
                    ]);
                }
                $this->setFlash('error', 'Product is already in your wishlist.');
                $this->redirect('/wishlist');
            }

            // Add to wishlist
            $this->wishlistModel->addToWishlist($userId, $productId);

            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Product added to wishlist!',
                    'wishlist_count' => $this->wishlistModel->getWishlistCount($userId)
                ]);
            }

            $this->setFlash('success', 'Product added to wishlist!');
            $this->redirect('/wishlist');

        } catch (\Exception $e) {
            error_log('WishlistController::add - Error: ' . $e->getMessage());
            
            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Failed to add product to wishlist.'
                ]);
            }
            
            $this->setFlash('error', 'Failed to add product to wishlist.');
            $this->redirect('/wishlist');
        }
    }

    public function remove()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/wishlist');
        }

        // Check if user is logged in
        if (!$this->getCurrentUser()) {
            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Please login to manage your wishlist.'
                ]);
            }
            $this->setFlash('error', 'Please login to manage your wishlist.');
            $this->redirect('/login');
        }

        $userId = $this->getCurrentUser()['id'];
        $productId = (int) $this->request->post('product_id');

        if (!$productId) {
            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Invalid product ID.'
                ]);
            }
            $this->setFlash('error', 'Invalid product.');
            $this->redirect('/wishlist');
        }

        try {
            // Remove from wishlist
            $this->wishlistModel->removeFromWishlist($userId, $productId);

            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Product removed from wishlist.',
                    'wishlist_count' => $this->wishlistModel->getWishlistCount($userId)
                ]);
            }

            $this->setFlash('success', 'Product removed from wishlist.');
            $this->redirect('/wishlist');

        } catch (\Exception $e) {
            error_log('WishlistController::remove - Error: ' . $e->getMessage());
            
            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Failed to remove product from wishlist.'
                ]);
            }
            
            $this->setFlash('error', 'Failed to remove product from wishlist.');
            $this->redirect('/wishlist');
        }
    }

    public function toggle()
    {
        if (!$this->request->isPost()) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }

        // Check if user is logged in
        if (!$this->getCurrentUser()) {
            return $this->json([
                'success' => false,
                'message' => 'Please login to manage your wishlist.'
            ]);
        }

        $userId = $this->getCurrentUser()['id'];
        $productId = (int) $this->request->post('product_id');

        if (!$productId) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid product ID.'
            ]);
        }

        try {
            // Check if product exists
            $product = $this->productModel->find($productId);
            if (!$product) {
                return $this->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ]);
            }

            // Toggle wishlist status
            $isInWishlist = $this->wishlistModel->isInWishlist($userId, $productId);
            
            if ($isInWishlist) {
                $this->wishlistModel->removeFromWishlist($userId, $productId);
                $message = 'Product removed from wishlist.';
                $action = 'removed';
            } else {
                $this->wishlistModel->addToWishlist($userId, $productId);
                $message = 'Product added to wishlist!';
                $action = 'added';
            }

            return $this->json([
                'success' => true,
                'message' => $message,
                'action' => $action,
                'is_in_wishlist' => !$isInWishlist,
                'wishlist_count' => $this->wishlistModel->getWishlistCount($userId)
            ]);

        } catch (\Exception $e) {
            error_log('WishlistController::toggle - Error: ' . $e->getMessage());
            
            return $this->json([
                'success' => false,
                'message' => 'Failed to update wishlist.'
            ]);
        }
    }

    public function clear()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/wishlist');
        }

        // Check if user is logged in
        if (!$this->getCurrentUser()) {
            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Please login to manage your wishlist.'
                ]);
            }
            $this->setFlash('error', 'Please login to manage your wishlist.');
            $this->redirect('/login');
        }

        $userId = $this->getCurrentUser()['id'];

        try {
            $this->wishlistModel->clearWishlist($userId);

            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Wishlist cleared successfully.',
                    'wishlist_count' => 0
                ]);
            }

            $this->setFlash('success', 'Wishlist cleared successfully.');
            $this->redirect('/wishlist');

        } catch (\Exception $e) {
            error_log('WishlistController::clear - Error: ' . $e->getMessage());
            
            if ($this->request->isAjax()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Failed to clear wishlist.'
                ]);
            }
            
            $this->setFlash('error', 'Failed to clear wishlist.');
            $this->redirect('/wishlist');
        }
    }
}
