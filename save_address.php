<?php
session_start();
include "config.php";

/* =========================
   CHECK LOGIN
========================= */
if(!isset($_SESSION['user_id'])){
    echo "<script>
        alert('Bạn phải đăng nhập trước!');
        window.location.href='login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   NHẬN DỮ LIỆU FORM
========================= */
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$address = $_POST['address'];

/* =========================
   LẤY PRODUCT ID (QUAY LẠI CHECKOUT)
========================= */
$product_id = $_SESSION['product_id'] ?? 0;

/* =========================
   CHECK ĐÃ CÓ ĐỊA CHỈ CHƯA
========================= */
$sql = "SELECT * FROM user_address WHERE user_id=$user_id";
$result = $conn->query($sql);

if($result && $result->num_rows > 0){

    // ✔ UPDATE
    $sql = "UPDATE user_address 
            SET fullname='$fullname',
                phone='$phone',
                address='$address'
            WHERE user_id=$user_id";

}else{

    // ✔ INSERT
    $sql = "INSERT INTO user_address(user_id, fullname, phone, address)
            VALUES('$user_id', '$fullname', '$phone', '$address')";
}

$conn->query($sql);

/* =========================
   CHUYỂN VỀ CHECKOUT
========================= */
echo "<script>
    alert('Lưu thông tin thành công!');
    window.location.href='checkout.php?id=$product_id';
</script>";
?>