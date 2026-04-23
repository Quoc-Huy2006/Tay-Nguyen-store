<?php
session_start();
include "config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Ban khong co quyen truy cap");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Don hang</title>
</head>
<body>

<h2>Danh sach don hang</h2>

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
?>

    <p>
        Ma don: <?php echo $row['id']; ?> <br>
        Tong tien: <?php echo $row['total']; ?> VND <br>
        Trang thai: <?php echo $row['status']; ?> <br>

        <a href="admin_order_detail.php?id=<?php echo $row['id']; ?>">
            Xem chi tiet
        </a>
    </p>

    <hr>

<?php
    }
} else {
    echo "Khong co don hang";
}
?>

</body>
</html>