<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['user_id'];

// user
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

// orders
$orders = $conn->query("
    SELECT * FROM orders 
    WHERE user_id=$id 
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tài khoản</title>
    <style>
        body{font-family: Arial;background:#f0f2f5;margin:0;}
        .container{width:1100px;margin:30px auto;display:flex;gap:20px;}
        .left{width:280px;background:#fff;padding:20px;border-radius:10px;text-align:center;}
        .left img{width:120px;height:120px;border-radius:50%;object-fit:cover;}
        .right{flex:1;background:#fff;padding:20px;border-radius:10px;}
        input, button{width:100%;padding:10px;margin:5px 0;}
        button{background:#e74c3c;color:#fff;border:none;cursor:pointer;}
        .order{border:1px solid #ddd;margin-top:15px;padding:15px;border-radius:8px;}
        .status{padding:5px 10px;border-radius:5px;color:#fff;font-size:13px;}
        .pending{background:orange;}
        .shipping{background:#3498db;}
        .done{background:green;}
        .btn{padding:5px 10px;text-decoration:none;border-radius:5px;font-size:13px;margin-right:5px;}
        .delete{background:red;color:#fff;}
        .buy{background:green;color:#fff;}
        .eye{position:absolute;right:10px;top:10px;cursor:pointer;}
        .field{position:relative;}
    </style>
</head>

<body>

<div class="container">

    <!-- LEFT -->
    <div class="left">
        <img src="<?php echo $user['avatar'] ?: 'uploads/default.jpg'; ?>">
        <h3><?php echo $user['username']; ?></h3>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <a href="index.php" class="back-btn">← Trang chủ</a>
        <h2>Cập nhật thông tin</h2>

        <form action="update_profile.php" method="POST" enctype="multipart/form-data">

            <input type="text" name="username" value="<?php echo $user['username']; ?>" placeholder="Tên">

            <input type="email" name="email" value="<?php echo $user['email']; ?>" placeholder="Email">

            <div class="field">
                <input type="password" name="password" id="pass" placeholder="Mật khẩu mới">
                <span class="eye" onclick="toggle('pass')">👁</span>
            </div>

            <div class="field">
                <input type="password" name="confirm_password" id="repass" placeholder="Nhập lại mật khẩu">
                <span class="eye" onclick="toggle('repass')">👁</span>
            </div>

            <input type="file" name="avatar">

            <button>Cập nhật</button>
        </form>

        <hr>

        <h2>Đơn hàng của tôi</h2>

        <?php while($o = $orders->fetch_assoc()) { ?>

        <div class="order">
            <b>Mã đơn #<?php echo $o['id']; ?></b><br>

            <!-- FIX TOTAL -->
            Tổng: 
            <?php
            $total = $conn->query("
                SELECT SUM(price * quantity) as total 
                FROM order_details 
                WHERE order_id=".$o['id']."
            ")->fetch_assoc()['total'];

            echo number_format($total ?: 0);
            ?>đ
            <br>

            Trạng thái:
            <?php
            if($o['status']=='pending'){
             echo "<span class='status pending'>Chờ xử lý</span>";
                }elseif($o['status']=='shipping'){
                        echo "<span class='status shipping'>Đang giao</span>";
                    }elseif($o['status']=='cancelled'){
    echo "<span class='status' style='background:red;'>Đã hủy</span>";
            }else{
    echo "<span class='status done'>Hoàn thành</span>";
            }
            ?>

            <hr>

            <!-- CHI TIẾT -->
            <?php
            $details = $conn->query("
                SELECT od.*, p.name 
                FROM order_details od
                JOIN products p ON od.product_id = p.id
                WHERE od.order_id=".$o['id']."
            ");
            ?>

            <?php while($d = $details->fetch_assoc()) { ?>
                <p>
                    <?php echo $d['name']; ?> 
                    (x<?php echo $d['quantity']; ?>) 
                    - <?php echo number_format($d['price']); ?>đ
                </p>
            <?php } ?>

            <br>

            <a href="delete_order.php?id=<?php echo $o['id']; ?>" class="btn delete">Xóa</a>
            <a href="buy_again.php?id=<?php echo $o['id']; ?>" class="btn buy">Mua lại</a>

        <?php if($o['status']=='pending'){ ?>
            <a href="cancel_order.php?id=<?php echo $o['id']; ?>" 
                class="btn delete"
                onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                 Hủy đơn
            </a>
        <?php } ?>

        </div>

        <?php } ?>

    </div>

</div>

<script>
function toggle(id){
    let x = document.getElementById(id);
    x.type = x.type === "password" ? "text" : "password";
}
</script>

</body>
</html>