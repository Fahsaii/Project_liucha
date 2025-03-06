<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_id = $_POST['menu_id']; // รับค่า menu_id
    $topping_name = $_POST['topping']; // รับค่าชื่อ Topping

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;

    // ค้นหาว่าสินค้านี้มีในตะกร้าหรือไม่
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) {
            $found = true;

            // ถ้าไม่พบ topping นี้ในรายการสินค้า ก็เพิ่มเข้าไป
            if (!isset($_SESSION['cart'][$key]['toppings'])) {
                $_SESSION['cart'][$key]['toppings'] = [];
            }

            $already_added = false;
            foreach ($_SESSION['cart'][$key]['toppings'] as $topping) {
                if ($topping['name'] == $topping_name) {
                    $already_added = true;
                    break;
                }
            }

            // ถ้า topping ยังไม่ถูกเพิ่ม ก็เพิ่มไป
            if (!$already_added && !empty($topping_name)) {
                // ดึงราคาของ Topping จากฐานข้อมูล
                $conn = new mysqli("localhost", "root", "", "liucha");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // ดึงราคา Topping จากฐานข้อมูล
                $stmt = $conn->prepare("SELECT Price FROM topping WHERE Name = ?");
                $stmt->bind_param("s", $topping_name);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $topping_price = $row ? $row['Price'] : 0;

                // เพิ่ม Topping ลงในรายการสินค้า
                $_SESSION['cart'][$key]['toppings'][] = [
                    'name' => $topping_name,
                    'price' => $topping_price
                ];
            }
            break;
        }
    }

    // ถ้าไม่พบสินค้าในตะกร้า ก็เพิ่มสินค้าใหม่
    if (!$found) {
        $_SESSION['cart'][] = [
            'menu_id' => $menu_id,
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity'],
            'image' => $_POST['image'],
            'toppings' => $topping_name ? [[
                'name' => $topping_name,
                'price' => 0
            ]] : [] // ถ้าไม่เลือก topping ก็เป็น array ว่าง
        ];
    }
}

header("Location: cart.php"); // หลังจากเพิ่มเสร็จให้ redirect กลับไปที่หน้า cart
exit();
?>
