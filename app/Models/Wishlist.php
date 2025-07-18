<?php

namespace App\Models;

use App\Core\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';

    public function __construct()
    {
        parent::__construct();
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS wishlists (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                product_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY unique_wishlist (user_id, product_id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            )";
            
            $this->db->exec($sql);
        } catch (\Exception $e) {
            error_log('Failed to create wishlists table: ' . $e->getMessage());
        }
    }

    public function addToWishlist($userId, $productId)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT IGNORE INTO wishlists (user_id, product_id) 
                VALUES (?, ?)
            ");
            
            return $stmt->execute([$userId, $productId]);
        } catch (\Exception $e) {
            error_log('Wishlist::addToWishlist - Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function removeFromWishlist($userId, $productId)
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM wishlists 
                WHERE user_id = ? AND product_id = ?
            ");
            
            return $stmt->execute([$userId, $productId]);
        } catch (\Exception $e) {
            error_log('Wishlist::removeFromWishlist - Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function isInWishlist($userId, $productId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count 
                FROM wishlists 
                WHERE user_id = ? AND product_id = ?
            ");
            
            $stmt->execute([$userId, $productId]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $result['count'] > 0;
        } catch (\Exception $e) {
            error_log('Wishlist::isInWishlist - Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getWishlistCount($userId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count 
                FROM wishlists 
                WHERE user_id = ?
            ");
            
            $stmt->execute([$userId]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return (int) $result['count'];
        } catch (\Exception $e) {
            error_log('Wishlist::getWishlistCount - Error: ' . $e->getMessage());
            return 0;
        }
    }

    public function getUserWishlist($userId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM wishlists 
                WHERE user_id = ? 
                ORDER BY created_at DESC
            ");
            
            $stmt->execute([$userId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log('Wishlist::getUserWishlist - Error: ' . $e->getMessage());
            return [];
        }
    }

    public function getUserWishlistWithProducts($userId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    w.*,
                    p.id as product_id,
                    p.name as product_name,
                    p.slug as product_slug,
                    p.description as product_description,
                    p.short_description as product_short_description,
                    p.price as product_price,
                    p.sale_price as product_sale_price,
                    p.image as product_image,
                    p.stock_quantity,
                    p.stock_status,
                    p.status as product_status,
                    c.name as category_name,
                    c.slug as category_slug
                FROM wishlists w
                INNER JOIN products p ON w.product_id = p.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE w.user_id = ? AND p.status = 'active'
                ORDER BY w.created_at DESC
            ");
            
            $stmt->execute([$userId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log('Wishlist::getUserWishlistWithProducts - Error: ' . $e->getMessage());
            return [];
        }
    }

    public function clearWishlist($userId)
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM wishlists 
                WHERE user_id = ?
            ");
            
            return $stmt->execute([$userId]);
        } catch (\Exception $e) {
            error_log('Wishlist::clearWishlist - Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getWishlistProductIds($userId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT product_id 
                FROM wishlists 
                WHERE user_id = ?
            ");
            
            $stmt->execute([$userId]);
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            return array_column($results, 'product_id');
        } catch (\Exception $e) {
            error_log('Wishlist::getWishlistProductIds - Error: ' . $e->getMessage());
            return [];
        }
    }

    public function moveToCart($userId, $productId)
    {
        try {
            // This would integrate with the cart system
            // For now, just remove from wishlist
            return $this->removeFromWishlist($userId, $productId);
        } catch (\Exception $e) {
            error_log('Wishlist::moveToCart - Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getRecentlyAddedItems($userId, $limit = 5)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    w.*,
                    p.name as product_name,
                    p.slug as product_slug,
                    p.price as product_price,
                    p.image as product_image
                FROM wishlists w
                INNER JOIN products p ON w.product_id = p.id
                WHERE w.user_id = ? AND p.status = 'active'
                ORDER BY w.created_at DESC
                LIMIT ?
            ");
            
            $stmt->execute([$userId, $limit]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log('Wishlist::getRecentlyAddedItems - Error: ' . $e->getMessage());
            return [];
        }
    }

    public function getWishlistStats($userId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    COUNT(*) as total_items,
                    COUNT(CASE WHEN p.stock_status = 'in_stock' THEN 1 END) as in_stock_items,
                    COUNT(CASE WHEN p.stock_status = 'out_of_stock' THEN 1 END) as out_of_stock_items,
                    AVG(COALESCE(p.sale_price, p.price)) as average_price,
                    SUM(COALESCE(p.sale_price, p.price)) as total_value
                FROM wishlists w
                INNER JOIN products p ON w.product_id = p.id
                WHERE w.user_id = ? AND p.status = 'active'
            ");
            
            $stmt->execute([$userId]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log('Wishlist::getWishlistStats - Error: ' . $e->getMessage());
            return [
                'total_items' => 0,
                'in_stock_items' => 0,
                'out_of_stock_items' => 0,
                'average_price' => 0,
                'total_value' => 0
            ];
        }
    }
}
