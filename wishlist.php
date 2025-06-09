<?php
// Navigation links
$home = "a_index.php";    
$about = "about.php";
$service = "service.php";

// DB connection
$con = new PDO('mysql:host=localhost;dbname=phpshop', 'root', '');
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Insert product (optional form logic)
$stmt = $con->query("SELECT * FROM tbwishlist"); // or fetch all if needed
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

//for delete
    // Handle delete/update actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $id = $_POST['ID'] ?? '';

        if ($_POST['action'] === 'delete') {
            $stmt = $con->prepare("DELETE FROM tbwishlist WHERE ID = ?");
            $stmt->execute([$id]);
            header("Location: wishlist.php");
            exit;
        }

        // if ($_POST['action'] === 'update') {
        //     $proname = $_POST['proname'] ?? '';
        //     $price = $_POST['price'] ?? '';
        //     $qty = $_POST['qty'] ?? '';
        //     $detail = $_POST['detail'] ?? '';
        //     $photoName = ''; 
        //     // To be replaced if file uploads are handled
        //     $sql = "UPDATE tbwishlist SET pro = ?, price = ?, qty = ?, detail = ?, photo = ? WHERE id = ?";
        //     $stmt = $con->prepare($sql);
        //     $stmt->execute([$proname, $price, $qty, $detail, $photoName, $ID]);
        //     header("Location: wishlist.php");
        //     exit;
        // }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="css/addcart.css">
</head>
<body>

    <header>
    <div class="logo"><a href="#">Beautifo</a></div>
    <nav>
        <ul class="navbar">
        <li><a href="<?= $home ?>">Home</a></li>
        <li><a href="<?= $about ?>">About</a></li>
        <li><a href="<?= $service ?>">Service</a></li>
        </ul>
    </nav>
    <div class="icons">
        <a href="search.php"><i class="fas fa-search"></i></a>
        <a href="wishlist.php"><i class="far fa-heart"></i></a>
        <a href="addcart.php"><i class="fas fa-shopping-cart"></i></a>
        <a href="user.php"><i class="far fa-user"></i></a>
    </div>
    </header>

    <main>
      <table class="wishlist-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Date Added</th>
            <th>Stock Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            <?php if ($cartItems): ?>
                <?php foreach ($cartItems as $cartItem): ?>
                    <tr>
                        <td>
                            <div class="cart-item">
                                <img src="<?= htmlspecialchars($cartItem['photo']) ?>" alt="<?= htmlspecialchars($cartItem['pro']) ?>" width="100">
                                <div>
                                    <strong><?= htmlspecialchars($cartItem['pro']) ?></strong><br>
                                    <?= substr(htmlspecialchars($cartItem['detail']), 0, 100) ?>
                                </div>
                            </div>
                        </td>
                        <td>$<?= htmlspecialchars($cartItem['price']) ?></td>
                        <td><?= date('Y-m-d') ?></td> <!-- Replace with actual date if available -->
                        <td><?= ($cartItem['qty'] > 0) ? 'In Stock' : 'Out of Stock' ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <input type="hidden" name="ID" value="<?= htmlspecialchars($cartItem['ID']) ?>">
                                <button type="submit" name="action" value="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No items in cart.</td></tr>
            <?php endif; ?>
      </tbody>
  </main>
    
</body>
</html>