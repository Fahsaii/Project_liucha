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
$admins = $conn->query("SELECT * FROM admin")->fetchAll(PDO::FETCH_ASSOC);
$orders = $conn->query("SELECT * FROM orders")->fetchAll(PDO::FETCH_ASSOC);

// อัปเดตข้อมูลลูกค้า
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_customer'])) {
    $stmt = $conn->prepare("UPDATE customer SET Name = ?, Password = ?, Phone = ?, Email = ? WHERE CustomerID = ?");
    $stmt->execute([$_POST['name'], $_POST['password'], $_POST['phone'], $_POST['email'], $_POST['customerID']]);
    header("Location: admin_panel.php");
    exit();
}

// อัปเดตข้อมูล Admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_admin'])) {
    $stmt = $conn->prepare("UPDATE admin SET name = ?, Password = ?, Email = ? WHERE AdminID = ?");
    $stmt->execute([$_POST['name'], $_POST['password'], $_POST['email'], $_POST['adminID']]);
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
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image); // อัปโหลดไฟล์ไปยังโฟลเดอร์ images/
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
        move_uploaded_file($_FILES['imageTopping']['tmp_name'], 'images/' . $imageTopping); // อัปโหลดไฟล์ไปยังโฟลเดอร์ images/
    }

    // อัปเดตข้อมูลท็อปปิ้งในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE topping SET Name = ?, Price = ?, imageTopping = ? WHERE ToppingID = ?");
    $stmt->execute([$name, $price, $imageTopping, $toppingID]);

    header("Location: admin_panel.php");
    exit();
}

// อัปเดตข้อมูลคำสั่งซื้อ
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_order'])) {
    $stmt = $conn->prepare("UPDATE orders SET CustomerID = ?, ordersname = ?, tel = ?, address = ?, payment_method = ?, total_price = ?, order_date = ?, slip_image = ? WHERE ordersID = ?");
    $stmt->execute([$_POST['CustomerID'], $_POST['ordersname'], $_POST['tel'], $_POST['address'], $_POST['payment_method'], $_POST['total_price'], $_POST['order_date'], $_POST['slip_image'], $_POST['orderID']]);
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

    <!-- แก้ไขข้อมูล Admin -->
    <h3>🔹 แก้ไขข้อมูล Admin</h3>
    <table border="1">
        <tr>
            <th>AdminID</th>
            <th>Name</th>
            <th>Password</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($admins as $admin): ?>
        <tr>
            <form method="POST">
                <td><?= htmlspecialchars($admin['AdminID']) ?></td>
                <td><input type="text" name="name" value="<?= htmlspecialchars($admin['name']) ?>"></td>
                <td><input type="text" name="password" value="<?= htmlspecialchars($admin['Password']) ?>"></td>
                <td><input type="email" name="email" value="<?= htmlspecialchars($admin['Email']) ?>"></td>
                <td>
                    <input type="hidden" name="adminID" value="<?= $admin['AdminID'] ?>">
                    <button type="submit" name="update_admin">บันทึก</button>
                    <button type="button" onclick="resetRow(this.closest('tr'))">ยกเลิก</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- แก้ไขข้อมูลลูกค้า -->
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

    <!-- แก้ไขรายการเมนู -->
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

    <!-- แก้ไขข้อมูลท็อปปิ้ง -->
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

    <!-- แก้ไขข้อมูลคำสั่งซื้อ -->
    <h3>🔹 แก้ไขข้อมูลคำสั่งซื้อ</h3>
    <table border="1">
        <tr>
            <th>OrderID</th>
            <th>CustomerID</th>
            <th>OrderName</th>
            <th>Tel</th>
            <th>Address</th>
            <th>Payment Method</th>
            <th>Total Price</th>
            <th>Order Date</th>
            <th>Slip Image</th>
            <th>Action</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <form method="POST">
                <td><?= htmlspecialchars($order['ordersID']) ?></td>
                <td><input type="text" name="CustomerID" value="<?= htmlspecialchars($order['CustomerID']) ?>"></td>
                <td><input type="text" name="ordersname" value="<?= htmlspecialchars($order['ordersname']) ?>"></td>
                <td><input type="text" name="tel" value="<?= htmlspecialchars($order['tel']) ?>"></td>
                <td><input type="text" name="address" value="<?= htmlspecialchars($order['address']) ?>"></td>
                <td><input type="text" name="payment_method" value="<?= htmlspecialchars($order['payment_method']) ?>"></td>
                <td><input type="text" name="total_price" value="<?= htmlspecialchars($order['total_price']) ?>"></td>
                <td><input type="text" name="order_date" value="<?= htmlspecialchars($order['order_date']) ?>"></td>
                <td><input type="text" name="slip_image" value="<?= htmlspecialchars($order['slip_image']) ?>"></td>
                <td>
                    <input type="hidden" name="orderID" value="<?= $order['ordersID'] ?>">
                    <button type="submit" name="update_order">บันทึก</button>
                    <button type="button" onclick="resetRow(this.closest('tr'))">ยกเลิก</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
