<?php
session_start();
include "config.php";
include "header.php";

$sql = "SELECT p.*,
       IFNULL(AVG(r.rating), 0) AS avg_rating,
       COUNT(r.id) AS total_reviews
FROM products p
LEFT JOIN reviews r ON p.id = r.product_id
GROUP BY p.id
LIMIT 8";
$result = $conn->query($sql);
?>

<h2 style="text-align:center;">Tất cả sản phẩm</h2>

<style>
.grid{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
}

.product{
    width:calc(25% - 20px);
    background:#fff;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
    transition:0.3s;
    cursor:pointer;
}

.product:hover{
    transform:translateY(-5px);
}

.product img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.product-body{
    padding:10px;
    text-align:center;
}

.rating{
    color:orange;
    font-size:14px;
}

.price{
    color:red;
    font-size:18px;
    font-weight:bold;
    margin:5px 0;
}

.btn-group{
    display:flex;
    gap:10px;
}

button{
    flex:1;
    padding:8px;
    border:none;
    cursor:pointer;
    border-radius:5px;
}

.add{
    background:green;
    color:white;
}

.buy{
    background:red;
    color:white;
}
</style>

<div class="grid">

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="product" onclick="goDetail(<?php echo $row['id']; ?>)">

        <img src="uploads/<?php echo $row['image']; ?>">

        <div class="product-body">
            <h3><?php echo $row['name']; ?></h3>

            <!-- rating -->
            <div class="rating">
            <?php
            $avg = round($row['avg_rating'],1);
            $total = $row['total_reviews'];
            $full = floor($avg);

            for($i=1;$i<=5;$i++){
                echo ($i <= $full) ? "⭐" : "☆";
            }
            ?>
            <span style="color:#666;">(<?= $total ?>)</span>
            </div>

            <!-- giá -->
            <p class="price">
                <?php echo number_format($row['price'], 0, ',', '.'); ?>đ
            </p>

            <!-- nút -->
            <div class="btn-group">

                <!-- THÊM GIỎ -->
                <button class="add"
                    onclick="event.stopPropagation(); window.location.href='add_to_cart.php?id=<?php echo $row['id']; ?>'">
                    Thêm giỏ
                </button>

                <!-- 🔥 MUA NGAY (ĐÃ FIX) -->
                <button class="buy"
                    onclick="event.stopPropagation(); window.location='order_now.php?id=<?php echo $row['id']; ?>'">
                    Mua ngay
                </button>

            </div>
        </div>
    </div>

<?php } ?>

</div>

<script>
function goDetail(id){
    window.location.href = "detail.php?id=" + id;
}
</script>

<?php include "footer.php"; ?>