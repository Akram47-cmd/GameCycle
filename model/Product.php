<?php
require_once 'config/database.php';

class Product {
    private $db;
    private $table = 'products';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $query = "SELECT p.*, c.name as category_name 
                  FROM {$this->table} p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM {$this->table} p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (title, description, price, category_id, image) 
                  VALUES (:title, :description, :price, :category_id, :image)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} 
                  SET title = :title, description = :description, price = :price, 
                      category_id = :category_id, image = :image 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function handleImageUpload($file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/products/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            $filepath = $uploadDir . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return $filepath;
            }
        }
        return null;
    }
}
?>