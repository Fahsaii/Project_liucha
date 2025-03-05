<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน</title>
    <link href="https://fonts.googleapis.com/css2?family=Mali:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>

<!-- Bubble tea decoration -->
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>
    <div class="bubble-tea"></div>

    <header>
        <h1>ชำระเงิน</h1>
        <a href="cart.php">⬅ กลับไปตะกร้าสินค้า</a>
    </header>
    
    <div class="container">
        <div class="form-section">
            <h2>ที่อยู่จัดส่ง</h2>
            <form method="POST" action="checkout.php">
                <input type="text" name="name" placeholder="ชื่อ - นามสกุล" required>
                <input type="text" name="address1" placeholder="ที่อยู่ 1" required>
                <input type="text" name="address2" placeholder="อาคาร/ชั้น/ห้อง">
                <input type="text" name="city" placeholder="เมือง" required>
                <select name="state" required>
                    <option>เลือกจังหวัด</option>
                    <option>กรุงเทพมหานคร</option>
                    <option>เชียงใหม่</option>
                </select>
                <input type="text" name="zip" placeholder="รหัสไปรษณีย์" required>

                <h2>ช่องทางการชำระเงิน</h2>
                <div class="payment-method">
                    <button type="button" class="active">บัตรเครดิต</button>
                    <button type="button">วอลเล็ต</button>
                    <button type="button">เก็บเงินปลายทาง</button>
                </div>
                <input type="text" name="card_name" placeholder="ชื่อบนบัตร" required>
                <input type="text" name="card_number" placeholder="หมายเลขบัตร" required>
                <div class="row">
                    <select name="expiry_month">
                        <option>เดือน</option>
                        <option>01</option>
                        <option>02</option>
                    </select>
                    <select name="expiry_year">
                        <option>ปี</option>
                        <option>2025</option>
                        <option>2026</option>
                    </select>
                    <input type="text" name="cvv" placeholder="CVV" required>
                </div>
                <button type="submit" class="checkout">ยืนยันการสั่งซื้อ</button>
            </form>
        </div>

        <div class="order-summary">
            <h2>สรุปคำสั่งซื้อ</h2>
            <p>ชานมไข่มุกพรีเมียม x1</p>
            <p>ราคารวมสินค้า: 99 บาท</p>
            <p>ค่าจัดส่ง: ฟรี</p>
            <p>ภาษี: 8.92 บาท</p>
            <hr>
            <h3>ยอดรวมทั้งหมด: 107.92 บาท</h3>
        </div>
    </div>

</body>
</html>
