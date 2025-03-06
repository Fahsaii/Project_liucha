<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "liucha");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า</title>
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Mali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>ตะกร้าสินค้า</h1>
        <a href="index.php">⬅ กลับไปหน้าแรก</a>
    </header>

    <div class="container">
        <div class="products">
            <h2>รายการสินค้า</h2>

            <table width="100%">
    <tr>
        <th>รูปภาพ</th>
        <th>สินค้า</th>
        <th>ราคา</th>
        <th>จำนวน</th>
        <th>ราคารวม</th>
        <th>จัดการ</th>
    </tr>

    <?php if (!empty($cart)): ?>
        <?php foreach ($cart as $key => $item): ?>
            <?php 
                $subtotal = $item['price'] * $item['quantity'];
            ?>
            <tr>
                <td><img src="image/<?= urlencode(htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img"></td>
                <td>
                    <?= htmlspecialchars($item['name']) ?>
                    
                    <!-- แสดง Topping ใต้ชื่อสินค้า -->
                    <?php if (!empty($item['toppings'])): ?>
                        <ul>
                            <?php foreach ($item['toppings'] as $topping): ?>
                                <li><?= htmlspecialchars($topping['name']) ?> (+<?= number_format($topping['price'], 2) ?> บาท)</li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </td>
                <td><?= number_format($item['price'], 2) ?> บาท</td>
                <td>
                    <a href="update_cart.php?action=decrease&key=<?= $key ?>"> - </a>
                    <?= $item['quantity'] ?>
                    <a href="update_cart.php?action=increase&key=<?= $key ?>"> + </a>
                </td>
                <td><?= number_format($subtotal, 2) ?> บาท</td>
                <td>
                    <a href="remove_item.php?key=<?= $key ?>" style="color:red;">ลบ</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" style="text-align:center;">ไม่มีสินค้าในตะกร้า</td>
        </tr>
    <?php endif; ?>
</table>

    </div>

    <div class="order-summary">
    <h2>สรุปคำสั่งซื้อ</h2>
        <?php 
        $total = 0; // รีเซ็ต total ใหม่
        if (!empty($cart)): 
        ?>
            <?php foreach ($cart as $key => $item): ?>
                <?php 
                $subtotal = $item['price'] * $item['quantity'];
                ?>
                
                <!-- แสดงสินค้าทีละแก้ว -->
                <?php for ($i = 0; $i < $item['quantity']; $i++): ?>
                    <p><?= htmlspecialchars($item['name']) ?> = <?= number_format($item['price'], 2) ?> บาท</p>

                    <!-- Dropdown เลือก Topping -->
                    <form action="update_cart.php" method="POST">
                        <input type="hidden" name="key" value="<?= $key ?>">
                        <select name="topping">
                            <option value="">-- เพิ่ม Topping --</option>
                            <?php
                            $sql = "SELECT * FROM topping WHERE MenuID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $item['menu_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()):
                            ?>
                                <option value="<?= $row['ID'] ?>"><?= htmlspecialchars($row['Name']) ?> (+<?= number_format($row['Price'], 2) ?> บาท)</option>
                            <?php endwhile; ?>
                        </select>
                        <button type="submit">เพิ่ม</button>
                    </form>

                    <!-- แสดง Topping แยกตามแต่ละแก้ว -->
                    <?php if (!empty($item['toppings'])): ?>
                        <ul>
                            <?php foreach ($item['toppings'] as $toppingKey => $topping): ?>
                                <li>
                                    + <?= htmlspecialchars($topping['name']) ?> (<?= number_format($topping['price'], 2) ?> บาท)
                                    <a href="remove_topping.php?key=<?= $key ?>&topping_key=<?= $toppingKey ?>" style="color:red;">ลบ</a>
                                </li>
                                <?php $subtotal += $topping['price']; // บวกเพิ่มเฉพาะแก้วนี้ ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <hr>
                <?php endfor; ?>

                <?php $total += $subtotal; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>ไม่มีสินค้าในตะกร้า</p>
        <?php endif; ?>

        <p>ราคารวมสินค้า: <?= number_format($total, 2) ?> บาท</p>
        <p>ค่าจัดส่ง: 35 บาท</p>
        <hr>
        <h3>ยอดรวมทั้งหมด: <?= number_format($total + 35, 2) ?> บาท</h3>
        <button class="checkout" onclick="window.location.href='payment.php'">สั่งซื้อสินค้า</button>

    </div>


    </div>
</body>
</html>
