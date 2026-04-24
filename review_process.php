<?php
session_start();
include "config.php";

// kiểm tra login
if(!isset($_SESSION['user_id'])){
    die("Bạn phải đăng nhập để đánh giá");
}

// lấy dữ liệu
$product_id = $_POST['product_id'];
$user_id = $_SESSION['user_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// insert vào database
$sql = "INSERT INTO reviews(product_id, user_id, rating, comment)
        VALUES('$product_id', '$user_id', '$rating', '$comment')";

$conn->query($sql);

// quay lại trang chi tiết
header("Location: detail.php?id=".$product_id);
?>