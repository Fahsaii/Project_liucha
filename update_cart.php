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

// ตรวจสอบการเลือก Topping
if (isset($_POST['key']) && isset($_POST['topping'])) {
    $key = $_POST['key'];
    $topping_id = $_POST['topping'];

    // ตรวจสอบว่า Topping ที่เลือกมีอยู่ในฐานข้อมูล
    $sql = "SELECT * FROM topping WHERE ToppingID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $topping_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // ถ้ามีข้อมูล Topping
    if ($row = $result->fetch_assoc()) {
        $topping = [
            'id' => $row['ToppingID'],
            'name' => $row['Name'],
            'price' => $row['Price']
        ];

        // เพิ่ม Topping ลงในสินค้าที่เลือก
        if (!isset($_SESSION['cart'][$key]['toppings'])) {
            $_SESSION['cart'][$key]['toppings'] = [];
        }
        
        // เช็คว่า Topping นี้ถูกเพิ่มไปแล้วหรือไม่
        $found = false;
        foreach ($_SESSION['cart'][$key]['toppings'] as $existingTopping) {
            if ($existingTopping['id'] == $topping['id']) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][$key]['toppings'][] = $topping;
        }
    }
}

// รีไดเรกไปที่หน้าตะกร้า
header("Location: cart.php");
exit();
?>
