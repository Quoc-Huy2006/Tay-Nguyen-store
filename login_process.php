<?php
session_start();
include 'config.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if($email == '' || $password == ''){
    echo "<script>alert('Vui lòng nhập đầy đủ thông tin!');window.history.back();</script>";
    exit();
}

// chống SQL injection
$email = $conn->real_escape_string($email);

// tìm user
$sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result = $conn->query($sql);

if(!$result || $result->num_rows == 0){
    echo "<script>alert('Email không tồn tại!');window.history.back();</script>";
    exit();
}

$user = $result->fetch_assoc();

// check mật khẩu (plain text theo DB hiện tại của bạn)
if($password != $user['password']){
    echo "<script>alert('Sai mật khẩu!');window.history.back();</script>";
    exit();
}

// ================= SESSION CHUẨN =================
$_SESSION['user'] = $user['username'];
$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];

// ================= REDIRECT THEO ROLE =================
if($user['role'] == 'admin'){
    header("Location: admin.php");
} else {
    header("Location: index.php");
}
exit();
?>