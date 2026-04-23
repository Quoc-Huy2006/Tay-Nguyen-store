<?php
session_start();
include "config.php";

// check admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Không có quyền truy cập");
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<h2>Quản lý sản phẩm</h2>

<a href="add_product.php">➕ Thêm sản phẩm</a>

<hr>
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
<table border="1" width="100%" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Tên</th>
        <th>Giá</th>
        <th>Tồn kho</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>

<?php while($row = $result->fetch_assoc()) { ?>

    <tr>
        <td><?= $row['id']; ?></td>

        <td>
            <?php if(!empty($row['image'])) { ?>
                <img src="uploads/<?= $row['image']; ?>" width="60">
            <?php } ?>
        </td>

        <td><?= $row['name']; ?></td>
        <td><?= number_format($row['price']); ?> VND</td>

        <td><?= $row['stock']; ?></td>

        <td>
            <?php if($row['status'] == 1) { ?>
                <span style="color:green;">Hiển thị</span>
            <?php } else { ?>
                <span style="color:red;">Ẩn</span>
            <?php } ?>
        </td>

        <td>
            <a href="edit_product.php?id=<?= $row['id']; ?>">Sửa</a> |
            
            <a href="delete_product.php?id=<?= $row['id']; ?>"
               onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
               Xóa
            </a>
        </td>
    </tr>

<?php } ?>

</table>