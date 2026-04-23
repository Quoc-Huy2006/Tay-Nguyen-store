<?php
include "config.php";

$id = intval($_GET['id']);
$status = $_GET['status'];

/* =========================
   UPDATE STATUS
========================= */
$conn->query("UPDATE orders SET status='$status' WHERE id=$id");

/* =========================
   CHỈ TRỪ KHO KHI COMPLETED
========================= */
if($status == 'completed'){

    $items = $conn->query("
        SELECT product_id, quantity 
        FROM order_details 
        WHERE order_id=$id
    ");

    if($items && $items->num_rows > 0){

        while($i = $items->fetch_assoc()){

            $pid = intval($i['product_id']);
            $qty = intval($i['quantity']);

            // check stock
            $check = $conn->query("SELECT stock FROM products WHERE id=$pid");
            $p = $check->fetch_assoc();

            if($p){

                $stock = intval($p['stock']);

                // tránh âm kho
                if($stock >= $qty){

                    $conn->query("
                        UPDATE products 
                        SET stock = stock - $qty 
                        WHERE id=$pid
                    ");
                }
            }
        }
    }
}

header("Location: admin.php?tab=orders");
exit();
?>