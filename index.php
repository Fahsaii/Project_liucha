<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "liucha"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// แก้ไขคอลัมน์จาก Image เป็น Img
$sql = "SELECT MenuID AS id, name AS name, price AS price, image AS image FROM menu";
$result = $conn->query($sql);

// เช็คว่าดึงข้อมูลสำเร็จหรือไม่
if (!$result) {
    die("Query failed: " . $conn->error);
}

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
</head>
<body>       
    <header>
        <div class="logo">
            <img src="image/logo_liucha.png" alt="Liu Cha">
            <?php if (isset($_SESSION['user'])): ?> 
                <span>ยินดีต้อนรับ, <?= htmlspecialchars($_SESSION['user']); ?></span> | 
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>
        <nav>
            <ul>
                <li><a href="#">HOME</a></li>
                <li>
                    <input type="checkbox" id="menu-toggle" class="menu-toggle">
                    <label for="menu-toggle" style="cursor: pointer; font-weight: bold;">MENU</label>
                    <ul class="submenu">
                        <li><a href="#MilkTea">Milk Tea</a></li>
                        <li><a href="#GreenTea">Green Tea</a></li>
                        <li><a href="#PremiumMilkShake">Premium Milk Shake</a></li>
                        <li><a href="#SODA">SODA</a></li>
                        <li><a href="#CreamCheese">Cream Cheese</a></li>
                        <li><a href="#SPECIAL">SPECIAL</a></li>
                    </ul>
                </li>
                <li><a href="cart.php">CART</a></li>
                <li><a href="#about">ABOUT</a></li>
                <li><a href="#contact">CONTACT</a></li>
            </ul>
        </nav>
    </header>

    <!-- HERO SECTION -->
    <div class="hero">
        <h1>Liu Cha</h1>
    </div>

    <!-- แสดงเมนูจากฐานข้อมูล -->
    <h1 id="MilkTea" style="text-align: center; margin-top: 30px; font-family: 'Kanit', sans-serif; font-size: 40px; font-weight: 700; color: #DEB887;">
        Milk Tea
    </h1>

    <div class="product-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['name']) ?>">
                    <input type="hidden" name="price" value="<?= $row['price'] ?>">
                    <img src="image/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="product-img">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p class="price"><?= $row['price'] ?> บาท</p>
                    <button type="submit" class="add-btn">เพิ่ม</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <?php 

    $conn->close(); 
    ?>

    <div class="contact">
        <h2>CONTACT US</h2>
        <p>📞 097-875-6666</p>
        <p>📞 096-875-3279</p>
        <p>📍 51/139 ม.3 ต.คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี 12120</p>
        <img src="image/Addfriends.png" alt="QR Code">
    </div>

    <footer>
        <p>&copy; 2025 Liu Cha | All rights reserved.</p>
    </footer>
</body>
</html>
