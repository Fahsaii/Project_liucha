<?php
session_start();
include 'database/db.php';

// ✅ ตรวจสอบสิทธิ์
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("คุณไม่มีสิทธิ์เข้าถึงหน้านี้");
}

// ✅ ดึงข้อมูลจากตาราง customer และ menu
$customers = $conn->query("SELECT * FROM customer")->fetchAll(PDO::FETCH_ASSOC);
$menus = $conn->query("SELECT * FROM menu")->fetchAll(PDO::FETCH_ASSOC);

// ✅ ตรวจสอบการแก้ไขข้อมูล
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_customer'])) {
    $customerID = $_POST['customerID'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE customer SET Name = ?, Password = ?, Phone = ?, Email = ? WHERE CustomerID = ?");
    $stmt->execute([$name, $password, $phone, $email, $customerID]);

    header("Location: admin_panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
    <h2>Admin Panel - จัดการข้อมูล</h2>

    <h3>🔹 แก้ไขข้อมูลลูกค้า</h3>
    <table border="1">
        <tr>
            <th>CustomerID</th>
            <th>Name</th>
            <th>Password</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($customers as $customer): ?>
        <tr>
            <form method="POST">
                <td><?= $customer['CustomerID'] ?></td>
                <td><input type="text" name="name" value="<?= $customer['Name'] ?>"></td>
                <td><input type="text" name="password" value="<?= $customer['Password'] ?>"></td>
                <td><input type="text" name="phone" value="<?= $customer['Phone'] ?>"></td>
                <td><input type="email" name="email" value="<?= $customer['Email'] ?>"></td>
                <td>
                    <input type="hidden" name="customerID" value="<?= $customer['CustomerID'] ?>">
                    <button type="submit" name="update_customer">บันทึก</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>🔹 รายการเมนู</h3>
    <table border="1">
        <tr>
            <th>MenuID</th>
            <th>Name</th>
            <th>Price</th>
        </tr>
        <?php foreach ($menus as $menu): ?>
        <tr>
            <td><?= $menu['MenuID'] ?></td>
            <td><?= $menu['Name'] ?></td>
            <td><?= $menu['Price'] ?> บาท</td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>
