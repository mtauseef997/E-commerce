<?php
namespace App\Models;
use App\Core\Model;
class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'manage_stock',
        'stock_status',
        'weight',
        'dimensions',
        'category_id',
        'featured',
        'status',
        'meta_title',
        'meta_description'
    ];
    public function getProducts($filters = [], $limit = PRODUCTS_PER_PAGE, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name, pi.image_path as primary_image,
                       AVG(r.rating) as avg_rating, COUNT(r.id) as review_count
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                LEFT JOIN reviews r ON p.id = r.product_id AND r.status = 'approved'
                WHERE p.status = 'active'";
        $params = [];
        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = ?";
            $params[] = $filters['category_id'];
        }
        if (!empty($filters['search'])) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        if (!empty($filters['min_price'])) {
            $sql .= " AND p.price >= ?";
            $params[] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND p.price <= ?";
            $params[] = $filters['max_price'];
        }
        if (!empty($filters['featured'])) {
            $sql .= " AND p.featured = 1";
        }
        $sql .= " GROUP BY p.id";
        $sortBy = $filters['sort'] ?? 'created_at';
        $sortOrder = $filters['order'] ?? 'DESC';
        switch ($sortBy) {
            case 'price_low':
                $sql .= " ORDER BY p.price ASC";
                break;
            case 'price_high':
                $sql .= " ORDER BY p.price DESC";
                break;
            case 'name':
                $sql .= " ORDER BY p.name ASC";
                break;
            case 'rating':
                $sql .= " ORDER BY avg_rating DESC";
                break;
            default:
                $sql .= " ORDER BY p.{$sortBy} {$sortOrder}";
        }
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getBySlug($slug)
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug,
                       AVG(r.rating) as avg_rating, COUNT(r.id) as review_count
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN reviews r ON p.id = r.product_id AND r.status = 'approved'
                WHERE p.slug = ? AND p.status = 'active'
                GROUP BY p.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$slug]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getImages($productId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM product_images 
            WHERE product_id = ? 
            ORDER BY is_primary DESC, sort_order ASC
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getReviews($productId, $limit = 10, $offset = 0)
    {
        $sql = "SELECT r.*, u.first_name, u.last_name, u.username
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.product_id = ? AND r.status = 'approved' 
                ORDER BY r.created_at DESC 
                LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$productId, $limit, $offset]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getRelated($productId, $categoryId, $limit = 4)
    {
        $sql = "SELECT p.*, pi.image_path as primary_image,
                       AVG(r.rating) as avg_rating
                FROM products p 
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                LEFT JOIN reviews r ON p.id = r.product_id AND r.status = 'approved'
                WHERE p.category_id = ? AND p.id != ? AND p.status = 'active'
                GROUP BY p.id
                ORDER BY RAND() 
                LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId, $productId, $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getFeatured($limit = 8)
    {
        $sql = "SELECT p.*, pi.image_path as primary_image,
                       AVG(r.rating) as avg_rating
                FROM products p 
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                LEFT JOIN reviews r ON p.id = r.product_id AND r.status = 'approved'
                WHERE p.featured = 1 AND p.status = 'active'
                GROUP BY p.id
                ORDER BY p.created_at DESC 
                LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function updateStock($productId, $quantity)
    {
        $stmt = $this->db->prepare("
            UPDATE products 
            SET stock_quantity = stock_quantity - ?, 
                stock_status = CASE 
                    WHEN stock_quantity - ? <= 0 THEN 'out_of_stock' 
                    ELSE 'in_stock' 
                END 
            WHERE id = ?
        ");
        return $stmt->execute([$quantity, $quantity, $productId]);
    }
    public function isInStock($productId, $quantity = 1)
    {
        $stmt = $this->db->prepare("
            SELECT stock_quantity, stock_status, manage_stock 
            FROM products 
            WHERE id = ?
        ");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$product) {
            return false;
        }
        if (!$product['manage_stock']) {
            return $product['stock_status'] === 'in_stock';
        }
        return $product['stock_quantity'] >= $quantity && $product['stock_status'] === 'in_stock';
    }
    public function addImage($productId, $imagePath, $altText = '', $isPrimary = false)
    {
        if ($isPrimary) {
            $stmt = $this->db->prepare("UPDATE product_images SET is_primary = 0 WHERE product_id = ?");
            $stmt->execute([$productId]);
        }
        $stmt = $this->db->prepare("
            INSERT INTO product_images (product_id, image_path, alt_text, is_primary) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$productId, $imagePath, $altText, $isPrimary ? 1 : 0]);
    }
    public function search($query, $limit = PRODUCTS_PER_PAGE, $offset = 0)
    {
        $searchTerm = '%' . $query . '%';
        $sql = "SELECT p.*, c.name as category_name, pi.image_path as primary_image,
                       AVG(r.rating) as avg_rating,
                       MATCH(p.name, p.description) AGAINST(? IN NATURAL LANGUAGE MODE) as relevance
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                LEFT JOIN reviews r ON p.id = r.product_id AND r.status = 'approved'
                WHERE p.status = 'active' AND (
                    p.name LIKE ? OR 
                    p.description LIKE ? OR 
                    p.sku LIKE ? OR
                    MATCH(p.name, p.description) AGAINST(? IN NATURAL LANGUAGE MODE)
                )
                GROUP BY p.id
                ORDER BY relevance DESC, p.name ASC
                LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$query, $searchTerm, $searchTerm, $searchTerm, $query, $limit, $offset]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}