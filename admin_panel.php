<?php
session_start();
include 'database/db.php';

// ตรวจสอบสิทธิ์ Admin เท่านั้น
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: order.php");
    exit();
}

// ดึงข้อมูลจากฐานข้อมูล
$customers = $conn->query("SELECT * FROM customer")->fetchAll(PDO::FETCH_ASSOC);
$menus = $conn->query("SELECT * FROM menu")->fetchAll(PDO::FETCH_ASSOC);
$toppings = $conn->query("SELECT * FROM topping")->fetchAll(PDO::FETCH_ASSOC);

// อัปเดตข้อมูลลูกค้า
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_customer'])) {
    $stmt = $conn->prepare("UPDATE customer SET Name = ?, Password = ?, Phone = ?, Email = ? WHERE CustomerID = ?");
    $stmt->execute([$_POST['name'], $_POST['password'], $_POST['phone'], $_POST['email'], $_POST['customerID']]);
    header("Location: admin_panel.php");
    exit();
}

// อัปเดตข้อมูลเมนู (รวมถึงการอัปโหลดรูปภาพ)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_menu'])) {
    $menuID = $_POST['menuID'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // อัปโหลดไฟล์รูปภาพ
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = '' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image); // อัปโหลดไฟล์ไปยังโฟลเดอร์ images/
    }

    // อัปเดตข้อมูลเมนูในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE menu SET name = ?, price = ?, image = ? WHERE MenuID = ?");
    $stmt->execute([$name, $price, $image, $menuID]);
 
    header("Location: admin_panel.php");
    exit();
}

// อัปเดตข้อมูลท็อปปิ้ง
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_topping'])) {
    $toppingID = $_POST['toppingID'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // อัปโหลดไฟล์รูปภาพ
    $imageTopping = '';
    if (isset($_FILES['imageTopping']) && $_FILES['imageTopping']['error'] === UPLOAD_ERR_OK) {
        $imageTopping = '' . basename($_FILES['imageTopping']['name']);
        move_uploaded_file($_FILES['imageTopping']['tmp_name'], $imageTopping); // อัปโหลดไฟล์ไปยังโฟลเดอร์ images/
    }

    // อัปเดตข้อมูลท็อปปิ้งในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE topping SET Name = ?, Price = ?, imageTopping = ? WHERE ToppingID = ?");
    $stmt->execute([$name, $price, $imageTopping, $toppingID]);

    header("Location: admin_panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/panel.css">

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
    
    
    <nav>
        <a href="index.php">🏠 หน้าแรก (Home)</a> |
        <a href="logout.php">🚪 Logout</a>
    </nav>

 
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
                <td><?= htmlspecialchars($customer['CustomerID']) ?></td>
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
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php foreach ($menus as $menu): ?>
        <tr>
            <form method="POST" enctype="multipart/form-data">
                <td><?= htmlspecialchars($menu['MenuID']) ?></td>
                <td><input type="text" name="name" value="<?= htmlspecialchars($menu['name']) ?>"></td>
                <td><input type="number" name="price" value="<?= $menu['price'] ?>"> บาท</td>
                <td>
                    <img src="<?= htmlspecialchars($menu['image']) ?>" alt="Menu Image" width="100">
                    <input type="file" name="image">
                </td>
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
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php foreach ($toppings as $topping): ?>
        <tr>
            <form method="POST" enctype="multipart/form-data">
                <td><?= htmlspecialchars($topping['ToppingID']) ?></td>
                <td><input type="text" name="name" value="<?= htmlspecialchars($topping['Name']) ?>"></td>
                <td><input type="number" name="price" value="<?= htmlspecialchars($topping['Price']) ?>"></td>
                <td>
                    <img src="<?= htmlspecialchars($topping['imageTopping']) ?>" alt="Topping Image" width="100">
                    <input type="file" name="imageTopping">
                </td>
                <td>
                    <input type="hidden" name="toppingID" value="<?= $topping['ToppingID'] ?>">
                    <button type="submit" name="update_topping">บันทึก</button>
                    <button type="button" onclick="resetRow(this.closest('tr'))">ยกเลิก</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
