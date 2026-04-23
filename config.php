<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "TayNguyen_store";

// Tao ket noi
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiem tra ket noi
if ($conn->connect_error) {
    die("Ket noi that bai: " . $conn->connect_error);
}

// echo "Ket noi thanh cong"; // 
?>