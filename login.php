<?php
session_start();
include 'database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // ✅ ค้นหาในตาราง admin ก่อน
        $stmt = $conn->prepare("SELECT * FROM admin WHERE Name = :username");
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && $password === $admin['Password']) {
            $_SESSION['user'] = $admin['Name'];
            $_SESSION['role'] = 'admin';
            header("Location: admin_panel.php"); // ✅ ส่งไปที่หน้าจัดการข้อมูล
            exit();
        }

        // ✅ ค้นหาในตาราง customer ถ้าไม่ใช่ admin
        $stmt = $conn->prepare("SELECT * FROM customer WHERE Name = :username");
        $stmt->execute(['username' => $username]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($customer && $password === $customer['Password']) {
            $_SESSION['user'] = $customer['Name'];
            $_SESSION['role'] = 'customer';
            header("Location: index.php"); // ✅ ส่งไปที่หน้าลูกค้า
            exit();
        }

        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!";
    } catch (PDOException $e) {
        $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - Liucha ชานม</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-form">
        <h2>เข้าสู่ระบบ</h2>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="login.php" method="POST">
            <label for="username">ชื่อผู้ใช้:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit">เข้าสู่ระบบ</button>
        </form>
        <p>ยังไม่มีบัญชีผู้ใช้? <a href="register.php">สมัครสมาชิก</a></p>
    </div>
</body>
</html>
