

<?php
$home = "a_index.php";
$about = "about.php";
$service = "service.php";

// Product data
$products = [
    "trimay" => [
        "name" => "Trimay - Mellow U Cleansing Balm",
        "price" => "$10.50",
        "image_main" => "img/trimay.jpg",
        "detail" => "Sun cream",
        "description" => "This is a daily mask that extracts young green tea leaves through cold decoction slowly over a long period of time to minimize the loss of active ingredients and contains the original ingredients to  <br>
                provide a deeper soothing effect.<br>
                Containing raspberry, strawberry, blueberry, cranberry, and acai berry, it gently and comfortably soothes skin that has become sensitive due to irritation, leaving the skin bright and revitalized.<br>
                The thin, lightweight, highly absorbent vegan sheet filled with essence adheres transparently and firmly to the skin, providing abundant moisture.<br><br>
                Skin irritation test completed.<br>
                Vegan certification completed.<br><br>

                [Ingredients]<br>

                Purified water, glycerin, propanediol, dipropylene glycol, 1,2-hexanediol, hydroxyacetophenone, xanthan gum, allantoin, carbomer, arginine, hydroxyethylcellulose, butylene glycol, disodium EDTA, <br>
                dipotassium glycyrrhizate, ethylhexylglycerin, polyglyceryl-10 laurate, polyglyceryl-10 myristate, green tea extract (100ppm), fragrance, sodium hyaluronate, raw sweet blueberry extract (25ppm), <br>
                cranberry extract (12.50ppm), acai palm fruit extract (2.60ppm), decyl glucoside, beach strawberry extract (1.43ppm), centella asiatica extract, tea tree leaf extract, Halong extract, centella asiatica leaf <br>
                extract, Okamura's falcon. Extract, white willow bark extract, raspberry extract (104ppb), coffee bean extract, pentylene glycol, bergamot leaf extract, pine leaf extract, mugwort extract.<br><br>

                [How to use]<br><br>
                1. After cleansing, prepare skin texture with toner.<br>
                2. Open the cap and take out one sheet using the built-in tongs.<br>
                3. Unfold the sheet and attach the sheet according to the shape of the face, centering on the eyes and mouth.<br>
                4. After 10~20 minutes, remove the mask and let the remaining contents absorb lightly.<br><br>
                - Condition : NEW<br><br>
                - Volume : 310ml (30pcs)<br><br>",
        "images" => [
            "imgtrimay/trimay1.jpg",
            "imgtrimay/trimay2.jpg",
            "imgtrimay/trimay3.jpg",
            "imgtrimay/trimay4.jpg"
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
    ["name" => "ma:nyo - Pure cleansing oil", "price" => "$18.00", "image" => "imgberry/manyo_cleansing.jpg"],
    ["name" => "ma:nyo - Bifida Cica Herb Toner", "price" => "$24.00", "image" => "imgberry/manyoToner.jpg"],
    ["name" => "ma:nyo Panthe-Calming Sun Cream", "price" => "$15.00", "image" => "imgberry/manyoSunscrean.jpg"],
    ["name" => "ma:nyo - Bifida Biome Complex Amploule", "price" => "$18.00", "image" => "imgberry/manyoAmpoule.jpg"],
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