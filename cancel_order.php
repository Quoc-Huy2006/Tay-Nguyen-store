<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

/* =========================
   LẤY ĐƠN HÀNG
========================= */
$order = $conn->query("
    SELECT * FROM orders 
    WHERE id=$id AND user_id=$user_id
")->fetch_assoc();

if(!$order){
    die("Không tìm thấy đơn hàng");
}

/* =========================
   CHUẨN HÓA STATUS
========================= */
$status = trim(strtolower($order['status']));

/* =========================
   CHỈ ĐƯỢC HỦY KHI PENDING / PROCESSING
========================= */
if($status != 'pending' && $status != 'processing'){
    echo "<script>
        alert('Chỉ được hủy khi đơn đang chờ hoặc đang xử lý!');
        window.location='account.php';
    </script>";
    exit();
}

/* =========================
   UPDATE HỦY
========================= */
$conn->query("
    UPDATE orders 
    SET status='cancelled' 
    WHERE id=$id
");

echo "<script>
    alert('Đã hủy đơn hàng');
    window.location='account.php';
</script>";