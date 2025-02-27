<?php
session_start();


if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ข้อมูลล็อกอินของผู้ใช้งาน
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $users = [
        'admin' => ['password' => 'admin123', 'role' => 'admin'],
        'customer' => ['password' => 'customer123', 'role' => 'customer']
    ];

 
    if (isset($users[$username]) && $users[$username]['password'] == $password) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $users[$username]['role'];
        header('Location: index.php');
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="login-form">
        <h2>เข้าสู่ระบบ</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="login.php" method="POST">
            <label for="username">ชื่อผู้ใช้:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit">เข้าสู่ระบบ</button>
        </form>
    </section>
</body>
</html>
