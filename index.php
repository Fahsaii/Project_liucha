<?php
session_start();

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
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
    <title>Liu Cha - ร้านชานมไข่มุก</title>
    <link rel="stylesheet" href="css/index.css">
   
</head>
<body>

    <header>
        <div class="logo">
            <img src="image/logo_liucha.png" alt="Liu Cha" width= 200px>
        </div>
        <nav>
            <ul>
                <li><a href="#menu">เมนู</a></li>
                <li><a href="#about">เกี่ยวกับเรา</a></li>
                <li><a href="#contact">ติดต่อ</a></li>
                <?php if (isset($_SESSION['user'])) : ?>
                    <li><a href="logout.php" class="btn">ออกจากระบบ</a></li>
                <?php else : ?>
                    <li><a href="login.php" class="btn">เข้าสู่ระบบ</a></li>
                <?php endif; ?>
                <li><a href="cart.php" class="btn-cart">ตะกร้าสินค้า (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></li>
            </ul>
        </nav>
    </header>

    <section class="intro">
        <h2>ยินดีต้อนรับสู่ Liu Cha</h2>
        <p>ร้านชานมไข่มุกที่คุณต้องลอง</p>
    </section>

    <?php if ($isAdmin) : ?>
        <section class="admin-dashboard">
            <h2>ยินดีต้อนรับแอดมิน</h2>
            <p>ที่นี่คุณสามารถจัดการคำสั่งซื้อและข้อมูลต่าง ๆ ได้</p>
        </section>
    <?php else : ?>
        <section id="menu">
            <h2>เมนูของเรา</h2>
            <div class="menu-item">
                    <img src="image/chanom.png" alt="ชานมไข่มุก"  width= "100px" hight= "100px" >
                    <p>ชานมไข่มุก</p>
                    <p>ราคา: ฿45</p>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="name" value="ชานมไข่มุก">
                        <input type="hidden" name="price" value="45">
                        <button type="submit" name="add_to_cart">ใส่ตะกร้า</button>
                    </form>
            </div>
            <div class="menu-item"  >
                <img src="image/chanom.png" alt="ชานมไข่มุก" >
                <p>ชานมไข่มุก</p>
                <p>ราคา: ฿45</p>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="name" value="ชานมไข่มุก">
                    <input type="hidden" name="price" value="45">
                    <button type="submit" name="add_to_cart">ใส่ตะกร้า</button>
                </form>
            </div>



        </section>
    <?php endif; ?>

    <footer>
        <p>&copy; 2025 Liu Cha | All rights reserved.</p>
    </footer>

</body>
</html>
