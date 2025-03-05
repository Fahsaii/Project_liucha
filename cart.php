<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "liucha");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0; 
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

                <?php if (!empty($cart)): ?>
                    <?php foreach ($cart as $key => $item): ?>
                        <?php 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;

                            $sql = "SELECT Name FROM topping WHERE MenuID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $item['menu_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $toppings = $result->fetch_all(MYSQLI_ASSOC);
                        ?>
                        <tr>
                            <td><img src="image/<?= urlencode(htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= number_format($item['price'], 2) ?> บาท</td>
                            <td>
                                <a href="update_cart.php?action=decrease&key=<?= $key ?>"> - </a>
                                <?= $item['quantity'] ?>
                                <a href="update_cart.php?action=increase&key=<?= $key ?>"> + </a>
                            </td>
                            <td><?= number_format($subtotal, 2) ?> บาท</td>

            
                            <td>
                                <form action="add_topping.php" method="POST">
                                    <input type="hidden" name="menu_id" value="<?= htmlspecialchars($item['menu_id']) ?>">
                                    <select name="topping">
                                        <option value="">  เลือก Topping  </option>
                                        <?php 
                                        $stmt = $conn->prepare("SELECT DISTINCT Name FROM topping WHERE MenuID = ?");
                                        $stmt->bind_param("s", $item['menu_id']);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($topping = $result->fetch_assoc()): ?>
                                            <option value="<?= htmlspecialchars($topping['Name']) ?>"><?= htmlspecialchars($topping['Name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <button type="submit">เพิ่ม</button>
                                </form>
                            </td>

                            <td>
                                <a href="remove_item.php?key=<?= $key ?>" style="color:red;">ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">ไม่มีสินค้าในตะกร้า</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="order-summary">
            <h2>สรุปคำสั่งซื้อ</h2>
            <p>ราคารวมสินค้า: <span><?= number_format($total, 2) ?> บาท</span></p>
            <p>ค่าจัดส่ง: <span>35 บาท</span></p>
            <hr>
            <p><b>ยอดรวมทั้งหมด: <span><?= number_format($total + 35, 2) ?> บาท</span></b></p>
            <button class="checkout" onclick="window.location.href='payment.php'">สั่งซื้อสินค้า</button>
        </div>
    </div>
</body>
</html>
