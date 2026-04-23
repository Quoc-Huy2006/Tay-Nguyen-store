<?php
session_start();
include 'config.php';

// chỉ admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// xóa ảnh trước (optional nhưng nên có)
$product = $conn->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();

if($product && $product['image']){
    $path = "uploads/".$product['image'];
    if(file_exists($path)){
        unlink($path);
    }
}

// xóa sản phẩm
$conn->query("DELETE FROM products WHERE id=$id");

header("Location: products_admin.php");
exit();
?>