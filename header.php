
<!DOCTYPE html>
<html>
<head>
    <title>Tay Nguyen Coffee</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f5f5f5;
        }

        /* HEADER */
        .header {
            background: #6f4e37;
            color: white;
            padding: 15px 0;
        }

        .container {
            width: 1100px;
            margin: auto;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu {
            text-align: center;
            flex: 1;
        }

        .menu a {
            margin: 0 15px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .right a {
            margin-left: 15px;
            color: white;
            text-decoration: none;
        }

        /* BANNER */
        .banner {
            height: 300px;
            background: url('banner.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .banner button {
            padding: 12px 25px;
            background: gold;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        /* PRODUCT */
        .grid {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .product {
            width: 23%;
            margin: 1%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .product-body {
            padding: 10px;
            text-align: center;
        }

        .price {
            color: red;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: green;
            color: white;
            text-decoration: none;
            margin-top: 10px;
        }

        /* FOOTER */
        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <div class="container nav">

        <div><strong>Tay Nguyen Coffee</strong></div>

        <div class="menu">
            <a href="index.php">Trang chu</a>
            <a href="products.php">San pham</a>
            <a href="about.php">Ve chung toi</a>
           
        </div>

        <div class="right">

            <a href="cart.php">🛒</a>

            <?php if(isset($_SESSION['user'])) { ?>

                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>

                    <!-- ADMIN -->
                    <a href="admin.php">⚙ <?= $_SESSION['user']; ?></a>

                <?php } else { ?>

                    <!-- USER -->
                    <a href="profile.php">👤 <?= $_SESSION['user']; ?></a>

                <?php } ?>

                <a href="logout.php">Đăng xuất</a>

            <?php } else { ?>

                <a href="login.php">Đăng nhập</a>

            <?php } ?>

        </div>

    </div>
</div>

<div class="container">