<?php
require_once 'config/database.php';

class Category {
    private $db;
    private $table = 'categories';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>