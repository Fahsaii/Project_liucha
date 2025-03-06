<?php
session_start();
$conn = new mysqli("localhost", "root", "", "liucha");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีข้อมูลในตะกร้าหรือไม่
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>ตะกร้าสินค้าไม่มีข้อมูล</p>";
    exit();
}
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
                    <th>เลือก Topping</th>
                    <th>จัดการ</th>
                </tr>

                <?php foreach ($_SESSION['cart'] as $key => $item): ?>
                    <?php 
                        $subtotal = $item['price'] * $item['quantity'];
                    ?>
                    <tr>
                        <td><img src="image/<?= urlencode(htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img"></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> บาท</td>
                        <td>
                            <!-- เพิ่มจำนวนสินค้า -->
                            <a href="update_cart.php?action=decrease&key=<?= $key ?>">-</a>
                            <?= $item['quantity'] ?>
                            <a href="update_cart.php?action=increase&key=<?= $key ?>">+</a>
                        </td>
                        <td><?= number_format($subtotal, 2) ?> บาท</td>

                        <td>
                            <!-- ฟอร์มการเลือก Topping สำหรับแต่ละเมนู -->
                            <form action="add_topping.php" method="POST">
                                <input type="hidden" name="menu_id" value="<?= htmlspecialchars($item['menu_id']) ?>">
                                <select name="topping">
                                    <option value="">เลือก Topping</option>
                                    <?php 
                                        $stmt = $conn->prepare("SELECT DISTINCT Name FROM topping");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($topping = $result->fetch_assoc()): ?>
                                            <option value="<?= htmlspecialchars($topping['Name']) ?>"><?= htmlspecialchars($topping['Name']) ?></option>
                                        <?php endwhile; ?>
                                </select>
                                <button type="submit">เพิ่ม</button>
                            </form>

                            <?php if (!empty($item['toppings'])): ?>
                                <ul>
                                    <?php foreach ($item['toppings'] as $topping): ?>
                                        <li><?= htmlspecialchars($topping['name']) ?> (ราคา: <?= number_format($topping['price'], 2) ?> บาท)</li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="remove_item.php?key=<?= $key ?>" style="color:red;">ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="order-summary">
            <h2>สรุปคำสั่งซื้อ</h2>
            <?php 
            $total = 0; 
            foreach ($_SESSION['cart'] as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <p><?= htmlspecialchars($item['name']) ?> x<?= $item['quantity'] ?> = <?= number_format($subtotal, 2) ?> บาท</p>

                <?php if (!empty($item['toppings'])): ?>
                    <ul>
                        <?php foreach ($item['toppings'] as $topping): ?>
                            <li>+ <?= htmlspecialchars($topping['name']) ?> (<?= number_format($topping['price'], 2) ?> บาท)</li>
                            <?php $total += $topping['price']; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endforeach; ?>

            <p>ราคารวมสินค้า: <?= number_format($total, 2) ?> บาท</p>
            <p>ค่าจัดส่ง: 35 บาท</p>
            <hr>
            <h3>ยอดรวมทั้งหมด: <?= number_format($total + 35, 2) ?> บาท</h3>
            <button class="checkout" onclick="window.location.href='payment.php'">สั่งซื้อสินค้า</button>
        </div>
    </div>
</body>
</html>
