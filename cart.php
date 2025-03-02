<?php
session_start();

// เมื่อมีการกดปุ่ม "ใส่ตะกร้า"
if (isset($_POST['add_to_cart'])) {
    $item = [
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'quantity' => 1 // จำนวนเริ่มต้น
    ];

    if (isset($_SESSION['cart'])) {
        // เช็คถ้ามีสินค้าซ้ำในตะกร้า
        $found = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['name'] === $item['name']) {
                $cart_item['quantity'] += 1; // เพิ่มจำนวนสินค้าถ้ามีซ้ำ
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = $item; // เพิ่มสินค้าลงตะกร้าใหม่
        }
    } else {
        $_SESSION['cart'] = [$item]; // สร้างตะกร้าขึ้นมาใหม่
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า - Liu Cha</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="image/logo_liucha.png" alt="Liu Cha" width="200px">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">กลับสู่หน้าแรก</a></li>
            </ul>
        </nav>
    </header>

    <section id="cart">
        <h2>ตะกร้าสินค้า</h2>
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <ul>
                <?php foreach ($_SESSION['cart'] as $cart_item): ?>
                    <li>
                        <?php echo $cart_item['name']; ?> - ฿<?php echo $cart_item['price']; ?> x <?php echo $cart_item['quantity']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>จำนวนรวม: ฿<?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $cart_item) {
                    $total += $cart_item['price'] * $cart_item['quantity'];
                }
                echo $total;
            ?></p>
        <?php else: ?>
            <p>ยังไม่มีสินค้าในตะกร้า.</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 Liu Cha | All rights reserved.</p>
    </footer>

</body>
</html>
