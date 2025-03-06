<?php 
session_start();

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "liucha");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการเพิ่มหรือลดจำนวน
if (isset($_GET['action']) && isset($_GET['key'])) {
    $action = $_GET['action'];
    $key = $_GET['key'];

    // ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
    if (isset($_SESSION['cart'][$key])) {
        // หากเพิ่มจำนวน
        if ($action === 'increase') {
            $_SESSION['cart'][$key]['quantity'] += 1;
        }
        // หากลดจำนวน
        if ($action === 'decrease' && $_SESSION['cart'][$key]['quantity'] > 1) {
            $_SESSION['cart'][$key]['quantity'] -= 1;
        }
    }
}

// อัปเดตตะกร้าเมื่อเพิ่มหรือลดจำนวนสินค้า
if (isset($_POST['menu_id']) && isset($_POST['quantity'])) {
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    // ตรวจสอบการเพิ่มจำนวนของสินค้า
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) {
            $_SESSION['cart'][$key]['quantity'] = $quantity;
            break;
        }
    }
}

// ตรวจสอบการเพิ่ม Topping
if (isset($_POST['key']) && isset($_POST['topping']) && !empty($_POST['topping'])) {
    $key = $_POST['key']; // ใช้ key ของสินค้าที่ต้องการเพิ่ม Topping
    $topping_id = $_POST['topping'];

    // ดึงข้อมูล Topping จากฐานข้อมูล
    $sql = "SELECT * FROM topping WHERE ToppingID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $topping_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $topping = $result->fetch_assoc();

    if ($topping) {
        // เพิ่ม Topping ในสินค้าในตะกร้า
        $_SESSION['cart'][$key]['toppings'][] = [
            'name' => $topping['Name'],
            'price' => $topping['Price']
        ];
    }
}

// รีไดเรกไปที่หน้าตะกร้า
header("Location: cart.php");
exit();
?>
