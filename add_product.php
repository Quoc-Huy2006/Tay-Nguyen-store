<?php
session_start();
include "config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    die("Không có quyền");
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/".$image);

    $sql = "INSERT INTO products(name,price,description,category_id,quantity,status,image)
            VALUES('$name','$price','$description','$category_id','$quantity','$status','$image')";

    $conn->query($sql);

    header("Location: products_admin.php");
}
?>

<style>
body{font-family:Arial;background:#f4f4f4}
.box{width:500px;margin:50px auto;background:white;padding:20px;border-radius:10px}
input,select{width:100%;padding:8px;margin:5px 0}
button{background:green;color:white;padding:10px;width:100%;border:none}
</style>

<div class="box">
<h2>Thêm sản phẩm</h2>
<style>
.back-btn{
    display:inline-block;
    padding:8px 12px;
    background:#444;
    color:white;
    text-decoration:none;
    border-radius:5px;
    margin-bottom:10px;
}
.back-btn:hover{
    background:#000;
}
</style>

<a href="javascript:history.back()" class="back-btn">
⬅ Quay lại
</a>
<form method="POST" enctype="multipart/form-data">

<input name="name" placeholder="Tên sản phẩm">
<input name="price" placeholder="Giá">
<input name="description" placeholder="Mô tả">
<input name="category_id" placeholder="ID danh mục">
<input name="quantity" placeholder="Tồn kho">

<select name="status">
    <option value="1">Hiển thị</option>
    <option value="0">Ẩn</option>
</select>

<input type="file" name="image">

<button name="submit">Thêm</button>

</form>
</div>