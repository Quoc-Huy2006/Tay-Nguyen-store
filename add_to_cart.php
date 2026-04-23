<?php
session_start();
include "config.php";

$id = $_GET['id'];

// lay san pham
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// tao gio hang neu chua co
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// neu san pham da co -> tang so luong
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += 1;
} else {
    $_SESSION['cart'][$id] = [
        "name" => $product['name'],
        "price" => $product['price'],
        "image" => $product['image'],
        "quantity" => 1
    ];
}

header("Location: cart.php");
exit();