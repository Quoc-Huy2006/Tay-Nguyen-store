<?php
include "config.php";

$order_id = $_GET['id'];

// lay chi tiet don hang
$sql = "SELECT od.*, p.name 
        FROM order_details od
        JOIN products p ON od.product_id = p.id
        WHERE od.order_id = $order_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chi tiet don hang</title>
</head>
<body>

<h2>Chi tiet don hang</h2>

<?php
$total = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
?>

    <p>
        Ten: <?php echo $row['name']; ?> <br>
        Gia: <?php echo $row['price']; ?> <br>
        So luong: <?php echo $row['quantity']; ?> <br>
        Thanh tien: <?php echo $subtotal; ?> <br>
    </p>

    <hr>

<?php
    }

    echo "<h3>Tong tien: $total VND</h3>";
} else {
    echo "Khong co du lieu";
}
?>

<br>
<a href="admin_orders.php">Quay lai</a>

</body>
</html>