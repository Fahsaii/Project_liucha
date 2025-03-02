<?php
session_start();

// เช็คว่ามีสินค้าตะกร้าหรือไม่
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: index.php'); // ถ้าไม่มีสินค้าตะกร้าให้กลับไปหน้าแรก
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สั่งซื้อ - Liu Cha</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="image/logo_liucha.png" alt="Liu Cha">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">หน้าแรก</a></li>
                <li><a href="menu.php">เมนู</a></li>
                <li><a href="cart.php">ตะกร้า</a></li>
            </ul>
        </nav>
    </header>

    <section class="order-form">
        <h2>กรอกข้อมูลการสั่งซื้อ</h2>

        <!-- แสดงรายละเอียดสินค้าในตะกร้า -->
        <h3>สินค้าที่เลือก:</h3>
        <table>
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>฿<?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    </tr>
                    <?php $total += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2"><strong>รวมทั้งหมด</strong></td>
                    <td><strong>฿<?php echo $total; ?></strong></td>
                </tr>
            </tbody>
        </table>

        <!-- ฟอร์มกรอกข้อมูล -->
        <form action="process_order.php" method="POST">
            <div class="form-group">
                <label for="name">ชื่อ-นามสกุล:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="address">ที่อยู่:</label>
                <textarea id="address" name="address" required></textarea>
            </div>

            <div class="form-group">
                <label for="phone">เบอร์โทรศัพท์:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="email">อีเมล (ถ้ามี):</label>
                <input type="email" id="email" name="email">
            </div>

            <div class="form-group">
                <button type="submit" class="btn">ยืนยันการสั่งซื้อ</button>
            </div>
        </form>
    </section>

    <footer>
        <p>&copy; 2025 Liu Cha | All rights reserved.</p>
    </footer>

</body>
</html>
