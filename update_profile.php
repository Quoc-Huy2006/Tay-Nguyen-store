<?php
session_start();
include 'config.php';

$id = $_SESSION['user_id'];
$username = $_POST['username'];

// 1. update username
$conn->query("UPDATE users SET username='$username' WHERE id=$id");

// 2. update password (nếu có nhập)
if(!empty($_POST['password'])){
    $password = $_POST['password'];
    $conn->query("UPDATE users SET password='$password' WHERE id=$id");
}

// 3. upload avatar
if(!empty($_FILES['avatar']['name'])){

    $file = "uploads/" . $_FILES['avatar']['name'];
    move_uploaded_file($_FILES['avatar']['tmp_name'], $file);

    $conn->query("UPDATE users SET avatar='$file' WHERE id=$id");
}

// update session lại tên
$_SESSION['username'] = $username;

echo "<script>
alert('Cập nhật thành công!');
window.location.href='profile.php';
</script>";
?>