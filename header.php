<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
include 'config.php';

// mặc định
$avatar = 'uploads/default.jpg';
$username = 'User';
$role = 'user';

if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];

    $u = $conn->query("SELECT username, avatar, role FROM users WHERE id=$id")->fetch_assoc();

    if($u){
        $username = $u['username'];
        $role = $u['role'];

        if(!empty($u['avatar'])){
            $avatar = $u['avatar'];
        }

        // cập nhật session luôn
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $role;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tay Nguyen Coffee</title>

    <style>
        body{margin:0;font-family:Arial;background:#f5f5f5;}

        .header{
            background:#6f4e37;
            color:#fff;
            padding:15px 0;
            position:relative;
            z-index:1000;
        }

        .container{
            width:1100px;
            margin:auto;
        }

        .nav{
            display:flex;
            align-items:center;
            justify-content:space-between;
        }

        .menu{
            flex:1;
            text-align:center;
        }

        .menu a{
            margin:0 15px;
            color:#fff;
            text-decoration:none;
            font-weight:bold;
        }

        .right{
            display:flex;
            align-items:center;
            gap:15px;
        }

        .cart-icon{
            font-size:20px;
            color:#fff;
            text-decoration:none;
        }

        /* AVATAR */
        .nav-avatar{
            width:32px;
            height:32px;
            border-radius:50%;
            object-fit:cover;
            border:2px solid #fff;
        }

        /* DROPDOWN */
        .user-dropdown{
            position:relative;
        }

        .user-toggle{
            display:flex;
            align-items:center;
            gap:6px;
            cursor:pointer;
            color:#fff;
        }

        .dropdown-menu{
            position:absolute;
            right:0;
            top:45px;
            background:#fff;
            min-width:180px;
            box-shadow:0 4px 10px rgba(0,0,0,0.2);
            border-radius:8px;
            overflow:hidden;

            opacity:0;
            transform:translateY(10px);
            transition:0.2s;
            pointer-events:none;
        }

        .dropdown-menu.show{
            opacity:1;
            transform:translateY(0);
            pointer-events:auto;
        }

        .dropdown-menu a{
            display:block;
            padding:10px;
            color:#333;
            text-decoration:none;
            border-bottom:1px solid #eee;
        }

        .dropdown-menu a:hover{
            background:#f2f2f2;
        }
    </style>
</head>

<body>

<div class="header">
    <div class="container nav">

        <div><strong>Tay Nguyen Coffee</strong></div>

        <div class="menu">
            <a href="index.php">Trang chủ</a>
            <a href="products.php">Sản phẩm</a>
            <a href="about.php">Về chúng tôi</a>
        </div>

        <div class="right">

            <a href="cart.php" class="cart-icon">🛒</a>

            <?php if(isset($_SESSION['user_id'])) { ?>

                <div class="user-dropdown" id="userDropdown">

                    <div class="user-toggle" onclick="toggleMenu()">
                        <img src="<?php echo $avatar; ?>" class="nav-avatar">
                        <span><?php echo $username; ?></span>
                    </div>

                    <div class="dropdown-menu" id="dropdownMenu">

                        <?php if($role == 'admin') { ?>
                            <a href="admin.php">⚙ Trang quản trị</a>
                        <?php } ?>

                        <a href="profile.php">👤 Tài khoản</a>
                        <a href="profile.php">📦 Đơn hàng</a>
                        <a href="logout.php">🚪 Đăng xuất</a>

                    </div>

                </div>

            <?php } else { ?>

                <a href="login.php">Đăng nhập</a>

            <?php } ?>

        </div>

    </div>
</div>

<div class="container">

<script>
function toggleMenu(){
    document.getElementById("dropdownMenu").classList.toggle("show");
}

// click ngoài → đóng
window.onclick = function(e){
    if(!e.target.closest('#userDropdown')){
        document.getElementById("dropdownMenu").classList.remove("show");
    }
}
</script>