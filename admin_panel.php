<?php
session_start();
include 'database/db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("คุณไม่มีสิทธิ์เข้าถึงหน้านี้");
}


$customers = $conn->query("SELECT * FROM customer")->fetchAll(PDO::FETCH_ASSOC);
$menus = $conn->query("SELECT * FROM menu")->fetchAll(PDO::FETCH_ASSOC);
$toppings = $conn->query("SELECT * FROM topping")->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_customer'])) {
    $stmt = $conn->prepare("UPDATE customer SET Name = ?, Password = ?, Phone = ?, Email = ? WHERE CustomerID = ?");
    $stmt->execute([$_POST['Name'], $_POST['password'], $_POST['phone'], $_POST['email'], $_POST['customerID']]);
    header("Location: admin_panel.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_menu'])) {
    $stmt = $conn->prepare("UPDATE menu SET name = ?, price = ? WHERE MenuID = ?");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['menuID']]);
    header("Location: admin_panel.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_topping'])) {
    $stmt = $conn->prepare("UPDATE topping SET name = ?, price = ? WHERE ToppingID = ?");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['toppingID']]);
    header("Location: admin_panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script>
        function resetRow(row) {
            let inputs = row.querySelectorAll('input');
            inputs.forEach(input => input.value = input.defaultValue);
        }
    </script>
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
                <td><input type="text" name="name" value="<?= htmlspecialchars($customer['Name']) ?>"></td>
                <td><input type="text" name="password" value="<?= htmlspecialchars($customer['Password']) ?>"></td>
                <td><input type="text" name="phone" value="<?= htmlspecialchars($customer['Phone']) ?>"></td>
                <td><input type="email" name="email" value="<?= htmlspecialchars($customer['Email']) ?>"></td>
                <td>
                    <input type="hidden" name="customerID" value="<?= $customer['CustomerID'] ?>">
                    <button type="submit" name="update_customer">บันทึก</button>
                    <button type="button" onclick="resetRow(this.closest('tr'))">ยกเลิก</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>🔹 แก้ไขรายการเมนู</h3>
    <table border="1">
        <tr>
            <th>MenuID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($menus as $menu): ?>
        <tr>
            <form method="POST">
                <td><?= htmlspecialchars($menu['MenuID']) ?></td>
                <td><input type="text" name="name" value="<?= htmlspecialchars($menu['name']) ?>"></td>
                <td><input type="number" name="price" value="<?= $menu['price'] ?>"> บาท</td>
                <td>
                    <input type="hidden" name="menuID" value="<?= $menu['MenuID'] ?>">
                    <button type="submit" name="update_menu">บันทึก</button>
                    <button type="button" onclick="resetRow(this.closest('tr'))">ยกเลิก</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>🔹 แก้ไขข้อมูลท็อปปิ้ง</h3>
    <table border="1">
        <tr>
            <th>ToppingID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($toppings as $topping): ?>
        <tr>
            <form method="POST">
                <td><?= htmlspecialchars($topping['ToppingID']) ?></td>
                <td><input type="text" name="name" value="<?= htmlspecialchars($topping['Name']) ?>"></td>
                <td><input type="number" name="price" value="<?= htmlspecialchars($topping['Price']) ?>"></td>
                <td>
                    <input type="hidden" name="toppingID" value="<?= $topping['ToppingID'] ?>">
                    <button type="submit" name="update_topping">บันทึก</button>
                    <button type="button" onclick="resetRow(this.closest('tr'))">ยกเลิก</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>
