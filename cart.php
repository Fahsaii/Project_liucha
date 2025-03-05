<?php
session_start();


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
    <link href="https://fonts.googleapis.com/css2?family=Mali:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>

    <header>
        <h1>ตะกร้าสินค้า</h1>
        <a href="index.php">⬅ กลับไปหน้าแรก</a>
    </header>

    <div class="container">
        <div class="products">
            <h2>รายการสินค้า</h2>

            <table  width="100%">
                <tr>
                    <th>รูปภาพ</th>
                    <th>สินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>ราคารวม</th>
                    <th>จัดการ</th>
                </tr>

                <?php if (!empty($cart)): ?>
                    <?php foreach ($cart as $item): ?>
                        <?php 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <tr>
                        <td>
                            <img src="image/<?= urlencode(htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img">
                    </td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= number_format($item['price'], 2) ?> บาท</td>
                            <td>
                                <a href="update_cart.php?action=decrease&name=<?= urlencode($item['name']) ?>">➖</a>
                                <?= $item['quantity'] ?>
                                <a href="update_cart.php?action=increase&name=<?= urlencode($item['name']) ?>">➕</a>
                            </td>
                            <td><?= number_format($subtotal, 2) ?> บาท</td>
                            <td>
                                <a href="remove_item.php?name=<?= urlencode($item['name']) ?>" style="color:red;">ลบ</a>
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
            <p>ราคารวมสินค้า: <span><?= number_format($total, 2) ?> บาท</span></p>
            <p>ค่าจัดส่ง: <span>ฟรี</span></p>
            <hr>
            <p><b>ยอดรวมทั้งหมด: <span><?= number_format($total, 2) ?> บาท</span></b></p>
            <button class="checkout" onclick="window.location.href='checkout.php'">สั่งซื้อสินค้า</button>
        </div>
    </div>
    </body>
</html>
