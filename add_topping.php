<?php if (!empty($cart)): ?>
    <?php 
    // ตัวแปรสำหรับติดตาม Topping ที่แสดงแล้วในตะกร้า
    $displayed_topping = [];
    ?>
    <?php foreach ($cart as $key => $item): ?>
        <?php 
        $subtotal = $item['price'] * $item['quantity'];
        $topping_total = 0;

      
        if (!empty($item['toppings'])) {
            foreach ($item['toppings'] as $topping) {
                $topping_total += $topping['price']; 
            }
        }

        $total_price = $subtotal + $topping_total; 
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

        
        <?php if (!empty($item['toppings'])): ?>
            <tr>
                <td colspan="6">
                    <strong>Topping สำหรับแก้วที่ <?= $item['quantity'] ?>:</strong>
                    <ul>
                        <?php foreach ($item['toppings'] as $topping): ?>
                            <?php 
                            
                            if (!in_array($topping['id'], $displayed_topping)): ?>
                                <li>
                                    + <?= htmlspecialchars($topping['name']) ?> (<?= number_format($topping['price'], 2) ?> บาท)
                                    <a href="remove_topping.php?key=<?= $key ?>&topping_key=<?= $topping['id'] ?>" style="color:red;">ลบ</a>
                                </li>
                                <?php 
                                
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
