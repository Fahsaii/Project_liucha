<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
    <div class="container">
        <div class="products">
            <h2>Product</h2>
            <table>
                <tr>
                    <td><img src="path_to_image" alt="Analog Magazine Rack"></td>
                    <td>Analog Magazine Rack<br><span>Red</span></td>
                    <td>$120</td>
                    <td>
                        <button>-</button>
                        <span>2</span>
                        <button>+</button>
                    </td>
                    <td>$240</td>
                </tr>
                <tr>
                    <td><img src="path_to_image" alt="Closca helmet"></td>
                    <td>Closca helmet<br><span>Black</span></td>
                    <td>$132</td>
                    <td>
                        <button>-</button>
                        <span>1</span>
                        <button>+</button>
                    </td>
                    <td>$132</td>
                </tr>
                <tr>
                    <td><img src="path_to_image" alt="Sigg Water Bottle"></td>
                    <td>Sigg Water Bottle<br><span>Gravel Black</span></td>
                    <td>$23</td>
                    <td>
                        <button>-</button>
                        <span>2</span>
                        <button>+</button>
                    </td>
                    <td>$46</td>
                </tr>
            </table>
        </div>

        <div class="order-summary">
            <h2>Order Summary</h2>
            <p>Subtotal: <span>$418</span></p>
            <p>Shipping: <span>Free</span></p>
            <hr>
            <p>Total: <span>$418</span></p>
            <button class="checkout">CHECKOUT</button>
        </div>
    </div>
</body>
</html>