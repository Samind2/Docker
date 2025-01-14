<?php
require_once 'db/connect.php';

// ตรวจสอบหากเป็นการแก้ไขสินค้าจาก URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    // การอัปโหลดรูปภาพ
    $imageName = null;  // กำหนดชื่อไฟล์รูปภาพเป็น null เริ่มต้น
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imageName = time() . "_" . basename($image['name']);
        $imagePath = 'uploads/' . $imageName;
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    if ($id) {
        // แก้ไขข้อมูลสินค้า
        $sql = "UPDATE products SET name='$name', category='$category', price='$price', stock='$stock', description='$description', image='$imageName' WHERE id = $id";
    } else {
        // เพิ่มข้อมูลสินค้าใหม่
        $sql = "INSERT INTO products (name, category, price, stock, description, image) VALUES ('$name', '$category', '$price', '$stock', '$description', '$imageName')";
    }

    if ($conn->query($sql)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>เพิ่มสินค้า</title>
    <!-- เชื่อมต่อ style.css -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>เพิ่มสินค้า</h1>
    <form method="post" enctype="multipart/form-data">
        ชื่อสินค้า: <input type="text" name="name" required><br>
        หมวดหมู่: <input type="text" name="category" required><br>
        ราคา: <input type="number" name="price" required><br>
        สต็อก: <input type="number" name="stock" required><br>
        รายละเอียด: <textarea name="description" required></textarea><br>
        รูปภาพ: <input type="file" name="image"><br>
        <button type="submit">บันทึก</button>
    </form>
</body>

</html>