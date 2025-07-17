<?php
namespace App\Models;
use App\Core\Model;
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'parent_id', 'sort_order', 'status'
    ];
    public function getActive()
    {
        return $this->where(['status' => 'active'], null, 0);
    }
    public function getBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND status = 'active'");
        $stmt->execute([$slug]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getWithProductCount()
    {
        $sql = "SELECT c.*, COUNT(p.id) as product_count 
                FROM categories c 
                LEFT JOIN products p ON c.id = p.category_id AND p.status = 'active'
                WHERE c.status = 'active'
                GROUP BY c.id 
                ORDER BY c.sort_order ASC, c.name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getParents()
    {
        return $this->where(['parent_id' => null, 'status' => 'active']);
    }
    public function getChildren($parentId)
    {
        return $this->where(['parent_id' => $parentId, 'status' => 'active']);
    }
    public function getHierarchy()
    {
        $categories = $this->getActive();
        return $this->buildHierarchy($categories);
    }
    private function buildHierarchy($categories, $parentId = null)
    {
        $hierarchy = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $category['children'] = $this->buildHierarchy($categories, $category['id']);
                $hierarchy[] = $category;
            }
        }
        return $hierarchy;
    }
    public function getBreadcrumb($categoryId)
    {
        $breadcrumb = [];
        $category = $this->find($categoryId);
        while ($category) {
            array_unshift($breadcrumb, $category);
            $category = $category['parent_id'] ? $this->find($category['parent_id']) : null;
        }
        return $breadcrumb;
    }
    public function slugExists($slug, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE slug = ?";
        $params = [$slug];
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    public function generateSlug($name, $excludeId = null)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $originalSlug = $slug;
        $counter = 1;
        while ($this->slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
}