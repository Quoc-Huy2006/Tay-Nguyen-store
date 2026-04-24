<?php
include "config.php";

$product_id = $_GET['id'];

// lấy thông tin sản phẩm
$product = $conn->query("SELECT * FROM products WHERE id=$product_id")->fetch_assoc();

// tính trung bình
$avgData = $conn->query("
    SELECT 
        ROUND(AVG(rating),1) AS avg_rating,
        COUNT(*) AS total
    FROM reviews
    WHERE product_id=$product_id
")->fetch_assoc();

// lấy danh sách đánh giá (cao -> thấp)
$reviews = $conn->query("
    SELECT r.*, u.username
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.product_id=$product_id
    ORDER BY r.rating DESC, r.id DESC
");
?>

<h2>Đánh giá sản phẩm: <?= $product['name'] ?></h2>

<a href="admin.php">← Quay lại</a>

<style>
.box{
    margin-top:20px;
    padding:20px;
    background:#fff;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}

.star{
    color:orange;
    font-size:20px;
}

.review{
    border-bottom:1px solid #ccc;
    padding:10px 0;
}
</style>

<div class="box">

    <h3>⭐ Trung bình: <?= $avgData['avg_rating'] ?> (<?= $avgData['total'] ?> đánh giá)</h3>

    <hr>

    <?php while($r = $reviews->fetch_assoc()){ ?>
        <div class="review">

            <b><?= $r['username'] ?></b>

            <div class="star">
                <?php
                for($i=1;$i<=5;$i++){
                    echo ($i <= $r['rating']) ? "⭐" : "☆";
                }
                ?>
            </div>

            <p><?= $r['comment'] ?></p>

            <small><?= $r['created_at'] ?></small>

        </div>
    <?php } ?>

</div>