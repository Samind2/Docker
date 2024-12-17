<?php
require_once 'Database.php';
class TitanicModel
{
    private $pdo;
    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }
    // Method: ดึงข้อมูลทั้งหมดจากตาราง titanic
    public function getAll()
    {
        $sql = "SELECT * FROM titanic";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}