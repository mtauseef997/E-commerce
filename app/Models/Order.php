<?php
namespace App\Models;
use App\Core\Model;
class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id', 'order_number', 'status', 'total_amount', 'subtotal', 
        'tax_amount', 'shipping_amount', 'discount_amount', 'payment_method', 
        'payment_status', 'billing_address', 'shipping_address', 'notes'
    ];
    public function createOrder($orderData, $items)
    {
        $this->beginTransaction();
        try {
            $orderData['order_number'] = $this->generateOrderNumber();
            $orderId = $this->create($orderData);
            if (!$orderId) {
                throw new \Exception('Failed to create order');
            }
            foreach ($items as $item) {
                $item['order_id'] = $orderId;
                $this->createOrderItem($item);
                $productModel = new Product();
                $productModel->updateStock($item['product_id'], $item['quantity']);
            }
            $this->commit();
            return $orderId;
        } catch (\Exception $e) {
            $this->rollback();
            throw $e;
        }
    }
    private function createOrderItem($itemData)
    {
        $stmt = $this->db->prepare("
            INSERT INTO order_items (order_id, product_id, product_name, product_sku, quantity, price, total) 
            VALUES (:order_id, :product_id, :product_name, :product_sku, :quantity, :price, :total)
        ");
        return $stmt->execute($itemData);
    }
    public function getOrderWithItems($orderId)
    {
        $order = $this->find($orderId);
        if (!$order) {
            return null;
        }
        $stmt = $this->db->prepare("
            SELECT oi.*, p.slug as product_slug, pi.image_path as product_image
            FROM order_items oi 
            LEFT JOIN products p ON oi.product_id = p.id
            LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        $order['items'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $order;
    }
    public function getUserOrders($userId, $limit = ORDERS_PER_PAGE, $offset = 0)
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
    public function updateStatus($orderId, $status)
    {
        return $this->update($orderId, ['status' => $status]);
    }
    public function updatePaymentStatus($orderId, $paymentStatus)
    {
        return $this->update($orderId, ['payment_status' => $paymentStatus]);
    }
    private function generateOrderNumber()
    {
        $prefix = 'ORD';
        $timestamp = date('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $orderNumber = $prefix . $timestamp . $random;
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE order_number = ?");
        $stmt->execute([$orderNumber]);
        if ($stmt->fetchColumn() > 0) {
            return $this->generateOrderNumber();
        }
        return $orderNumber;
    }
    public function getStats($startDate = null, $endDate = null)
    {
        $sql = "SELECT 
                    COUNT(*) as total_orders,
                    SUM(total_amount) as total_revenue,
                    AVG(total_amount) as avg_order_value,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_orders,
                    COUNT(CASE WHEN status = 'processing' THEN 1 END) as processing_orders,
                    COUNT(CASE WHEN status = 'shipped' THEN 1 END) as shipped_orders,
                    COUNT(CASE WHEN status = 'delivered' THEN 1 END) as delivered_orders,
                    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_orders
                FROM {$this->table} WHERE 1=1";
        $params = [];
        if ($startDate) {
            $sql .= " AND created_at >= ?";
            $params[] = $startDate;
        }
        if ($endDate) {
            $sql .= " AND created_at <= ?";
            $params[] = $endDate;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getRecent($limit = 10)
    {
        $sql = "SELECT o.*, u.first_name, u.last_name, u.email,
                       COUNT(oi.id) as item_count
                FROM orders o 
                JOIN users u ON o.user_id = u.id
                LEFT JOIN order_items oi ON o.id = oi.order_id
                GROUP BY o.id
                ORDER BY o.created_at DESC 
                LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getByStatus($status, $limit = null, $offset = 0)
    {
        $sql = "SELECT o.*, u.first_name, u.last_name, u.email,
                       COUNT(oi.id) as item_count
                FROM orders o 
                JOIN users u ON o.user_id = u.id
                LEFT JOIN order_items oi ON o.id = oi.order_id
                WHERE o.status = ?
                GROUP BY o.id
                ORDER BY o.created_at DESC";
        $params = [$status];
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}