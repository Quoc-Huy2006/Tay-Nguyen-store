<?php include 'header.php'; ?>
<?php include 'config.php'; ?>

<?php
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$row = $result->fetch_assoc();
?>

<div style="display:flex; gap:30px; background:white; padding:30px; border-radius:10px;">

    <!-- ẢNH -->
    <div>
        <img src="uploads/<?php echo $row['image']; ?>" width="350" style="border-radius:10px;">
    </div>

    <!-- THÔNG TIN -->
    <div style="flex:1;">
        <h2><?php echo $row['name']; ?></h2>

        <p style="color:red; font-size:22px; font-weight:bold;">
            <?php echo $row['price']; ?> VND
        </p>

        <p style="line-height:1.6;">
            <?php echo $row['description']; ?>
        </p>

        <br>

        <a href="add_to_cart.php?id=<?php echo $row['id']; ?>">
            <button style="padding:12px 20px; background:#28a745; color:white; border:none; border-radius:5px;">
                🛒 Thêm vào giỏ
            </button>
        </a>

        <a href="products.php">
            <button style="padding:12px 20px; background:#ccc; border:none; border-radius:5px;">
                ← Quay lại
            </button>
        </a>
    </div>

</div>

<?php include 'footer.php'; ?>