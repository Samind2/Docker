<?php
require_once 'db/connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id = $id";
if ($conn->query($sql)) {
    header('Location: index.php'); // เมื่อลบแล้วให้กลับไปที่หน้า index.php
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>