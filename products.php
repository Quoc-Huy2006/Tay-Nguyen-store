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
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(250px,1fr));
    gap:20px;
    padding:20px;
}

.product{
    background:white;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
    overflow:hidden;
    cursor:pointer;
    transition:0.3s;
}

.product:hover{
    transform:translateY(-5px);
}

.product img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.product-body{
    padding:10px;
}

.product-body h3{
    font-size:18px;
    margin:5px 0;
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

            <!-- sao -->
            <?php
$avg = isset($row['avg_rating']) ? round($row['avg_rating'], 1) : 0;
$total = isset($row['total_reviews']) ? $row['total_reviews'] : 0;
?>

<div class="rating">
<?php
$avg = round($row['avg_rating'],1);
$total = $row['total_reviews'];

$full = floor($avg);

for($i=1;$i<=5;$i++){
    echo ($i <= $full) ? "⭐" : "☆";
}
?>
 <span style="color:#666;">
 (<?= $total ?>)
 </span>
</div>

            <!-- giá -->
            <p class="price">
                <?php echo number_format($row['price'], 0, ',', '.'); ?>đ
            </p>

            <!-- nút -->
            <div class="btn-group">
                <button class="add"
                    onclick="event.stopPropagation(); window.location='add_to_cart.php?id=<?php echo $row['id']; ?>'">
                    Thêm giỏ
                </button>

                <button class="buy"
                    onclick="event.stopPropagation(); window.location='buy.php?id=<?php echo $row['id']; ?>'">
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