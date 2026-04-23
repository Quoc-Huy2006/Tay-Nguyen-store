<?php
session_start();
include "config.php";
$product_id = $_GET['id'] ?? 0;
include "header.php";
/* =========================
   CHẶN CHƯA ĐĂNG NHẬP
========================= */
if(!isset($_SESSION['user_id'])){
    echo "<script>
        alert('Bạn phải đăng nhập tài khoản để mua hàng!');
        window.location.href='login.php';
    </script>";
    exit();
}

/* =========================
   SAU KHI LOGIN MỚI LẤY USER_ID
========================= */
$user_id = $_SESSION['user_id'];

/* =========================
   LẤY ĐỊA CHỈ
========================= */
$addressData = null;

$sqlAddr = "SELECT * FROM user_address WHERE user_id=$user_id LIMIT 1";
$resAddr = $conn->query($sqlAddr);

if($resAddr && $resAddr->num_rows > 0){
    $addressData = $resAddr->fetch_assoc();
}
?>

<h2>Thông tin nhận hàng</h2>

<form method="POST" action="save_address.php">

    <input type="text" name="fullname"
        value="<?= $addressData['fullname'] ?? '' ?>"
        placeholder="Họ tên" required>

    <input type="text" name="phone"
        value="<?= $addressData['phone'] ?? '' ?>"
        placeholder="Số điện thoại" required>

    <textarea name="address"
        placeholder="Địa chỉ" required><?= $addressData['address'] ?? '' ?></textarea>

    <button>Lưu thông tin</button>

</form>