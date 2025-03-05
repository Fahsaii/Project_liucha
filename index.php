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
    $sql = "SELECT MenuID AS id, Name AS name, Price AS price FROM menu";
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
        
        <h1 id="menu" style="text-align: center; margin-top: 30px; font-family: 'Kanit', sans-serif; font-size: 40px; font-weight: 700; color: #DEB887;">
        Milk Tea
        </h1>

        <div class="product-container">
        <div class="product">
            <form action="add_to_cart.php" method="post">
            <input type="hidden" name="product_name" value="ชานมไต้หวัน">
            <input type="hidden" name="price" value="19">
            <img src="image/menu/milktea/taiwanmilktea.png" alt="chanom" class="product-img">
            <h3>ชานมไต้หวัน</h3>
            <p class="price">19 บาท</p>
            <button type="submit" class="add-btn"> add</button>
            </form>
        </div>
        <div class="product">
            <img src="image/menu/milktea/matcha.png" alt="chanom" class="product-img">
            <h3>ชาเขียว</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/thaitea.png" alt="chanom" class="product-img">
            <h3>ชาไทย</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/whitemaltmilktea.png" alt="chanom" class="product-img">
            <h3>ชานมไวท์มอลต์</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/caramelmilktea.png" alt="chanom" class="product-img">
            <h3>ชานมคาราเมล</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/melonmilktea.png" alt="chanom" class="product-img">
            <h3>ชานมเมล่อน</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/ovaltinemilktea.png" alt="chanom" class="product-img">
            <h3>ชานมโอวัลติน</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/honeymilktea.png" alt="chanom" class="product-img">
            <h3>ชานมน้ำผึ้ง</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/pinkmilktea.png" alt="chanom" class="product-img">
            <h3>ชานมชมพู</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/brownshugarmilktea.png" alt="chanom" class="product-img">
            <h3>ชานมบราวน์ชูการ์</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/cocaomilktea.png" alt="chanom" class="product-img">
            <h3>ชานมโกโก้</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/applemilktea.png" alt="chanom" class="product-img">
            <h3>ชานมแอปเปิ้ล</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/strawmilktea.png" alt="chanom" class="product-img">
            <h3>ชานมสตอเบอร์รี่</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/purplemilktea.png" alt="chanom" class="product-img">
            <h3>ชานมมันม่วง</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/milkteabutterfly.png" alt="chanom" class="product-img">
            <h3>ชานมอัญชัน</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/thaiteabutterfly.png" alt="chanom" class="product-img">
            <h3>ชาไทยอัญชัน</h3>
            <p class="price">29 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/milktea/coffeemilktea.png" alt="chanom" class="product-img">
            <h3>ชานมกาแฟ</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
    </div>

    <h1 style="text-align: center; margin-top: 30px; font-family: 'Kanit', sans-serif; font-size: 40px; font-weight: 700; color: #DEB887;">
        Green Tea
        </h1>

        <div class="product-container">
        <div class="product">
            <img src="image/menu/greentea/jasminegreentea.png" alt="chanom" class="product-img">
            <h3>ชาเขียวมะลิ</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/greentea/plumgreentea.png" alt="chanom" class="product-img">
            <h3>ชาเขียวบ๊วย</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/greentea/passionfruitgreentea.png" alt="chanom" class="product-img">
            <h3>ชาเขียวเสาวรส</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/greentea/applegreentea.png" alt="chanom" class="product-img">
            <h3>ชาเขียวแอปเปิ้ล</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/greentea/yogurtgreentea.png" alt="chanom" class="product-img">
            <h3>ชาเขียวโยเกิร์ต</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/greentea/yogurtapplegreentea.png" alt="chanom" class="product-img">
            <h3>ชาเขียวโยเกิร์ตแอปเปิ้ล</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        
        <div class="product">
            <img src="image/menu/greentea/yogurtstrawgreentea.png" alt="chanom" class="product-img">
            <h3>ชาเขียวโยเกิร์ตสตอเบอร์รี่</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/greentea/honeylemontea.png" alt="chanom" class="product-img">
            <h3>ชาน้ำผึ้งมะนาว</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
    </div>

    <h1 style="text-align: center; margin-top: 30px; font-family: 'Kanit', sans-serif; font-size: 40px; font-weight: 700; color: #DEB887;">
        Premium Milk Shake
        </h1>

        <div class="product-container">
        <div class="product">
            <img src="image/menu/premilk/frershmilktea.png" alt="chanom" class="product-img">
            <h3>ชานมสด</h3>
            <p class="price">49 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/premilk/milkovaltine.png" alt="chanom" class="product-img">
            <h3>นมโอวัลติน</h3>
            <p class="price">49 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/premilk/cocaomilk.png" alt="chanom" class="product-img">
            <h3>นมโกโก้</h3>
            <p class="price">49 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/premilk/milkpink.png" alt="chanom" class="product-img">
            <h3>นมชมพู</h3>
            <p class="price">49 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/premilk/milkmelon.png" alt="chanom" class="product-img">
            <h3>นมเมล่อน</h3>
            <p class="price">49 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/premilk/applemilk.png" alt="chanom" class="product-img">
            <h3>นมแอปเปิ้ล</h3>
            <p class="price">49 บาท</p>
            <button class="add-btn"> add</button>
        </div>
    </div>

    <h1 style="text-align: center; margin-top: 30px; font-family: 'Kanit', sans-serif; font-size: 40px; font-weight: 700; color: #DEB887;">
        SODA
        </h1>

        <div class="product-container">
        <div class="product">
            <img src="image/menu/soda/strawberrysoda.png" alt="chanom" class="product-img">
            <h3>สตอเบอร์รี่โซดา</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/soda/redlimesoda.png" alt="chanom" class="product-img">
            <h3>แดงมะนาวโซดา</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/soda/melonsoda.png" alt="chanom" class="product-img">
            <h3>เมล่อนโซดา</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/soda/lycheesoda.png" alt="chanom" class="product-img">
            <h3>ลิ้นจี่โซดา</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/soda/passionfruitsoda.png" alt="chanom" class="product-img">
            <h3>เสาวรสโซดา</h3>
            <p class="price">19 บาท</p>
            <button class="add-btn"> add</button>
        </div>
    </div>

    <h1 style="text-align: center; margin-top: 30px; font-family: 'Kanit', sans-serif; font-size: 40px; font-weight: 700; color: #DEB887;">
        Cream Cheese
        </h1>

        <div class="product-container">
        <div class="product">
            <img src="image/menu/fire/thaiteafire.png" alt="chanom" class="product-img">
            <h3>ชาเย็นชีสพ่นไฟ</h3>
            <p class="price">49 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/fire/cocaofire.png" alt="chanom" class="product-img">
            <h3>ชาโกโก้ชีสพ่นไฟ</h3>
            <p class="price">49 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/fire/matchafire.png" alt="chanom" class="product-img">
            <h3>ชาเขียวนมชีสพ่นไฟ</h3>
            <p class="price">49 บาท</p>
            <button class="add-btn"> add</button>
        </div>
    </div>

    <h1 style="text-align: center; margin-top: 30px; font-family: 'Kanit', sans-serif; font-size: 40px; font-weight: 700; color: #DEB887;">
        SPECIAL
        </h1>

        <div class="product-container">
        <div class="product">
            <img src="image/menu/special/chaliu.png" alt="chanom" class="product-img">
            <h3>ชาลิ่ว</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/orangecocao.png" alt="chanom" class="product-img">
            <h3>โกโก้ส้ม</h3>
            <p class="price">39 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/orangecoffee.png" alt="chanom" class="product-img">
            <h3>กาแฟส้ม</h3>
            <p class="price">39 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/blackchocolate.png" alt="chanom" class="product-img">
            <h3>แบล็กช็อคโกแลต</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/chacolatecaramel.png" alt="chanom" class="product-img">
            <h3>ช็อคโกแลตคาราเมล</h3>
            <p class="price">39 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/minthoneylemon.png" alt="chanom" class="product-img">
            <h3>มิ้นต์น้ำผึ้งมะนาว</h3>
            <p class="price">29 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/mintchoc.png" alt="chanom" class="product-img">
            <h3>ช็อคโกแลตมิ้นต์</h3>
            <p class="price">39 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/lemonrosetea.png" alt="chanom" class="product-img">
            <h3>ชากุหลาบมะนาว</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/rosemilktea.png" alt="chanom" class="product-img">
            <h3>ชานมกุหลาบ</h3>
            <p class="price">29 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/peach.png" alt="chanom" class="product-img">
            <h3>น้ำพีช</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/peachtea.png" alt="chanom" class="product-img">
            <h3>ชาพีช</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/blackcofeepeach.png" alt="chanom" class="product-img">
            <h3>กาแฟพีช</h3>
            <p class="price">29 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/purplelatte.png" alt="chanom" class="product-img">
            <h3>มันม่วงลาเต้</h3>
            <p class="price">24 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/cofeepurple.png" alt="chanom" class="product-img">
            <h3>กาแฟมันม่วง</h3>
            <p class="price">29 บาท</p>
            <button class="add-btn"> add</button>
        </div>
        <div class="product">
            <img src="image/menu/special/honeylemonadebutterfly.png" alt="chanom" class="product-img">
            <h3>อัญชันน้ำผึ้งมะนาว</h3>
            <p class="price">29 บาท</p>
            <button class="add-btn"> add</button>
        </div><div class="product">
            <img src="image/menu/special/lemonjuice.png" alt="chanom" class="product-img">
            <h3>น้ำเลม่อน</h3>
            <p class="price">34 บาท</p>
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
