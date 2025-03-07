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
                            $subtotal = $item['price'] * $item['quantity']; // ราคารวมของสินค้า
                            $topping_total = 0; // ตัวแปรสำหรับคำนวณราคา Topping
                            
                            // คำนวณราคา Topping
                            if (!empty($item['toppings'])) {
                                foreach ($item['toppings'] as $topping) {
                                    $topping_total += $topping['price']; // รวมราคาของ Topping
                                }
                            }
                            
                            $total_price = $subtotal + $topping_total; // ราคารวม (รวม Topping)
                        ?>
                        <tr>
                            <td><img src="image/<?= urlencode(htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img"></td>
                            <td>
                                <?= htmlspecialchars($item['name']) ?>
                            </td>
                            <td><?= number_format($item['price'], 2) ?> บาท</td>
                            <td>
                                <a href="update_cart.php?action=decrease&key=<?= $key ?>"> - </a>
                                <?= $item['quantity'] ?>
                                <a href="update_cart.php?action=increase&key=<?= $key ?>"> + </a>
                            </td>
                            <td><?= number_format($total_price, 2) ?> บาท</td> <!-- แสดงราคารวม (รวม Topping) -->
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
            $counter = 1; // ตัวนับแก้ว
            if (!empty($cart)): 
            ?>
                <?php foreach ($cart as $key => $item): ?>
                    <?php 
                    $subtotal = $item['price'] * $item['quantity'];
                    $topping_total = 0;

                    // คำนวณราคา Topping
                    if (!empty($item['toppings'])) {
                        foreach ($item['toppings'] as $topping) {
                            $topping_total += $topping['price']; // รวมราคาของ Topping
                        }
                    }

                    $total_price = $subtotal + $topping_total; // ราคารวม (รวม Topping)
                    ?>
                    <!-- แสดงสินค้าทีละแก้ว -->
                    <?php for ($i = 0; $i < $item['quantity']; $i++): ?>
                        <p>แก้วที่ <?= $counter ?>: <?= htmlspecialchars($item['name']) ?> = <?= number_format($item['price'], 2) ?> บาท</p>

                        <!-- แสดง Topping สำหรับแก้วนั้น -->
                        <?php if (!empty($item['toppings'])): ?>
                            <ul>
                                <?php foreach ($item['toppings'] as $index => $topping): ?>
                                    <li>
                                        + <?= htmlspecialchars($topping['name']) ?> (<?= number_format($topping['price'], 2) ?> บาท)
                                        <!-- ลิงก์ลบ Topping -->
                                        <a href="remove_topping.php?key=<?= $key ?>&topping_key=<?= $index ?>" style="color:red;">ลบ</a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <!-- Dropdown เลือก Topping สำหรับแต่ละแก้ว -->
                        <form action="update_cart.php" method="POST">
                            <input type="hidden" name="key" value="<?= $key ?>"> <!-- key ของสินค้า -->
                            <label for="topping">เลือก Topping สำหรับแก้วนี้:</label>
                            <select name="topping" required> <!-- เพิ่ม 'required' เพื่อจำกัดการเลือก Topping ได้แค่ 1 ตัว -->
                                <option value="">-- เพิ่ม Topping --</option>
                                <?php
                                // ดึงข้อมูล Topping สำหรับสินค้าแต่ละประเภท
                                $sql = "SELECT * FROM topping WHERE MenuID = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s", $item['menu_id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()):
                                ?>
                                    <option value="<?= $row['ToppingID'] ?>"><?= htmlspecialchars($row['Name']) ?> (+<?= number_format($row['Price'], 2) ?> บาท)</option>
                                <?php endwhile; ?>
                            </select>
                            <button type="submit">เพิ่ม</button>
                        </form>


                        <hr>
                        <?php $counter++; ?>
                    <?php endfor; ?>

                    <?php $total += $total_price; // รวมราคา Topping เข้าไปในยอดรวม ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>ไม่มีสินค้าในตะกร้า</p>
            <?php endif; ?>

            <p>ราคารวมสินค้า: <?= number_format($total, 2) ?> บาท</p>
            <p>ค่าจัดส่ง: 35 บาท</p>
            <hr>
            <h3>ยอดรวมทั้งหมด: <?= number_format($total + 35, 2) ?> บาท</h3> <!-- รวมค่าจัดส่ง -->
            <button class="checkout" onclick="window.location.href='payment.php'">สั่งซื้อสินค้า</button>

        </div>
    </div>
</body>
</html>
