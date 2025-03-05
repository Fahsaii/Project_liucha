<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; // ค่าเริ่มต้นของ XAMPP
$password = ""; // ค่าเริ่มต้นของ XAMPP
$dbname = "liucha"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการส่งข้อมูลจากฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // ตรวจสอบว่ารหัสผ่านและการยืนยันรหัสผ่านตรงกันหรือไม่
    if ($password !== $confirmPassword) {
        $error = "รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน";
    } else {
        // เข้ารหัสรหัสผ่าน
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // หารหัสลูกค้าถัดไป
        $result = $conn->query("SELECT MAX(CAST(SUBSTRING(CustomerID, 2) AS UNSIGNED)) AS max_id FROM customer");
        $row = $result->fetch_assoc();
        $max_id = $row['max_id'];

        // กำหนดรหัสลูกค้าเป็น 'C001' ถ้าไม่มีข้อมูล
        $new_customer_id = 'C' . str_pad(($max_id + 1), 3, '0', STR_PAD_LEFT);

        // คำสั่ง SQL เพื่อบันทึกข้อมูลผู้ใช้ใหม่ลงในตาราง customer
        $sql = "INSERT INTO customer (CustomerID, Name, Password, Phone, Email) 
                VALUES ('$new_customer_id', '$name', '$hashed_password', '$phone', '$email')";

        if ($conn->query($sql) === TRUE) {
            // ถ้าบันทึกสำเร็จ, redirect ไปที่หน้า login
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
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
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <section class="register-form">
        <h2>สมัครสมาชิก</h2>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="register.php" method="POST">
            <label for="name">ชื่อ:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">อีเมล:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="phone">เบอร์โทร:</label>
            <input type="text" name="phone" id="phone" required>
            
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
