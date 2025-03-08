<?php
session_start();


$conn = new mysqli("localhost", "root", "", "liucha");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$cart = $_SESSION['cart'] ?? [];


$total = 0;
if (!empty($cart)) {
    foreach ($cart as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $topping_total = 0;
        if (!empty($item['toppings'])) {
            foreach ($item['toppings'] as $topping) {
                $topping_total += $topping['price'];
            }
        }
        $total += $subtotal + $topping_total;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า</title>
    <link rel="stylesheet" href="css/cart.css">
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
                            $topping_total = 0;
                            if (!empty($item['toppings'])) {
                                foreach ($item['toppings'] as $topping) {
                                    $topping_total += $topping['price'];
                                }
                            }
                            $total_price = $subtotal + $topping_total;
                        ?>
                        <tr>
                            <td><img src="image/<?= urlencode(htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= number_format($item['price'], 2) ?> บาท</td>
                            <td>
                                <a href="update_cart.php?action=decrease&key=<?= urlencode($key) ?>"> - </a>
                                <?= $item['quantity'] ?>
                                <a href="update_cart.php?action=increase&key=<?= urlencode($key) ?>"> + </a>
                            </td>
                            <td><?= number_format($total_price, 2) ?> บาท</td>
                            <td><a href="remove_item.php?key=<?= urlencode($key) ?>" style="color:red;">ลบ</a></td>
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
            <p>ราคารวมสินค้า: <?= number_format($total, 2) ?> บาท</p>
            <p>ค่าจัดส่ง: 35 บาท</p>
            <hr>
            <h3>ยอดรวมทั้งหมด: <?= number_format($total + 35, 2) ?> บาท</h3>
            <button class="checkout" onclick="window.location.href='payment.php'">สั่งซื้อสินค้า</button>
        </div>
    </div>
</body>
</html>
