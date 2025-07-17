<?php
namespace App\Models;
use App\Core\Model;
class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 
        'phone', 'role', 'status', 'email_verified'
    ];
    protected $hidden = ['password'];
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function createUser($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], HASH_ALGO);
        }
        return $this->create($data);
    }
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, HASH_ALGO);
        return $this->update($userId, ['password' => $hashedPassword]);
    }
    public function getOrders($userId, $limit = 10, $offset = 0)
    {
        $sql = "SELECT o.*, COUNT(oi.id) as item_count 
                FROM orders o 
                LEFT JOIN order_items oi ON o.id = oi.order_id 
                WHERE o.user_id = ? 
                GROUP BY o.id 
                ORDER BY o.created_at DESC 
                LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $limit, $offset]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getWishlist($userId)
    {
        $sql = "SELECT w.*, p.name, p.slug, p.price, p.sale_price, pi.image_path 
                FROM wishlist w 
                JOIN products p ON w.product_id = p.id 
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1 
                WHERE w.user_id = ? 
                ORDER BY w.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getAddresses($userId, $type = null)
    {
        $sql = "SELECT * FROM user_addresses WHERE user_id = ?";
        $params = [$userId];
        if ($type) {
            $sql .= " AND type = ?";
            $params[] = $type;
        }
        $sql .= " ORDER BY is_default DESC, created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function addAddress($userId, $addressData)
    {
        $addressData['user_id'] = $userId;
        $stmt = $this->db->prepare("
            INSERT INTO user_addresses (user_id, type, first_name, last_name, company, 
                                      address_line_1, address_line_2, city, state, 
                                      postal_code, country, phone, is_default) 
            VALUES (:user_id, :type, :first_name, :last_name, :company, 
                    :address_line_1, :address_line_2, :city, :state, 
                    :postal_code, :country, :phone, :is_default)
        ");
        return $stmt->execute($addressData);
    }
    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = ?";
        $params = [$email];
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    public function usernameExists($username, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE username = ?";
        $params = [$username];
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    public function getStats($userId)
    {
        $sql = "SELECT 
                    COUNT(DISTINCT o.id) as total_orders,
                    COALESCE(SUM(o.total_amount), 0) as total_spent,
                    COUNT(DISTINCT w.id) as wishlist_count,
                    COUNT(DISTINCT r.id) as review_count
                FROM users u
                LEFT JOIN orders o ON u.id = o.user_id
                LEFT JOIN wishlist w ON u.id = w.user_id
                LEFT JOIN reviews r ON u.id = r.user_id
                WHERE u.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}