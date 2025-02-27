<?php
session_start();


if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}


$isAdmin = $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liu Cha - ร้านชานมไข่มุก</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Liu Cha</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#menu">เมนู</a></li>
                <li><a href="#about">เกี่ยวกับเรา</a></li>
                <li><a href="#contact">ติดต่อ</a></li>
                <li><a href="logout.php">ออกจากระบบ</a></li>
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
                <img src="bubble-tea.jpg" alt="ชานมไข่มุก">
                <p>ชานมไข่มุก</p>
                <p>ราคา: ฿45</p>
                <button>สั่งซื้อ</button>
            </div>
            <div class="menu-item">
                <img src="milk-tea.jpg" alt="ชานม">
                <p>ชานม</p>
                <p>ราคา: ฿40</p>
                <button>สั่งซื้อ</button>
            </div>
        </section>
    <?php endif; ?>

    <footer>
        <p>&copy; 2025 Liu Cha | All rights reserved.</p>
    </footer>
</body>
</html>
