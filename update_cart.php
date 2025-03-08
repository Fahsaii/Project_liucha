<?php
session_start();


$conn = new mysqli("localhost", "root", "", "liucha");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['action']) && isset($_GET['key'])) {
    $action = $_GET['action'];
    $key = $_GET['key'];

    if (isset($_SESSION['cart'][$key])) {
      
        if ($action === 'increase') {
            $_SESSION['cart'][$key]['quantity'] += 1;
        }
  
        if ($action === 'decrease' && $_SESSION['cart'][$key]['quantity'] > 1) {
            $_SESSION['cart'][$key]['quantity'] -= 1;
        }
    }
}


if (isset($_POST['menu_id']) && isset($_POST['quantity'])) {
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

  
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) {
            $_SESSION['cart'][$key]['quantity'] = $quantity;
            break;
        }
    }
}


if (isset($_POST['key']) && isset($_POST['topping'])) {
    $key = $_POST['key'];
    $topping_id = $_POST['topping'];

   
    $sql = "SELECT * FROM topping WHERE ToppingID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $topping_id);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($row = $result->fetch_assoc()) {
        $topping = [
            'id' => $row['ToppingID'],
            'name' => $row['Name'],
            'price' => $row['Price']
        ];

        
        if (!isset($_SESSION['cart'][$key]['toppings'])) {
            $_SESSION['cart'][$key]['toppings'] = [];
        }

        $_SESSION['cart'][$key]['toppings'][] = $topping;
    }
}


header("Location: cart.php");
exit();
?>
