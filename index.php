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

/* ===== BANNER FULL (ĐÃ FIX) ===== */
.banner{
    position:relative;
    width:100vw; /* 🔥 full màn hình */
    height:450px;
    background:url('uploads/banner.jpg') no-repeat center;
    background-size:cover;

    left:50%;
    transform:translateX(-50%); /* 🔥 kéo ra khỏi container */

    display:flex;
    align-items:center;
    justify-content:center;
}

/* lớp phủ tối */
.banner::after{
    content:"";
    position:absolute;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.4);
    z-index:1;
}

/* nội dung */
.banner-content{
    position:relative;
    z-index:2;
    text-align:center;
    color:white;
}

.banner h1{
    font-size:42px;
    margin-bottom:10px;
}

.banner p{
    margin-bottom:20px;
    font-size:18px;
}

/* nút */
.banner button{
    padding:12px 30px;
    font-size:16px;
    background:#28a745;
    border:none;
    color:white;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

.banner button:hover{
    background:#218838;
}

/* ===== SẢN PHẨM ===== */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(250px,1fr));
    gap:20px;
    padding:20px;
}

.product{
    background:white;
    border-radius:12px;
    box-shadow:0 0 10px #ccc;
    overflow:hidden;
    transition:0.3s;
}

.product:hover{
    transform:translateY(-5px);
}

.product img{
    width:100%;
    height:200px;
    object-fit:cover;
}

.product-body{
    padding:10px;
}

.price{
    color:red;
    font-weight:bold;
}

.btn-group{
    display:flex;
    gap:10px;
    margin-top:10px;
}

button{
    flex:1;
    padding:8px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.add{background:green;color:white;}
.buy{background:#006400;color:white;}
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

<?php include "footer.php"; ?>