<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>
<div class="container">
    <div>
        <h3>Shipping Address</h3>
        <form method="POST" action="checkout.php">
            <input type="text" name="name" placeholder="First & Last Name" required>
            <input type="text" name="address1" placeholder="Address 1" required>
            <input type="text" name="address2" placeholder="Apartment, Suite, etc">
            <input type="text" name="city" placeholder="City" required>
            <select name="state" required>
                <option>Select state</option>
                <option>Dubai</option>
                <option>Abu Dhabi</option>
            </select>
            <input type="text" name="zip" placeholder="Zip Code" required>

            <h3>Payment Method</h3>
            <div class="payment-method">
                <button type="button" class="active">Card</button>
                <button type="button">Wallet</button>
                <button type="button">COD</button>
            </div>
            <input type="text" name="card_name" placeholder="Name on Card" required>
            <input type="text" name="card_number" placeholder="Card Number" required>
            <select name="expiry_month">
                <option>MM</option>
                <option>01</option>
                <option>02</option>
            </select>
            <select name="expiry_year">
                <option>YYYY</option>
                <option>2025</option>
                <option>2026</option>
            </select>
            <input type="text" name="cvv" placeholder="CVV" required>
            <button type="submit" class="btn-primary">Place Order</button>
        </form>
    </div>

    <div class="order-summary">
        <h3>Order Summary</h3>
        <p>Gourmet Coffee Beans</p>
        <p>Subtotal: $99.00</p>
        <p>Shipping: $5.00</p>
        <p>Tax: $8.92</p>
        <h4>Total: $112.92</h4>
    </div>
</div>
</body>
</html>
