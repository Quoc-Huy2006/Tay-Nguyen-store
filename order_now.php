<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);

// tạo giỏ hàng tạm
$_SESSION['cart'] = [];
$_SESSION['cart'][$id] = 1;

// chuyển qua checkout
header("Location: checkout.php");
exit();