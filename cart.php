<?php session_start();?>
<?php include 'header.php'; ?>


<h2>🛒 Giỏ hàng của bạn</h2>

<!-- FORM CẬP NHẬT -->
<form action="update_cart.php" method="post">

<table style="width:100%; background:white; border-collapse: collapse; text-align:center;">
    <tr style="background:#28a745; color:white;">
        <th>Chọn</th>
        <th>Ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Tổng</th>
        <th>Hành động</th>
    </tr>

<?php
$total = 0;

if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
    foreach($_SESSION['cart'] as $id => $item){

        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
?>

<tr>
    <!-- CHECKBOX -->
    <td>
        <input type="checkbox" name="selected[]" value="<?php echo $id; ?>">
    </td>

    <!-- ẢNH -->
    <td>
        <img src="uploads/<?php echo $item['image']; ?>" width="80">
    </td>

    <!-- TÊN -->
    <td style="vertical-align: middle;">
        <?php echo $item['name']; ?>
    </td>

    <!-- GIÁ -->
    <td><?php echo $item['price']; ?> VND</td>

    <!-- SỐ LƯỢNG -->
    <td>
        <button type="button" onclick="giam(<?php echo $id; ?>)">-</button>

        <input type="number" 
               name="qty[<?php echo $id; ?>]" 
               id="qty_<?php echo $id; ?>" 
               value="<?php echo $item['quantity']; ?>" 
               min="1" 
               style="width:50px; text-align:center;">

        <button type="button" onclick="tang(<?php echo $id; ?>)">+</button>
    </td>

    <!-- TỔNG -->
    <td><?php echo $subtotal; ?> VND</td>

    <!-- HÀNH ĐỘNG -->
    <td>
        <a href="detail.php?id=<?php echo $id; ?>">
            <button type="button">Xem</button>
        </a>

        <a href="remove_cart.php?id=<?php echo $id; ?>">
            <button type="button" style="background:red; color:white;">Xóa</button>
        </a>
    </td>
</tr>

<?php
    }
}else{
    echo "<tr><td colspan='7'>Giỏ hàng trống</td></tr>";
}
?>

</table>

<br>

<!-- TỔNG TIỀN -->
<h3>Tổng tiền: <?php echo $total; ?> VND</h3>

<!-- NÚT CẬP NHẬT -->
<button type="submit" style="padding:10px; background:orange; color:white;">
    Cập nhật giỏ hàng
</button>

</form>

<br>

<!-- FORM THANH TOÁN RIÊNG -->
<form action="checkout.php" method="post">

<?php
// giữ lại checkbox đã chọn
if(isset($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $id => $item){
        echo '<input type="hidden" name="selected[]" value="'.$id.'">';
    }
}
?>

<button type="submit" style="padding:10px; background:green; color:white;">
    Thanh toán sản phẩm đã chọn
</button>

</form>
<a href="/taynguyen_store/products.php">
    <button style="padding:12px 20px; background:#ccc; border:none; border-radius:5px;">
        ← Quay lại
    </button>
</a>
<!-- JS -->
<script>
function tang(id){
    let qty = document.getElementById('qty_' + id);
    qty.value = parseInt(qty.value) + 1;
}

function giam(id){
    let qty = document.getElementById('qty_' + id);
    if(qty.value > 1){
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>

<?php include 'footer.php'; ?>