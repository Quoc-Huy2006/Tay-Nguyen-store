<?php
session_start();
include 'config.php';

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm = $_POST['confirm'];

/* =========================
   CHECK RỖNG
========================= */
if(empty($username) || empty($email) || empty($password)){
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
   CHECK TRÙNG EMAIL
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
$conn->query("
    INSERT INTO users(username,email,password,role)
    VALUES('$username','$email','$password','user')
");

echo "<script>
    alert('Đăng ký thành công!');
    window.location.href='login.php';
</script>";
exit();
?>