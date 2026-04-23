<?php
session_start();

if(isset($_POST['qty'])){
    foreach($_POST['qty'] as $id => $qty){
        $_SESSION['cart'][$id]['quantity'] = $qty;
    }
}

header("Location: cart.php");
?>