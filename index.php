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

<style>
body{
    margin:0;
}

/* ===== BANNER ===== */
.banner{
    position:relative;
    width:100vw;
    height:450px;
    background:url('uploads/banner.jpg') no-repeat center;
    background-size:cover;

    left:50%;
    transform:translateX(-50%);

    display:flex;
    align-items:center;
    justify-content:center;
}

.banner::after{
    content:"";
    position:absolute;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.4);
    z-index:1;
}

.banner-content{
    position:relative;
    z-index:2;
    text-align:center;
    color:white;
}

.banner h1{font-size:42px;}
.banner p{font-size:18px;}

.banner button{
    padding:12px 30px;
    background:#28a745;
    border:none;
    color:white;
    border-radius:8px;
    cursor:pointer;
}

/* ===== SẢN PHẨM (GIỐNG PRODUCTS) ===== */
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

<!-- ===== BANNER ===== -->
<div class="banner">
    <div class="banner-content">
        <h1>Chào mừng đến Shop</h1>
        <p>Mua sắm cực chất - Giá cực tốt</p>

        <button onclick="window.location.href='products.php'">
            Khám phá ngay
        </button>
    </div>
</div>

<!-- ===== SẢN PHẨM ===== -->
<h2 style="text-align:center;margin-top:20px;">Sản phẩm nổi bật</h2>

<div class="grid">

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="product" onclick="goDetail(<?= $row['id'] ?>)">

        <img src="uploads/<?= $row['image'] ?>">

        <div class="product-body">
            <h3><?= $row['name'] ?></h3>

            <?php
            $avg = round($row['avg_rating'],1);
            $total = $row['total_reviews'];
            $full = floor($avg);
            ?>

            <div class="rating">
                <?php
                for($i=1;$i<=5;$i++){
                    echo ($i <= $full) ? "⭐" : "☆";
                }
                ?>
                <span style="color:#666;">(<?= $total ?>)</span>
            </div>

            <p class="price">
                <?= number_format($row['price'], 0, ',', '.') ?>đ
            </p>

            <div class="btn-group">

                <button class="add"
                    onclick="event.stopPropagation(); location.href='add_to_cart.php?id=<?= $row['id'] ?>'">
                    Thêm giỏ
                </button>

                <button class="buy"
                    onclick="event.stopPropagation(); location.href='buy.php?id=<?= $row['id'] ?>'">
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