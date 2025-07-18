<?php

namespace App\Core;

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $hidden = [];
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function findAll($limit = null, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($limit) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function where($conditions, $limit = null, $offset = 0)
    {
        $whereClause = [];
        $params = [];
        foreach ($conditions as $column => $value) {
            $whereClause[] = "`{$column}` = ?";
            $params[] = $value;
        }
        $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $whereClause);
        if ($limit) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $data = $this->filterFillable($data);
        $columns = '`' . implode('`, `', array_keys($data)) . '`';
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($data)) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    public function update($id, $data)
    {
        $data = $this->filterFillable($data);
        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "`{$column}` = :{$column}";
        }
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setClause) . " WHERE `{$this->primaryKey}` = :id";
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }
    public function count($conditions = [])
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $params = [];
        if (!empty($conditions)) {
            $whereClause = [];
            foreach ($conditions as $column => $value) {
                $whereClause[] = "`{$column}` = ?";
                $params[] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereClause);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    protected function filterFillable($data)
    {
        if (empty($this->fillable)) {
            return $data;
        }
        return array_intersect_key($data, array_flip($this->fillable));
    }
    protected function hideFields($data)
    {
        if (empty($this->hidden)) {
            return $data;
        }
        return array_diff_key($data, array_flip($this->hidden));
    }
    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }
    public function commit()
    {
        return $this->db->commit();
    }
    public function rollback()
    {
        return $this->db->rollback();
    }
}
