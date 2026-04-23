<?php
include "config.php";

if(isset($_GET['all'])){

    $conn->query("DELETE FROM order_details");
    $conn->query("DELETE FROM orders");

    header("Location: admin.php?tab=orders");
    exit();
}

if(isset($_GET['id'])){

    $id = intval($_GET['id']);

    $conn->query("DELETE FROM order_details WHERE order_id=$id");
    $conn->query("DELETE FROM orders WHERE id=$id");
}

header("Location: admin.php?tab=orders");
exit();
?>