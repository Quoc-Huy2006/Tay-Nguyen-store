<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();

$orders = $conn->query("
    SELECT * FROM orders 
    WHERE user_id=$user_id 
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Tài khoản</title>

<style>
body{font-family:Arial;background:#f4f4f4;margin:0}
.container{width:1000px;margin:30px auto}
.card{background:#fff;padding:20px;border-radius:10px;margin-bottom:20px}
.order{border:1px solid #ddd;padding:15px;margin-top:10px;border-radius:8px}
.status{padding:5px 10px;border-radius:5px;color:#fff;font-size:13px}
.pending{background:gray;}
.processing{background:orange;}
.shipping{background:blue;}
.done{background:green;}
.cancel{background:red;}
.btn{padding:6px 10px;border-radius:5px;color:#fff;text-decoration:none}
</style>

</head>
<body>

<div class="container">

<div class="card">
    <h2>Xin chào, <?= $user['username'] ?></h2>
</div>

<a href="index.php">🏠 Trang Chủ</a>

<div class="card">
    <h2>Đơn hàng của bạn</h2>

<?php while($o = $orders->fetch_assoc()) { ?>

<div class="order">
    <b>Đơn #<?= $o['id'] ?></b><br>
    Tổng: <?= number_format($o['total_price']) ?>đ<br>

    Trạng thái:
    <?php
    if($o['status']=='pending'){
        echo "<span class='status pending'>Chờ xử lý</span>";
    }elseif($o['status']=='processing'){
        echo "<span class='status processing'>Đang xử lý</span>";
    }elseif($o['status']=='shipping'){
        echo "<span class='status shipping'>Đang giao</span>";
    }elseif($o['status']=='completed'){
        echo "<span class='status done'>Hoàn thành</span>";
    }elseif($o['status']=='cancelled'){
        echo "<span class='status cancel'>Đã hủy</span>";
    }
    ?>

    <br><br>

    <?php if($o['status']=='pending' || $o['status']=='processing'){ ?>
        <a href="cancel_order.php?id=<?= $o['id'] ?>" class="btn" style="background:red"
           onclick="return confirm('Bạn muốn hủy đơn này?')">
           ❌ Hủy đơn
        </a>

    <?php } elseif($o['status']=='cancelled'){ ?>
        <span class="btn" style="background:red">❌ Đã hủy</span>
    <?php } ?>

</div>

<?php } ?>

</div>

</div>

</body>
</html>