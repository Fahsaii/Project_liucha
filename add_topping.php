<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_id = $_POST['menu_id']; 
    $topping_name = $_POST['topping']; 

   
    if (empty($menu_id) || empty($topping_name)) {
        echo "กรุณาเลือก Topping หรือเมนู";
        exit();
    }

  
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

   
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) { 

     
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

            if (!$already_added) {
            
                $conn = new mysqli("localhost", "root", "", "liucha");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $stmt = $conn->prepare("SELECT Price FROM topping WHERE Name = ?");
                $stmt->bind_param("s", $topping_name);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

          
                if (!$row) {
                    echo "ไม่พบ Topping นี้ในฐานข้อมูล";
                    exit();
                }

                $topping_price = $row['Price'];

                $_SESSION['cart'][$key]['toppings'][] = [
                    'name' => $topping_name,
                    'price' => $topping_price
                ];
            }

            break; 
        }
    }

   
    header("Location: cart.php");
    exit();
}
?>
