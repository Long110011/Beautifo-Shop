

<?php
$home = "a_index.php";
$about = "about.php";
$service = "service.php";

// Product data
$products = [
    "milk" => [
        "name" => "Milk Shake - Cold Brunette Toning Spray",
        "price" => "$17.00",
        "image_main" => "img/milksh.jpg",
        "detail" => "Sun cream",
        "description" => "Medicube Collagen Jelly Cream is an advanced skincare solution engineered to provide optimal hydration and enhance collagen synthesis, contributing to a more rejuvenated appearance.
                Its distinctive jelly-like formulation ensures rapid absorption without leaving any oily residue. This versatile product is compatible with various skin types and can be integrated into both
                morning and evening skincare regimens for maximum efficacy.<br><br>

                [Ingredients]<br><br>

                Water, Propanediol, Dipropylene Glycol, Butylene Glycol, Methylpropanediol, Diethoxyethyl Succinate, Ethoxydiglycol, Ammonium Acryloyldimethyltaurate/Beheneth-25 Methacrylate Crosspolymer, Niacinamide,
                Trehalose, 1,2-Hexanediol, Chlorella Vulgaris Extract, Collagen, Hydrolyzed Collagen, Cynanchum Atratum Extract, Althaea Rosea Flower Extract, Soluble Collagen, Allium Sativum (Garlic) Bulb Extract, 
                Avena Sativa (Oat) Kernel Extract, Bertholletia Excelsa Seed Extract, Brassica Oleracea Italica (Broccoli) Extract, Camellia Sinensis Seed Extract, Salmon Egg Extract, Solanum Lycopersicum (Tomato) Fruit Extract, 
                Spinacia Oleracea (Spinach) Leaf Extract, Vaccinium Angustifolium (Blueberry) Fruit Extract, Wine Extract, Polyglyceryl-10 Isostearate, Tromethamine, Glucose, Polyglyceryl-10 Oleate, Ethylhexylglycerin, 
                Fructooligosaccharides, Fructose, Adenosine, Sodium Phytate, Cyanocobalamin, Tocopherol, Pullulan, Glycerin, Hydroxypropyltrimonium Hyaluronate, Squalane, Soluble Proteoglycan, Hydrolyzed Elastin, Sodium DNA, Carbomer, 
                Xanthan Gum, Fragrance.<br><br>

                [How to use]<br><br>
                At the last step of skincare routine, apply a moderate amount on your entire face and gently dab to absorb.<br><br>
                - Condition : NEW<br><br>
                - Volume : 110ml | All skin types <br><br>",
        "images" => [
            "imgMilk/milk1.jpg",
            "imgMilk/milk2.jpg",
            "imgMilk/milk3.jpg",
            "imgMilk/milk4.jpg"
        ]
    ]
];

// Get product slug from query
$slug = $_GET['slug'] ?? '';
$product = $products[$slug] ?? null;

if (!$product) {
    echo "<h2>Product not found.</h2><p><a href='a_index.php'>Back to home</a></p>";
    exit;
}

// Related products (static for now)
$related_products = [
    ["name" => "milk_shake cold brunette shampoo", "price" => "$18.00", "image" => "imgMilk/milkshakeconditioner.jpg"],
    ["name" => "milk_shake cold brunette flower", "price" => "$24.00", "image" => "imgMilk/milkshakeflower.jpg"],
    ["name" => "Milk Shake - Cold Brunette Toning Spray", "price" => "$15.00", "image" => "imgMilk/milkshakespray.jpg"],
    ["name" => "milk_shake cold brunette shampoo mini", "price" => "$18.00", "image" => "imgMilk/milkshakeconditioner.jpg"],
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $qty = $_POST['qty'] ?? 1;

    $pdo = new PDO('mysql:host=localhost;dbname=phpshop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($action === 'add_to_cart' || $action === 'buy_now') {
        $stmt = $pdo->prepare("INSERT INTO tbproduct (pro, price, qty, detail, photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $product['name'],
            str_replace('$', '', $product['price']),
            $qty,
            strip_tags($product['detail']),
            $product['image_main']
        ]);

        header("Location: addcart.php");
        exit;
    } elseif ($action === 'wishlist') {
        $stmt = $pdo->prepare("INSERT INTO tbwishlist (pro, price, qty, detail, photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $product['name'],
            str_replace('$', '', $product['price']),
            $qty,
            strip_tags($product['detail']),
            $product['image_main']
        ]);

        header("Location: wishlist.php");
        exit;
    }  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="css/category.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header id="main-header">
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
    <section class="product-detail">
        <div class="product-images">
            <img class="main-img" src="<?= $product['image_main'] ?>" alt="<?= $product['name'] ?>">
            <div class="thumbs">
                <?php foreach ($product['images'] as $img): ?>
                    <img src="<?= $img ?>" alt="Thumbnail">
                <?php endforeach; ?>
            </div>
        </div>

        <div class="product-info">
            <h1><?= $product['name'] ?></h1>
            <p class="price"><?= $product['price'] ?></p>

           <form method="post" action="">
                <div class="quantity">
                    <button type="button" class="qty-btn minus">-</button>
                    <input type="number" id="qty" name="qty" value="1" min="1">
                    <button type="button" class="qty-btn plus">+</button>
                </div><br>
                <!-- Hidden fields for database -->
                 <!-- for add to cart -->
                <input type="hidden" name="add_to_cart" value="1">
                <button type="submit" name="action" value="add_to_cart" class="btn add-cart">Add to Cart</button>
                <!-- for buy now -->
                <input type="hidden" name="buy_now" value="1">
                <button type="submit" name="action" value="buy_now" class="btn add-cart">Buy Now</button>

                <input type="hidden" name="wishlist" value="1">
                <button type="submit" name="action" value="wishlist" class="btn wishlist"><i class="far fa-heart">Wishlist</i></button>
            </form>

        </div>
    </section>

    <div class="tabs">
        <h3><?= $product['name'] ?></h3>
        <h4>Description</h4>
        <p><?= $product['description'] ?></p>
    </div>

    <h2 class="related-heading">Related Products</h2>
    <div class="related-products">
        <?php foreach ($related_products as $related): ?>
            <div class="product-card">
                <img src="<?= $related['image'] ?>" alt="<?= $related['name'] ?>">
                <p><?= $related['price'] ?></p>
                <h4><?= $related['name'] ?></h4>
                <button>Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <p>&copy; <?= date("Y") ?> Beautifo. All rights reserved.</p>
</footer>


<script src="css/index.js"></script>

</body>
</html>