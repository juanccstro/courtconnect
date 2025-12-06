<?php

require_once __DIR__ . '/../core/Database.php';

class BaseModel {

    protected $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function run($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function findById($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
        return $this->run($sql, [':id' => $id])->fetch();
    }
}
