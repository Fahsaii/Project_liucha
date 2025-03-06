<?php
session_start();

if (isset($_GET['action']) && isset($_GET['key'])) {
    $action = $_GET['action'];
    $key = $_GET['key'];

    // เช็คว่าเซสชั่นตะกร้าสินค้าอยู่หรือไม่
    if (isset($_SESSION['cart'][$key])) {
        // ถ้าคุณเลือกเพิ่มจำนวนสินค้า
        if ($action === 'increase') {
            $_SESSION['cart'][$key]['quantity'] += 1;
        }
        // ถ้าคุณเลือกลดจำนวนสินค้า
        if ($action === 'decrease' && $_SESSION['cart'][$key]['quantity'] > 1) {
            $_SESSION['cart'][$key]['quantity'] -= 1;
        }
    }
}

    // วนลูปผ่านสินค้าตะกร้าเพื่อตรวจสอบว่า menu_id ตรงกับสินค้าที่จะเพิ่ม Topping หรือไม่
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) {
            // ตรวจสอบว่ามีการเลือก Topping ไว้แล้วหรือไม่
            if (!isset($_SESSION['cart'][$key]['toppings'])) {
                $_SESSION['cart'][$key]['toppings'] = [];
            }

            // ตรวจสอบว่า Topping ที่จะเพิ่มซ้ำกันหรือไม่
            $already_added = false;
            foreach ($_SESSION['cart'][$key]['toppings'] as $topping) {
                if ($topping['name'] == $topping_name) {
                    $already_added = true; // ถ้าซ้ำให้ไม่เพิ่ม
                    break;
                }
            }

            // ถ้ายังไม่ซ้ำก็ให้เพิ่ม Topping ลงไปในสินค้านั้นๆ
            if (!$already_added) {
                // เชื่อมต่อฐานข้อมูลเพื่อดึงราคาของ Topping
                $conn = new mysqli("localhost", "root", "", "liucha");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // ดึงราคาของ Topping จากฐานข้อมูล
                $stmt = $conn->prepare("SELECT Price FROM topping WHERE Name = ?");
                $stmt->bind_param("s", $topping_name);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $topping_price = $row ? $row['Price'] : 0;

                // เพิ่ม Topping ลงในรายการ
                $_SESSION['cart'][$key]['toppings'][] = [
                    'name' => $topping_name,
                    'price' => $topping_price
                ];
            }

            break; // เมื่อพบสินค้าตรงตามที่ต้องการแล้ว ให้หยุดการวนลูป
        }
    }


// เมื่อเสร็จสิ้นแล้วให้ redirect กลับไปยังหน้า cart.php
header("Location: cart.php");
exit();
?>
