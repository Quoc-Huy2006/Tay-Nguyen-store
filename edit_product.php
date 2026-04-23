<?php
session_start();
include "config.php";

if($_SESSION['role'] != 'admin'){
    die("Không có quyền");
}

$id = intval($_GET['id']);

$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $price = intval($_POST['price']);
    $description = $_POST['description'];
    $category_id = intval($_POST['category_id']);
    $stock = intval($_POST['stock']);
    $status = intval($_POST['status']);

    /* =========================
       UPLOAD IMAGE
    ========================= */
    if(!empty($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);

        $conn->query("UPDATE products SET image='$image' WHERE id=$id");
    }

    /* =========================
       UPDATE PRODUCT
    ========================= */
    $conn->query("
        UPDATE products SET
            name='$name',
            price=$price,
            description='$description',
            category_id=$category_id,
            stock=$stock,
            status=$status
        WHERE id=$id
    ");

    echo "<script>
        alert('Cập nhật thành công!');
        window.location.href='products_admin.php';
    </script>";
    exit();
}
?>

<style>
body{font-family:Arial;background:#f4f4f4}
.box{width:500px;margin:50px auto;background:white;padding:20px;border-radius:10px}
input,select{width:100%;padding:8px;margin:5px 0}
button{background:blue;color:white;padding:10px;width:100%;border:none}
.back-btn{
    display:inline-block;
    padding:8px 12px;
    background:#444;
    color:white;
    text-decoration:none;
    border-radius:5px;
    margin-bottom:10px;
}
</style>

<div class="box">
<h2>Sửa sản phẩm</h2>

<a href="javascript:history.back()" class="back-btn">⬅ Quay lại</a>

<form method="POST" enctype="multipart/form-data">

<input name="name" value="<?= $product['name'] ?>">
<input name="price" value="<?= $product['price'] ?>">
<input name="description" value="<?= $product['description'] ?>">
<input name="category_id" value="<?= $product['category_id'] ?>">

<!-- ✅ FIX STOCK -->
<input name="stock" value="<?= $product['stock'] ?>">

<select name="status">
    <option value="1" <?= $product['status']==1?'selected':'' ?>>Hiển thị</option>
    <option value="0" <?= $product['status']==0?'selected':'' ?>>Ẩn</option>
</select>

<p>Ảnh hiện tại:</p>
<img src="uploads/<?= $product['image'] ?>" width="100">

<input type="file" name="image">

<button name="update">Cập nhật</button>

</form>
</div>