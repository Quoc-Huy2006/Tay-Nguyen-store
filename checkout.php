<?php
session_start();
include "config.php";

/* =========================
   CHẶN CHƯA ĐĂNG NHẬP
========================= */
if(!isset($_SESSION['user_id'])){
    echo "<script>
        alert('Bạn phải đăng nhập mới được mua hàng!');
        window.location.href='login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   LẤY ĐỊA CHỈ USER
========================= */
$addressData = null;

$sqlAddr = "SELECT * FROM user_address WHERE user_id=$user_id LIMIT 1";
$resAddr = $conn->query($sqlAddr);

if($resAddr && $resAddr->num_rows > 0){
    $addressData = $resAddr->fetch_assoc();
}

include "header.php";

$products = [];
$total = 0;

/* =========================
   MUA NGAY
========================= */
if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM products WHERE id=$id";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $p = $result->fetch_assoc();
        $p['qty'] = 1;

        $products[] = $p;
        $total = intval($p['price']);
    }

/* =========================
   GIỎ HÀNG
========================= */
}else if(isset($_POST['selected'])){

    foreach($_POST['selected'] as $id){
        $id = intval($id);

        if(isset($_SESSION['cart'][$id])){

            $qty = is_array($_SESSION['cart'][$id])
                ? intval($_SESSION['cart'][$id]['quantity'])
                : intval($_SESSION['cart'][$id]);

            $sql = "SELECT * FROM products WHERE id=$id";
            $result = $conn->query($sql);
            $p = $result->fetch_assoc();

            $p['qty'] = $qty;
            $products[] = $p;

            $total += intval($p['price']) * $qty;
        }
    }

/* =========================
   KHÔNG CÓ SẢN PHẨM
========================= */
}else{
    echo "<h3 style='text-align:center;'>Bạn chưa chọn sản phẩm!</h3>";
    exit();
}
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

.item{
    display:flex;
    gap:10px;
    margin-bottom:10px;
    border-bottom:1px solid #eee;
    padding-bottom:10px;
}

.item img{
    width:80px;
    height:80px;
    object-fit:cover;
}

.price{color:red;font-weight:bold;}
.total{font-size:18px;font-weight:bold;margin:10px 0;}

input{
    width:100%;
    padding:10px;
    margin:5px 0;
}

button{
    padding:10px;
    width:100%;
    background:#006400;
    color:white;
    border:none;
    cursor:pointer;
}
</style>

<div class="checkout">
    <h2>Thanh toán</h2>

    <!-- SẢN PHẨM -->
    <?php foreach($products as $p){ ?>
        <div class="item">
            <img src="uploads/<?= $p['image'] ?>">
            <div>
                <h4><?= $p['name'] ?></h4>
                <p>Số lượng: <?= $p['qty'] ?></p>
                <p class="price">
                    <?= number_format($p['qty'] * intval($p['price']),0,',','.') ?>đ
                </p>
            </div>
        </div>
    <?php } ?>

    <!-- TỔNG TIỀN -->
    <div class="total">
        Tổng tiền: <?= number_format($total,0,',','.') ?>đ
    </div>

    <!-- THÔNG BÁO ĐỊA CHỈ -->
    <?php if($addressData){ ?>
        <p style="color:green;text-align:center;">
            ✔ Đã tải địa chỉ mặc định
        </p>
    <?php } else { ?>
        <p style="color:orange;text-align:center;">
            ⚠ Chưa có địa chỉ, vui lòng nhập
        </p>
    <?php } ?>

    <!-- FORM -->
    <form action="order_process.php" method="POST">

        <?php foreach($products as $p){ ?>
            <input type="hidden" name="selected[]" value="<?= $p['id'] ?>">
        <?php } ?>

        <input type="text" name="name"
            value="<?= $addressData['fullname'] ?? '' ?>"
            placeholder="Tên người nhận" required>

        <input type="text" name="phone"
            value="<?= $addressData['phone'] ?? '' ?>"
            placeholder="Số điện thoại" required>

        <input type="text" name="address"
            value="<?= $addressData['address'] ?? '' ?>"
            placeholder="Địa chỉ" required>

        <button>Đặt hàng</button>

    </form>
</div>

<?php include "footer.php"; ?>