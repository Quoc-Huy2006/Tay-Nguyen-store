<?php include 'header.php'; ?>
<?php include 'config.php'; ?>

<?php
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$row = $result->fetch_assoc();
?>
<style>
.review-box{
    max-width:600px;
    margin-top:20px;
    padding:20px;
    border-radius:10px;
    background:#fff;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.review-box h3{
    margin-bottom:15px;
}

/* sao */
.stars{
    display:flex;
    gap:5px;
    font-size:28px;
    cursor:pointer;
}

.stars span{
    color:#ccc;
    transition:0.2s;
}

.stars span.active{
    color:#ffc107;
}

/* textarea */
.review-box textarea{
    width:100%;
    height:100px;
    margin-top:15px;
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
    resize:none;
    font-size:14px;
}

/* button */
.review-box button{
    margin-top:15px;
    padding:10px 20px;
    border:none;
    background:#ff5722;
    color:white;
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
}

.review-box button:hover{
    background:#e64a19;
}
</style>


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
        <a href="buy.php?id=<?php echo $row['id']; ?>">
            <button style="padding:12px 20px; background:#cccc; color:white; border:none; border-radius:5px;">
               ⚡Mua Ngay
            </button>
        </a>
        <br>
        <a href="products.php">
            <button style="padding:12px 20px; background:#ccc; border:none; border-radius:5px;">
                ← Quay lại
            </button>
        </a>
<!--đánh giá sản phẩm-->
<div class="review-box">
    <h3>Đánh giá sản phẩm</h3>

    <form action="review_process.php" method="POST">
        <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
        <input type="hidden" name="rating" id="rating" required>

        <!-- ⭐ sao -->
        <div class="stars" id="starBox">
            <span data-value="1">★</span>
            <span data-value="2">★</span>
            <span data-value="3">★</span>
            <span data-value="4">★</span>
            <span data-value="5">★</span>
        </div>

        <!-- comment -->
        <textarea name="comment" placeholder="Hãy chia sẻ cảm nhận của bạn..." required></textarea>

        <button type="submit">Gửi đánh giá</button>
    </form>
</div>


<script>
const stars = document.querySelectorAll("#starBox span");
const ratingInput = document.getElementById("rating");

stars.forEach((star, index) => {
    star.addEventListener("click", () => {
        let value = star.getAttribute("data-value");
        ratingInput.value = value;

        stars.forEach(s => s.classList.remove("active"));

        for(let i=0;i<value;i++){
            stars[i].classList.add("active");
        }
    });
});
</script>
    </div>

</div>

<?php include 'footer.php'; ?>