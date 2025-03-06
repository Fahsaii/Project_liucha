<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_id = $_POST['menu_id']; // รับ menu_id จากฟอร์ม
    $topping_name = $_POST['topping']; // รับ topping จากฟอร์ม

    // ตรวจสอบว่า menu_id และ topping_name มีค่าหรือไม่
    if (empty($menu_id) || empty($topping_name)) {
        echo "กรุณาเลือก Topping หรือเมนู";
        exit();
    }

    // เช็คว่า ตะกร้า มีสินค้าอยู่หรือไม่
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // วนลูปเพื่อหาสินค้าที่ตรงกับ menu_id
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) { // ตรวจสอบว่า menu_id ตรงกับสินค้าตัวไหนในตะกร้า

            // เช็คว่าเมนูนี้มี Topping อยู่แล้วหรือไม่
            if (!isset($_SESSION['cart'][$key]['toppings'])) {
                $_SESSION['cart'][$key]['toppings'] = [];
            }

            // เช็คว่า Topping นี้ได้ถูกเพิ่มไปแล้วหรือยัง
            $already_added = false;
            foreach ($_SESSION['cart'][$key]['toppings'] as $topping) {
                if ($topping['name'] == $topping_name) {
                    $already_added = true;
                    break; // หาก Topping ซ้ำไม่ต้องเพิ่ม
                }
            }

            // ถ้า Topping ยังไม่ถูกเพิ่ม, ทำการเพิ่ม Topping
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

                // ตรวจสอบว่าพบ Topping หรือไม่
                if (!$row) {
                    echo "ไม่พบ Topping นี้ในฐานข้อมูล";
                    exit();
                }

                $topping_price = $row['Price'];

                // เพิ่ม Topping ในตะกร้า
                $_SESSION['cart'][$key]['toppings'][] = [
                    'name' => $topping_name,
                    'price' => $topping_price
                ];
            }

            break; // หยุดการวนลูปเมื่อเจอสินค้า
        }
    }

    // รีไดเรกกลับไปที่หน้าตะกร้า
    header("Location: cart.php");
    exit();
}
?>
