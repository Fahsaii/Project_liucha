<?php
$dir = "uploads/";
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
echo "โฟลเดอร์ uploads พร้อมใช้งาน!";
?>
