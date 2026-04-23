<?php
session_start();
include "config.php";

/* =========================
   CHECK LOGIN
========================= */
if(!isset($_SESSION['user_id'])){
    echo "<script>
        alert('Chưa đăng nhập');
        window.location.href='login.php';
    </script>";
    exit();
}

$user_id = intval($_SESSION['user_id']);

/* =========================
   CHECK CART CHUẨN
========================= */
if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    echo "<script>
        alert('Giỏ hàng trống');
        window.location.href='cart.php';
    </script>";
    exit();
}

$total = 0;
$products = [];

/* =========================
   TÍNH TOTAL
========================= */
foreach($_SESSION['cart'] as $id => $qty){

    $id = intval($id);
    $qty = intval($qty);

    if($qty <= 0) continue;

    $result = $conn->query("
        SELECT id, price 
        FROM products 
        WHERE id=$id
    ");

    if($result && $result->num_rows > 0){

        $p = $result->fetch_assoc();

        $price = floatval($p['price']);

        $total += $price * $qty;

        $products[] = [
            'id' => $id,
            'price' => $price,
            'qty' => $qty
        ];
    }
}

/* =========================
   CHECK TOTAL > 0
========================= */
if($total <= 0){
    echo "<script>
        alert('Không thể tạo đơn hàng (total = 0)');
        window.location.href='cart.php';
    </script>";
    exit();
}

/* =========================
   CREATE ORDER
========================= */
$conn->query("
    INSERT INTO orders(user_id,total_price,status)
    VALUES($user_id,$total,'pending')
");

$order_id = $conn->insert_id;

/* =========================
   SAVE ORDER DETAILS
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
window.location.href='index.php';
</script>";
exit();
?>