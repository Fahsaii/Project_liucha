<?php if (!empty($cart)): ?>
    <?php 
    // ตัวแปรสำหรับติดตาม Topping ที่แสดงแล้วในตะกร้า
    $displayed_topping = [];
    ?>
    <?php foreach ($cart as $key => $item): ?>
        <?php 
        $subtotal = $item['price'] * $item['quantity'];
        $topping_total = 0;

        // คำนวณราคา Topping สำหรับแก้วนั้น ๆ
        if (!empty($item['toppings'])) {
            foreach ($item['toppings'] as $topping) {
                $topping_total += $topping['price']; // รวมราคาของ Topping
            }
        }

        $total_price = $subtotal + $topping_total; // ราคารวม (รวม Topping)
        ?>
        <tr>
            <td><img src="image/<?= urlencode(htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img"></td>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= number_format($item['price'], 2) ?> บาท</td>
            <td>
                <a href="update_cart.php?action=decrease&key=<?= $key ?>"> - </a>
                <?= $item['quantity'] ?>
                <a href="update_cart.php?action=increase&key=<?= $key ?>"> + </a>
            </td>
            <td><?= number_format($total_price, 2) ?> บาท</td>
            <td>
                <a href="remove_item.php?key=<?= $key ?>" style="color:red;">ลบ</a>
            </td>
        </tr>

        <!-- แสดง Topping เฉพาะสำหรับแก้วที่มีการเลือก Topping และแสดงแค่ 1 ครั้ง -->
        <?php if (!empty($item['toppings'])): ?>
            <tr>
                <td colspan="6">
                    <strong>Topping สำหรับแก้วที่ <?= $item['quantity'] ?>:</strong>
                    <ul>
                        <?php foreach ($item['toppings'] as $topping): ?>
                            <?php 
                            // เช็คว่า Topping นี้แสดงในตะกร้าแล้วหรือไม่
                            if (!in_array($topping['id'], $displayed_topping)): ?>
                                <li>
                                    + <?= htmlspecialchars($topping['name']) ?> (<?= number_format($topping['price'], 2) ?> บาท)
                                    <a href="remove_topping.php?key=<?= $key ?>&topping_key=<?= $topping['id'] ?>" style="color:red;">ลบ</a>
                                </li>
                                <?php 
                                // เก็บ Topping นี้ลงในตัวแปรเพื่อไม่ให้แสดงซ้ำ
                                $displayed_topping[] = $topping['id'];
                            endif;
                            ?>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        <?php endif; ?>

    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" style="text-align:center;">ไม่มีสินค้าในตะกร้า</td>
    </tr>
<?php endif; ?>
