<?php 
session_start();

$cart = $_SESSION['cart'] ?? []; // ดึงข้อมูลตะกร้า
$shipping = 35; // ค่าจัดส่ง
$total = 0;

// คำนวณราคารวมของสินค้าในตะกร้า
foreach ($cart as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;

    // คำนวณราคา topping
    if (!empty($item['toppings'])) {
        foreach ($item['toppings'] as $topping) {
            $total += $topping['price'];
        }
    }
}

// คำนวณยอดรวม
$grand_total = $total + $shipping;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน</title>
    <link rel="stylesheet" href="css/payment.css"> <!-- ใช้ CSS เดิม -->
</head>
<body>

<header>
    <h1>ชำระเงิน</h1>
    <a href="cart.php">⬅ กลับไปตะกร้าสินค้า</a>
</header>

<div class="container">
    <div class="form-section">
        <h2>ที่อยู่จัดส่ง</h2>
        <form method="POST" action="checkout.php" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="ชื่อ - นามสกุล" required>
            <input type="text" name="tel" placeholder="เบอร์โทรศัพท์" required>
            <input type="text" name="address1" placeholder="ที่อยู่" required>
            <input type="text" name="address3" placeholder="อาคาร/ชั้น/ห้อง">

            <h2>ช่องทางการชำระเงิน</h2>
            <div class="payment-method">
                <label>
                    <input type="radio" name="payment_method" value="QR Promptpay" required> QR Promptpay
                </label>
                <label>
                    <input type="radio" name="payment_method" value="เงินสด" required> เงินสด
                </label>
            </div>

            <!-- อัปโหลด QR Promptpay -->
            <div id="qrPromptpaySection">
                <img src="image/QRCODE.png" alt="QR Promptpay"><br/>
                <label>อัปโหลดสลิป:</label>
                <input type="file" name="slip" accept="image/*">
            </div>

            <!-- ส่งค่าราคารวมไป checkout.php -->
            <input type="hidden" name="total_price" value="<?= $grand_total ?>">

            <button type="submit" class="checkout">ยืนยันการสั่งซื้อ</button>
        </form>
    </div>

    <div class="order-summary">
        <h2>สรุปคำสั่งซื้อ</h2>
        <?php if (!empty($cart)): ?>
            <?php foreach ($cart as $item): ?>
                <?php 
                $subtotal = $item['price'] * $item['quantity'];
                ?>
                <p><?= htmlspecialchars($item['name']) ?> x<?= $item['quantity'] ?> = <?= number_format($subtotal, 2) ?> บาท</p>

                <?php if (!empty($item['toppings'])): ?>
                    <ul>
                        <?php foreach ($item['toppings'] as $topping): ?>
                            <li>+ <?= htmlspecialchars($topping['name']) ?> (<?= number_format($topping['price'], 2) ?> บาท)</li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>ไม่มีสินค้าในตะกร้า</p>
        <?php endif; ?>
        <p>ราคารวมสินค้า: <?= number_format($total, 2) ?> บาท</p>
        <p>ค่าจัดส่ง: <?= number_format($shipping, 2) ?> บาท</p>
        <hr>
        <h3>ยอดรวมทั้งหมด: <?= number_format($grand_total, 2) ?> บาท</h3>
    </div>
</div>

</body>
</html>
