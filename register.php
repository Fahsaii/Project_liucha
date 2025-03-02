<?php
session_start();

// ตรวจสอบว่าเมื่อสมัครแล้วให้รีไดเรกไปที่หน้า login.php
if (isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$error = '';
// ตรวจสอบการสมัครสมาชิกเมื่อฟอร์มถูกส่ง
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // ตรวจสอบว่ารหัสผ่านและยืนยันรหัสผ่านตรงกันหรือไม่
    if ($password != $confirmPassword) {
        $error = 'รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน';
    } else {
        // เก็บข้อมูลลงไฟล์ (หากใช้ฐานข้อมูลให้ทำการบันทึกในฐานข้อมูลแทน)
        $users = json_decode(file_get_contents('users.json'), true);

        if (isset($users[$username])) {
            $error = 'ชื่อผู้ใช้นี้มีผู้ใช้งานแล้ว';
        } else {
            // บันทึกข้อมูลผู้ใช้ใหม่
            $users[$username] = [
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'customer', // กำหนดเป็น customer โดยค่าเริ่มต้น
            ];

            // บันทึกข้อมูลผู้ใช้ลงในไฟล์
            file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));

            // รีไดเรกไปที่หน้า login.php
            header('Location: login.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <section class="register-form">
        <h2>สมัครสมาชิก</h2>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="register.php" method="POST">
            <label for="username">ชื่อผู้ใช้:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" id="password" required>
            
            <label for="confirmPassword">ยืนยันรหัสผ่าน:</label>
            <input type="password" name="confirmPassword" id="confirmPassword" required>
            
            <button type="submit">สมัครสมาชิก</button>
        </form>
        <p>มีบัญชีผู้ใช้แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
    </section>
</body>
</html>
