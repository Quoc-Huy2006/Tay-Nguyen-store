<?php
session_start();
include "config.php";

/* =========================
   CHECK LOGIN
========================= */
if(!isset($_SESSION['user_id'])){
    echo "<script>
        alert('Bạn phải đăng nhập!');
        window.location='login.php';
    </script>";
    exit();
}

/* =========================
   MUA NGAY → TẠO CART TẠM
========================= */
if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    $_SESSION['cart'] = [];
    $_SESSION['cart'][$id] = 1;
}

/* =========================
   CHECK CART
========================= */
if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    echo "<h3 style='text-align:center'>Bạn chưa chọn sản phẩm!</h3>";
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   LẤY ĐỊA CHỈ
========================= */
$addressData = null;
$res = $conn->query("SELECT * FROM user_address WHERE user_id=$user_id LIMIT 1");
if($res && $res->num_rows > 0){
    $addressData = $res->fetch_assoc();
}

/* =========================
   LẤY SẢN PHẨM
========================= */
$products = [];
$total = 0;

foreach($_SESSION['cart'] as $id => $qty){

    $id = intval($id);
    $qty = intval($qty);

    $result = $conn->query("SELECT * FROM products WHERE id=$id");

    if($result && $result->num_rows > 0){

        $p = $result->fetch_assoc();

        $p['qty'] = $qty;
        $products[] = $p;

        $total += intval($p['price']) * $qty;
    }
}

include "header.php";
?>

<style>
.checkout{
    width:450px;
    margin:50px auto;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 0 10px #ccc;
}
.item{display:flex;gap:10px;margin-bottom:10px;border-bottom:1px solid #eee;padding-bottom:10px;}
.item img{width:80px;height:80px;object-fit:cover;}
.price{color:red;font-weight:bold;}
.total{font-size:18px;font-weight:bold;margin:10px 0;}
input{width:100%;padding:10px;margin:5px 0;}
button{padding:10px;width:100%;background:#006400;color:white;border:none;cursor:pointer;}
</style>

<div class="checkout">
    <h2>Thanh toán</h2>

    <?php foreach($products as $p){ ?>
        <div class="item">
            <img src="uploads/<?= $p['image'] ?>">
            <div>
                <h4><?= $p['name'] ?></h4>
                <p>Số lượng: <?= $p['qty'] ?></p>
                <p class="price">
                    <?= number_format($p['price'] * $p['qty']) ?>đ
                </p>
            </div>
        </div>
    <?php } ?>

    <div class="total">
        Tổng: <?= number_format($total) ?>đ
    </div>

    <form action="order_process.php" method="POST">

        <input type="text" name="name"
            value="<?= $addressData['fullname'] ?? '' ?>"
            placeholder="Tên người nhận" required>

        <input type="text" name="phone"
            value="<?= $addressData['phone'] ?? '' ?>"
            placeholder="SĐT" required>

        <input type="text" name="address"
            value="<?= $addressData['address'] ?? '' ?>"
            placeholder="Địa chỉ" required>

        <button type="submit">🛒 Đặt hàng</button>

    </form>
</div>

<?php include "footer.php"; ?>