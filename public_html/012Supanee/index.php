<?php
require_once 'db/connect.php';

// Fetch product data from the database
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสินค้า</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1 class="text-center">รายการสินค้า</h1>
    <div class="text-center">
        <a href="add.php" class="add-product-btn">เพิ่มสินค้า</a>
    </div>

    <div class="card-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="card">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p>หมวดหมู่: <?= htmlspecialchars($row['category']) ?></p>
                <p>ราคา: ฿<?= number_format($row['price'], 2) ?></p>
                <p>สต็อก: <?= htmlspecialchars($row['stock']) ?></p>
                <div>
                    <?php if (!empty($row['image'])) { ?>
                        <img src="uploads/<?= $row['image'] ?>" alt="Product Image">
                    <?php } else { ?>
                        <p>ไม่มีรูปภาพ</p>
                    <?php } ?>
                </div>
                <div>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn">แก้ไข</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn"
                        onclick="return confirm('คุณต้องการลบสินค้านี้หรือไม่?')">ลบ</a>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

</html>