<?php
session_start();
include "config.php";

$user_id = 1;

// nếu có chọn sản phẩm
if(isset($_POST['selected'])){
    $selected = $_POST['selected'];
}else{
    echo "Không có sản phẩm!";
    exit();
}

$total = 0;
$products = [];

// 👉 lấy sản phẩm từ DB
foreach($selected as $id){
    $id = intval($id);

    if(isset($_SESSION['cart'][$id])){
        $qty = $_SESSION['cart'][$id];

        $sql = "SELECT * FROM products WHERE id=$id";
        $result = $conn->query($sql);
        $p = $result->fetch_assoc();

        $p['qty'] = $qty;
        $products[] = $p;

        $total += $p['price'] * $qty;
    }
}

// 👉 tạo đơn hàng
$sql = "INSERT INTO orders (user_id, total) VALUES ($user_id, $total)";
$conn->query($sql);

$order_id = $conn->insert_id;

// 👉 lưu chi tiết
foreach($products as $p){
    $sql = "INSERT INTO order_details (order_id, product_id, quantity, price)
            VALUES ($order_id, {$p['id']}, {$p['qty']}, {$p['price']})";
    $conn->query($sql);
}

// 👉 xóa sản phẩm đã mua khỏi giỏ
foreach($selected as $id){
    unset($_SESSION['cart'][$id]);
}

echo "<h3>Đặt hàng thành công!</h3>";
echo "<a href='index.php'>Về trang chủ</a>";
?>