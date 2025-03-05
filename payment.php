<?php
session_start();

$cart = $_SESSION['cart'] ?? []; // ดึงข้อมูลตะกร้า
$shipping = 35; // ค่าจัดส่ง
$total = 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>
<div class="container">
    <div>
        <h3>ที่อยู่สำหรับจัดส่ง</h3>
        <form method="POST" action="process_payment.php">
            <input type="text" name="name" placeholder="ชื่อ" required>
            <input type="text" name="address1" placeholder="ที่อยู่" required>
            <input type="text" name="city" placeholder="เมือง" required>

            <h3>วิธีชำระเงิน</h3>
            <div class="payment-method">
                <label>
                    <input type="radio" name="payment_method" value="cash" checked> เงินสด
                </label>
                <label>
                    <input type="radio" name="payment_method" value="credit_card"> บัตรเครดิต
                </label>
            </div>

            <button type="submit" class="btn-primary">ยืนยันคำสั่งซื้อ</button>
        </form>
    </div>

    <div class="order-summary">
        <h3>สรุปคำสั่งซื้อ</h3>

        <?php if (!empty($cart)): ?>
            <ul>
                <?php foreach ($cart as $item): ?>
                    <?php 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <li>
                        <?= htmlspecialchars($item['name']) ?> (<?= $item['quantity'] ?> ชิ้น) 
                        <strong><?= number_format($subtotal, 2) ?> บาท</strong>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p>ราคารวมสินค้า: <?= number_format($total, 2) ?> บาท</p>
            <p>ค่าจัดส่ง: <?= number_format($shipping, 2) ?> บาท</p>
            <hr>
            <h4>ยอดรวมทั้งหมด: <?= number_format($total + $shipping, 2) ?> บาท</h4>
        <?php else: ?>
            <p style="color:red;">ไม่มีสินค้าในตะกร้า</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
