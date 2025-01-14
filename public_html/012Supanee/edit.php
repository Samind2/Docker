<?php
require_once 'db/connect.php';

// ตรวจสอบว่ามีการส่ง id มาใน URL หรือไม่
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ไม่มี ID สำหรับสินค้านี้";
    exit();
}

$id = $_GET['id'];  // ดึง id จาก URL
$result = $conn->query("SELECT * FROM products WHERE id = $id");

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows == 0) {
    echo "ไม่พบสินค้านี้ในฐานข้อมูล";
    exit();
}

$product = $result->fetch_assoc();  // ดึงข้อมูลสินค้า

// ตรวจสอบว่าเป็นการส่งข้อมูลมาแล้วหรือยัง
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    // การอัปโหลดรูปภาพ
    $imageName = $product['image']; // ใช้ชื่อรูปภาพเดิม ถ้าไม่มีการอัปโหลดใหม่
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imageName = time() . "_" . basename($image['name']);
        $imagePath = 'uploads/' . $imageName;
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    // อัปเดตข้อมูลสินค้า
    $sql = "UPDATE products SET name='$name', category='$category', price='$price', stock='$stock', description='$description', image='$imageName' WHERE id = $id";
    if ($conn->query($sql)) {
        header('Location: index.php'); // เมื่อบันทึกแล้วให้กลับไปที่หน้า index.php
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
    <title>แก้ไขสินค้า</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>แก้ไขสินค้า</h1>
    <form method="post" enctype="multipart/form-data">
        ชื่อสินค้า: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br>
        หมวดหมู่: <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required><br>
        ราคา: <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required><br>
        สต็อก: <input type="number" name="stock" value="<?= htmlspecialchars($product['stock']) ?>" required><br>
        รายละเอียด: <textarea name="description"
            required><?= htmlspecialchars($product['description']) ?></textarea><br>
        รูปภาพ: <input type="file" name="image"><br>
        <?php if ($product['image']) { ?>
            <img src="uploads/<?= $product['image'] ?>" alt="Product Image" width="100"><br>
        <?php } ?>
        <button type="submit">บันทึก</button>
    </form>
</body>

</html>