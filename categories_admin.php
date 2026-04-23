<?php
session_start();
include "config.php";

if($_SESSION['role'] != 'admin'){
    die("Không có quyền");
}

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $conn->query("INSERT INTO categories(name) VALUES('$name')");
}

$result = $conn->query("SELECT * FROM categories");
?>

<style>
body{font-family:Arial;background:#f4f4f4}
.box{width:500px;margin:50px auto;background:white;padding:20px;border-radius:10px}
input{width:100%;padding:8px;margin:5px 0}
button{background:purple;color:white;padding:10px;width:100%;border:none}
table{width:100%;margin-top:10px}
</style>

<div class="box">
<h2>Quản lý danh mục</h2>

<form method="POST">
<input name="name" placeholder="Tên danh mục">
<button name="add">Thêm</button>
</form>
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
<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Tên</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['name'] ?></td>
</tr>
<?php } ?>

</table>
</div>