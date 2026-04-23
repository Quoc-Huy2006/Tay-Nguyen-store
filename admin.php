<?php
session_start();
include "config.php";

/* =========================
   CHECK ADMIN
========================= */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit();
}

/* =========================
   TAB CONTROL
========================= */
$tab = $_GET['tab'] ?? 'dashboard';

/* =========================
   THỐNG KÊ
========================= */
$product_count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc();
$user_count = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();
$order_count = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc();

/* DOANH THU CHỈ COMPLETED */
$revenue = $conn->query("
    SELECT SUM(total_price) as total 
    FROM orders 
    WHERE status='completed'
")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>

<style>
body{font-family:Arial;background:#f4f4f4;margin:0}
.sidebar{
    width:200px;height:100vh;background:#222;color:white;
    position:fixed;padding:20px;
}
.sidebar a{
    display:block;color:white;padding:10px;text-decoration:none
}
.sidebar a:hover{background:#444}

.content{margin-left:220px;padding:20px}

.box{display:flex;gap:15px;margin-bottom:20px}
.card{
    background:white;padding:15px;border-radius:10px;
    width:200px;text-align:center;box-shadow:0 0 10px #ccc;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
    margin-top:10px;
}
th,td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}
img{border-radius:5px}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3>⚙ ADMIN</h3>

    <a href="admin.php?tab=dashboard">📊 Dashboard</a>
    <a href="admin.php?tab=users">👤 User</a>
    <a href="admin.php?tab=orders">📦 Đơn hàng</a>
    <a href="products_admin.php">📦 Sản phẩm</a>
    <a href="logout.php">🚪 Đăng xuất</a>
    <a href="index.php">🚪 Trang Chủ</a>
</div>

<!-- CONTENT -->
<div class="content">

<!-- ================= DASHBOARD ================= -->
<?php if($tab == 'dashboard'){ ?>

<h2>Dashboard</h2>

<div class="box">

    <div class="card">
        <h3>Sản phẩm</h3>
        <h1><?= $product_count['total'] ?></h1>
    </div>

    <div class="card">
        <h3>User</h3>
        <h1><?= $user_count['total'] ?></h1>
    </div>

    <div class="card">
        <h3>Đơn hàng</h3>
        <h1><?= $order_count['total'] ?></h1>
    </div>

    <div class="card">
        <h3>Doanh thu</h3>
        <h1><?= number_format($revenue['total'] ?? 0) ?>đ</h1>
    </div>

</div>

<?php } ?>

<!-- ================= USER ================= -->
<?php if($tab == 'users'){ ?>

<h2>Danh sách User</h2>

<table>
<tr>
    <th>ID</th>
    <th>Avatar</th>
    <th>Username</th>
    <th>Email</th>
    <th>Password</th>
    <th>Role</th>
</tr>

<?php
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
while($u = $users->fetch_assoc()) { ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td>
        <?php if($u['avatar']) { ?>
            <img src="uploads/<?= $u['avatar'] ?>" width="40">
        <?php } ?>
    </td>
    <td><?= $u['username'] ?></td>
    <td><?= $u['email'] ?></td>
    <td><?= $u['password'] ?></td>
    <td><?= $u['role'] ?></td>
</tr>
<?php } ?>

</table>

<?php } ?>

<!-- ================= ORDERS ================= -->
<?php if($tab == 'orders'){ ?>

<h2>Quản lý đơn hàng</h2>

<!-- NÚT XÓA TẤT CẢ -->
<a href="delete_order.php?all=1"
   onclick="return confirm('Xóa tất cả đơn hàng?')"
   style="background:red;color:white;padding:8px 12px;text-decoration:none;border-radius:5px;">
   🗑 Xóa tất cả đơn
</a>

<table>
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Total</th>
    <th>Trạng thái</th>
    <th>Hành động</th>
</tr>

<?php
$orders = $conn->query("
    SELECT orders.*, users.username 
    FROM orders 
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.id DESC
");

while($o = $orders->fetch_assoc()) { ?>
<tr>
    <td><?= $o['id'] ?></td>
    <td><?= $o['username'] ?></td>
    <td><?= number_format($o['total_price']) ?>đ</td>
   <td>
<?php
if($o['status'] == 'shipping'){
    echo "<span style='color:orange'>Đang giao</span>";
}
elseif($o['status'] == 'delivered'){
    echo "<span style='color:blue'>Chờ nhận hàng</span>";
}
elseif($o['status'] == 'completed'){
    echo "<span style='color:green'>Thanh toán thành công</span>";
}
else{
    echo "<span>Chờ xử lý</span>";
}
?>
</td>

    <td>

        <a href="update_order.php?id=<?= $o['id'] ?>&status=shipping">🚚Đang Giao</a>
        <a href="update_order.php?id=<?= $o['id'] ?>&status=delivered">📦Chuyển Bị Nhận Hàng</a>
        <a href="update_order.php?id=<?= $o['id'] ?>&status=completed">💰 Thanh Toán Thành Công</a>

        <!-- XÓA 1 ĐƠN -->
        <a href="delete_order.php?id=<?= $o['id'] ?>"
           onclick="return confirm('Xóa đơn này?')"
           style="color:red;">🗑 xóa</a>

    </td>
</tr>
<?php } ?>
</table>

<?php } ?>

</div>

</body>
</html>