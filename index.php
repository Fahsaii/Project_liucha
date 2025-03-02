<?php
session_start();

// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; // ค่าเริ่มต้นของ XAMPP
$password = ""; 
$dbname = "liucha"; 

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// คำสั่ง SQL เพื่อดึงข้อมูลสินค้าทั้งหมดจากตาราง products
$sql = "SELECT id, name, price FROM products";
$result = $conn->query($sql);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows > 0) {
    // มีข้อมูล
    $products = [];
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    $products = [];
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

// เช็คว่าเป็นผู้ดูแลระบบหรือไม่
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
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
                    <img src="image/chanom.png" alt="ชานมไข่มุก"  style="width: 150px; height: 150px;" >
                    <p>ชานมไข่มุก</p>
                    <p>ราคา: ฿45</p>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="name" value="ชานมไข่มุก">
                        <input type="hidden" name="price" value="45">
                        <button type="submit" name="add_to_cart">ใส่ตะกร้า</button>
                    </form>
            </div>
            <div class="menu-item"  >
                <img src="image/chanom.png" alt="ชานมไข่มุก" style="width: 150px; height: 150px;" >
                <p>ชานมไข่มุก</p>
                <p>ราคา: ฿45</p>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="name" value="ชานมไข่มุก">
                    <input type="hidden" name="price" value="45">
                    <button type="submit" name="add_to_cart">ใส่ตะกร้า</button>
                </form>
            </div>
            <div class="menu-item">
                    <img src="image/chanom.png" alt="ชานมไข่มุก"  style="width: 150px; height: 150px;" >
                    <p>ชานมไข่มุก</p>
                    <p>ราคา: ฿45</p>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="name" value="ชานมไข่มุก">
                        <input type="hidden" name="price" value="45">
                        <button type="submit" name="add_to_cart">ใส่ตะกร้า</button>
                    </form>
            </div>
            <div class="menu-item"  >
                <img src="image/chanom.png" alt="ชานมไข่มุก" style="width: 150px; height: 150px;" >
                <p>ชานมไข่มุก</p>
                <p>ราคา: ฿45</p>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="name" value="ชานมไข่มุก">
                    <input type="hidden" name="price" value="45">
                    <button type="submit" name="add_to_cart">ใส่ตะกร้า</button>
                </form>
            </div>
            <div class="menu-item">
                    <img src="image/chanom.png" alt="ชานมไข่มุก"  style="width: 150px; height: 150px;" >
                    <p>ชานมไข่มุก</p>
                    <p>ราคา: ฿45</p>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="name" value="ชานมไข่มุก">
                        <input type="hidden" name="price" value="45">
                        <button type="submit" name="add_to_cart">ใส่ตะกร้า</button>
                    </form>
            </div>
            <div class="menu-item"  >
                <img src="image/chanom.png" alt="ชานมไข่มุก" style="width: 150px; height: 150px;" >
                <p>ชานมไข่มุก</p>
                <p>ราคา: ฿45</p>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="name" value="ชานมไข่มุก">
                    <input type="hidden" name="price" value="45">
                    <button type="submit" name="add_to_cart">ใส่ตะกร้า</button>
                </form>
            </div><div class="menu-item">
                    <img src="image/chanom.png" alt="ชานมไข่มุก"  style="width: 150px; height: 150px;" >
                    <p>ชานมไข่มุก</p>
                    <p>ราคา: ฿45</p>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="name" value="ชานมไข่มุก">
                        <input type="hidden" name="price" value="45">
                        <button type="submit" name="add_to_cart">ใส่ตะกร้า</button>
                    </form>
            </div>
            <div class="menu-item"  >
                <img src="image/chanom.png" alt="ชานมไข่มุก" style="width: 150px; height: 150px;" >
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
