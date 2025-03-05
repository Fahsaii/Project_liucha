<?php
session_start();
include 'database/db.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role']; 
            header("Location: index.php");
            exit();
        } else {
            $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!";
        }
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
    <div class="bubble-tea" style="left: 10%; animation-delay: 0s;"></div>
    <div class="bubble-tea" style="left: 30%; animation-delay: 1s;"></div>
    <div class="bubble-tea" style="left: 50%; animation-delay: 2s;"></div>
    <div class="bubble-tea" style="left: 70%; animation-delay: 3s;"></div>
    <div class="bubble-tea" style="left: 90%; animation-delay: 4s;"></div>

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