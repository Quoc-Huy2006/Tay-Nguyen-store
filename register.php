<?php
session_start();
include 'config.php';

/* =========================
   LẤY DATA
========================= */
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

/* =========================
   CHECK RỖNG
========================= */
if($username == '' || $email == '' || $password == ''){
    die("Thiếu thông tin");
}

/* =========================
   CHECK PASSWORD
========================= */
if($password !== $confirm){
    echo "<script>
        alert('Mật khẩu không khớp!');
        window.history.back();
    </script>";
    exit();
}

/* =========================
   CHECK EMAIL TRÙNG
========================= */
$check = $conn->query("SELECT id FROM users WHERE email='$email'");
if($check->num_rows > 0){
    echo "<script>
        alert('Email đã tồn tại!');
        window.history.back();
    </script>";
    exit();
}

/* =========================
   INSERT USER
========================= */
$sql = "INSERT INTO users(username,email,password,role)
        VALUES('$username','$email','$password','user')";

if($conn->query($sql)){

    echo "<script>
        alert('Đăng ký thành công!');
        window.location.href='login.php';
    </script>";

} else {

    echo "Lỗi SQL: " . $conn->error;
}

exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
    <style>
        body{
            font-family: Arial;
            background:#f5f5f5;
        }

        .box{
            width:350px;
            margin:100px auto;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 0 10px #ccc;
        }

        h2{
            text-align:center;
        }

        input{
            width:100%;
            padding:10px;
            margin:10px 0;
            display:block; /* QUAN TRỌNG */
        }

        button{
            width:100%;
            padding:10px;
            background:green;
            color:white;
            border:none;
            cursor:pointer;
        }

        .login{
            text-align:center;
            margin-top:10px;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>Đăng ký</h2>

    <form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="email" name="email" placeholder="Email" required>

<!-- PASSWORD -->
<div style="position:relative">
    <input type="password" id="pass" name="password" placeholder="Mật khẩu" required>
    <span onclick="togglePass('pass')" style="position:absolute;right:10px;top:8px;cursor:pointer">👁</span>
</div>

<!-- CONFIRM -->
<div style="position:relative">
    <input type="password" id="confirm" name="confirm" placeholder="Nhập lại mật khẩu" required>
    <span onclick="togglePass('confirm')" style="position:absolute;right:10px;top:8px;cursor:pointer">👁</span>
</div>

<button type="submit">Đăng ký</button>

</form>

<script>
function togglePass(id){
    let x = document.getElementById(id);
    if(x.type === "password"){
        x.type = "text";
    }else{
        x.type = "password";
    }
}
</script>

    <div class="login">
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </div>
</div>

</body>
</html>
<?php include 'footer.php'; ?>