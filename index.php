<?php
session_start();


// คำนวณจำนวนสินค้าในตะกร้า
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "liucha"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลเมนูจากฐานข้อมูล
$sql = "SELECT MenuID AS id, name AS name, price AS price, image AS image FROM menu";
$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}

// ตรวจสอบว่าเป็นผู้ดูแลระบบหรือไม่
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$isLoggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liu Cha - ร้านชานมไข่มุก</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300;400&display=swap" rel="stylesheet">
</head>
<body>       
<header>
    <div class="logo">
            <img src="image/logo_liucha.png" alt="Liu Cha">

            <?php if (isset($_SESSION['user'])): ?>
                <span>ยินดีต้อนรับ, <?= htmlspecialchars($_SESSION['user']); ?></span> |
                
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="admin_panel.php">ADMIN PANEL</a> |
                <?php endif; ?>
                
                <a href="logout.php" style="color: red; font-weight: bold;">🚪 logout</a>
            <?php else: ?>
                <a href="login.php">🔑 login</a>
            <?php endif; ?>
        </div>

    <nav>
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="#menu">MENU</a></li>
            <li>
                <a href="cart.php">
                    CART <span class="cart-count">(<?= $cart_count ?>)</span>
                </a>
            </li>
            <li><a href="#contact">CONTACT</a></li>
            <?php if ($isAdmin): ?>
                <li><a href="admin_panel.php">ADMIN PANEL</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>


    <div class="hero">
        <h1>Liu Cha</h1>
    </div>

    <h2 id="MilkTea" style="text-align: center; margin-top: 30px; font-size: 40px; font-weight: 700; color: #DEB887;">
        เมนูเครื่องดื่ม
    </h2>

    <div id="menu" class="product-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['name']) ?>">
                    <input type="hidden" name="price" value="<?= $row['price'] ?>">
                    <img src="image/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="product-img">
                    <input type="hidden" name="image" value="<?= htmlspecialchars($row['image']) ?>">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p class="price"><?= $row['price'] ?> บาท</p>

                    <?php if (!isset($_SESSION['user'])): ?>
                        <!-- If the user is not logged in, show a message and disable the button -->
                        <button type="button" class="add-btn" onclick="alert('กรุณาล็อกอินก่อนเพิ่มสินค้า!')">เพิ่ม</button>
                    <?php else: ?>
                        <!-- If the user is logged in, show the regular Add button -->
                        <button type="submit" class="add-btn">เพิ่ม</button>
                    <?php endif; ?>
                </form>
            </div>
        <?php endwhile; ?>
    </div>


    <div class="menunew-title">NEW!</div>
    <div class="menunew-container">
        <div class="menunew-item">
            <img src="image/chocmint_new.jpg" alt="chocmint_new">
        </div>
        <div class="menunew-item">
            <img src="image/caramel_new.jpg" alt="Caramel Milk">
        </div>
        <div class="menunew-item">
            <img src="image/Rose_new.jpg" alt="Rose Milk Tea">
        </div>
    </div>

    <?php $conn->close(); ?>

    <div id="contact" class="contact">
        <h2>ติดต่อเรา</h2>
        <p>📞 097-875-6666</p>
        <p>📞 096-875-3279</p>
        <p>📍 51/139 ม.3 ต.คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี 12120</p>
        <img src="image/Addfriends.png" alt="QR Code">
    </div>

    <footer>
        <p>&copy; 2025 Liu Cha | All rights reserved.</p>
    </footer>

    <style>
        .cart-count {
            background-color: red;
            color: white;
            padding: 2px 6px;
            border-radius: 50%;
            font-size: 14px;
            margin-left: 5px;
        }
    </style>
</body>
</html>
