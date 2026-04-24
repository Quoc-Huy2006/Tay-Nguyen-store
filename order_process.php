<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
    die("Chưa đăng nhập");
}

$user_id = intval($_SESSION['user_id']);

/* =========================
   CHECK CART
========================= */
if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    die("Không có sản phẩm");
}

$total = 0;
$products = [];

/* =========================
   LẤY SẢN PHẨM TỪ CART
========================= */
foreach($_SESSION['cart'] as $id => $qty){

    $id = intval($id);
    $qty = intval($qty);

    $result = $conn->query("SELECT id, price FROM products WHERE id=$id");

    if($result && $result->num_rows > 0){

        $p = $result->fetch_assoc();

        $price = intval($p['price']);

        $total += $price * $qty;

        $products[] = [
            'id' => $id,
            'price' => $price,
            'qty' => $qty
        ];
    }
}

/* =========================
   TẠO ĐƠN
========================= */
$conn->query("
    INSERT INTO orders(user_id,total_price,status)
    VALUES($user_id,$total,'pending')
");

$order_id = $conn->insert_id;

/* =========================
   CHI TIẾT
========================= */
foreach($products as $p){

    $conn->query("
        INSERT INTO order_details(order_id,product_id,quantity,price)
        VALUES($order_id,{$p['id']},{$p['qty']},{$p['price']})
    ");
}

/* =========================
   CLEAR CART
========================= */
unset($_SESSION['cart']);

/* =========================
   SUCCESS
========================= */
echo "<script>
alert('Đặt hàng thành công!');
window.location='account.php';
</script>";