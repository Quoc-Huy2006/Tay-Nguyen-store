<?php
include 'header.php';
include 'config.php';


// nếu đã login thì đá về trang chính
if(isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <style>
        body{
            font-family: Arial;
            background:#f5f5f5;
        }

        .box{
            width:320px;
            margin:100px auto;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 0 10px #ccc;
        }

        input{
            width:100%;
            padding:10px;
            margin:8px 0;
        }

        button{
            width:100%;
            padding:10px;
            background:green;
            color:white;
            border:none;
            cursor:pointer;
        }

        h2{
            text-align:center;
        }

        .register{
            text-align:center;
            margin-top:10px;
        }

        .register a{
            color:blue;
            text-decoration:none;
        }

        .register a:hover{
            text-decoration:underline;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>Đăng nhập</h2>

    <form action="login_process.php" method="POST">

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Mật khẩu" required>

        <button type="submit">Đăng nhập</button>

    </form>

    <!-- phần đăng ký -->
    <div class="register">
        <p>Chưa có tài khoản?</p>
        <a href="register.php">Đăng ký ngay</a>
    </div>
</div>

</body>
</html>
<?php include 'footer.php'; ?>