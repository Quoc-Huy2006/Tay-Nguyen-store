<?php
session_start();
include 'config.php';

// nếu chưa login
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// lấy id user
$id = $_SESSION['user_id'];

// lấy dữ liệu user
$sql = "SELECT * FROM users WHERE id=$id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>

<h2>Thông tin tài khoản</h2>

<form action="update_profile.php" method="POST" enctype="multipart/form-data">

    <label>Tên đăng nhập</label><br>
    <input type="text" name="username" value="<?php echo $user['username']; ?>"><br><br>

    <label>Mật khẩu mới</label><br>
    <input type="password" name="password"><br><br>

    <label>Avatar</label><br>
    <input type="file" name="avatar"><br><br>

    <?php if($user['avatar']) { ?>
        <img src="<?php echo $user['avatar']; ?>" width="100">
    <?php } ?>

    <br><br>
    <button type="submit">Cập nhật</button>

</form>

</body>
</html>