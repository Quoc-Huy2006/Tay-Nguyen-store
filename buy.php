<?php
session_start();
include "config.php";

/* =========================
   CHECK LOGIN
========================= */
if(empty($_SESSION['user_id'])){
    echo "<script>
        alert('Bạn phải đăng nhập trước!');
        window.location.href='login.php';
    </script>";
    exit();
}

/* =========================
   CHẶN ADMIN KHÔNG ĐƯỢC MUA
========================= */
if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
    echo "<script>
        alert('Admin không được phép mua hàng!');
        window.location.href='index.php';
    </script>";
    exit();
}

/* =========================
   LẤY PRODUCT ID
========================= */
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$_SESSION['product_id'] = $product_id;

/* =========================
   CHECK ĐỊA CHỈ USER
========================= */
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM user_address WHERE user_id=$user_id LIMIT 1";
$result = $conn->query($sql);

if($result && $result->num_rows > 0){
    header("Location: checkout.php?id=$product_id");
    exit();
}else{
    header("Location: address.php?id=$product_id");
    exit();
}
?>