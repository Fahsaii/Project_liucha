<?php
session_start();


$conn = new mysqli("localhost", "root", "", "liucha");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['key']) && isset($_GET['topping_key'])) {
    $key = $_GET['key']; 
    $topping_key = $_GET['topping_key']; 

  
    if (isset($_SESSION['cart'][$key]) && isset($_SESSION['cart'][$key]['toppings'][$topping_key])) {
        
        unset($_SESSION['cart'][$key]['toppings'][$topping_key]);

     
        $_SESSION['cart'][$key]['toppings'] = array_values($_SESSION['cart'][$key]['toppings']);
    }
}


header("Location: cart.php");
exit();
?>
