    <?php
    session_start();

    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "liucha"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $sql = "SELECT id, name, price FROM products";
    $result = $conn->query($sql);

    $conn->close();

    // เช็คว่าเป็นผู้ดูแลระบบหรือไม่
    $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    ?>

    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liu Cha - ร้านชานมไข่มุก</title>
        <link rel="stylesheet" href="css/index.css"> 
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    </head>
    <body>       
        <header>
            <div class="logo">
                <img src="image/logo_liucha.png" alt="Liu Cha">
                
                <?php if (isset($_SESSION['user'])): ?> 
                    <span>ยินดีต้อนรับ, <?= htmlspecialchars($_SESSION['user']); ?></span> | 
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>

            </div>
            <nav>
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="#menu">MENU</a></li>
                    <li><a href="#cart">CART</a></li>
                    <li><a href="#about">ABOUT</a></li>
                    <li><a href="#contact">CONTACT</a></li>
                </ul>
            </nav>
        </header>

        <!-- HERO SECTION -->
        <div class="hero">
            <h1>Liu Cha</h1>
        </div>

        <div class="product-container">
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/chanom.png" alt="chanom">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
    </div>

    <div class="menunew-title">NEW!</div>
    <div class="menunew-container">
        <div class="menunew-item">

            <img src="image/chocmint_new.jpg" alt="chocmint_new">
        </div>
        <div class="menunew-item">
            <img src="image/caramel_new.jpg" alt="Caramel Milk">
            
        </div>
        <div class="menunew-item">
            <img src="image/Rose_new.jpg" alt="Rose Milk Tea">
            
        </div>
    
    </div>
    
        <div class="description">
            ลิ่ว-ชา (Liu’-Cha) เป็นธุรกิจแฟรนไชส์ ชาไข่มุก โดยนำวัตถุดิบมาจากไต้หวัน  และชาเพื่อสุขภาพ
            ปัจจุบันมีมากกว่า 260 กว่าสาขาทั้งในประเทศ  สินค้าหลักๆไม่ได้มุ่งเน้นเพียง ชานมไข่มุก อย่างเดียว
            แต่ยังมีเมนูที่หลากหลาย และยังเน้นชาเพื่อสุขภาพสำหรับลูกค้าด้วย ชาหลักๆ ทำให้ได้รสชาติที่หอมอร่อยและใบชาที่
            ลิ่ว-ชา นำมาใช้ในการต้มมาจากไต้หวัน โดย เป็นใบชาอย่างดี ซึ่งจะมีความหอมและส่งผลต่อสุขภาพได้เป็นอย่างดี
            แฟรนไชส์ลิ่ว-ชา  แบ่งออกเป็น 6 แพ็กเกจ
        </div>

        <div class="contact">
            <h2>CONTACT US</h2>
            <p>📞 097-875-6666</p>
            <p>📞 096-875-3279</p>
            <p>📍 51/139 ม.3 ต.คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี 12120</p>
            <img src="image/Addfriends.png" alt="QR Code">
        </div>


        <footer>
            <p>&copy; 2025 Liu Cha | All rights reserved.</p>
        </footer>

    </body>
    </html>
