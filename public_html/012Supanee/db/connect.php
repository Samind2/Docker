<?php
$host = '127.0.0.1';
$user = 'root';
$pass = ''; // รหัสผ่าน MySQL (ถ้าไม่มีให้เว้นว่าง)
$dbname = 'shop';

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $user, $pass, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>