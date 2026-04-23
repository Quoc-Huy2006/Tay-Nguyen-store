<?php
session_start();

// xóa toàn bộ session
session_unset();
session_destroy();

// chuyển về trang login
header("Location: login.php");
exit();
?>