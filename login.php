<?php
session_start();
require_once('database/db.php');

// ตรวจสอบสถานะการล็อกอิน
if (isset($_SESSION['user'])) {
    header('Location: home.php');
    exit;
}

$error = '';

// การตรวจสอบข้อมูลล็อกอิน
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // โหลดข้อมูลผู้ใช้จากไฟล์
    $users = json_decode(file_get_contents('users.json'), true);

    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $users[$username]['role'];
        header('Location: index.php'); // ไปยังหน้า index.php หลังจากล็อกอิน
        exit;
    } else {
        $error = 'ข้อมูลล็อกอินไม่ถูกต้อง';
    } 
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <section class="login-form">
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
    </section>
</body>
</html>
