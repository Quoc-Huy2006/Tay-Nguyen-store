<?php
session_start();
include 'config.php';

$id = $_SESSION['user_id'];

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

// check password
if(!empty($password)){
    if($password != $confirm){
        echo "<script>alert('Mật khẩu không khớp');history.back();</script>";
        exit();
    }
}

// avatar
$avatar_sql = "";
if(!empty($_FILES['avatar']['name'])){
    $file = "uploads/" . time() . "_" . $_FILES['avatar']['name'];
    move_uploaded_file($_FILES['avatar']['tmp_name'], $file);
    $avatar_sql = ", avatar='$file'";
}

// password
$pass_sql = "";
if(!empty($password)){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $pass_sql = ", password='$password'";
}

// update
$conn->query("
    UPDATE users 
    SET username='$username',
        email='$email'
        $pass_sql
        $avatar_sql
    WHERE id=$id
");

echo "<script>alert('Cập nhật thành công');location='profile.php';</script>";