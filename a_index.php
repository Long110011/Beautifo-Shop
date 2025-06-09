<?php
// Navigation links
$home = "a_index.php";    
$about = "about.php";
$service = "service.php";



// Category definitions
$categories = [
    'face' => 'For Face',
    'body' => 'For Body',
    'hair' => 'Hair',
    'accessories' => 'Accessories'
];

// Product data (could be fetched from a database in a real application)
$products = [
    ["slug" => "manyo","name" => "Manyo - Thanks Berry Green Tea Mask Sheet", "price" => "$27.00", "image" => "img/manyo.jpg", "category" => "face"],
    ["slug" => "medicube", "name" => "Medicube - Collagen Jelly Cream", "price" => "$12.99", "image" => "img/medicube_collagenn.jpg" , "category" => "face"],
    ["slug" => "milk", "name" => "Milk Shake - Cold Brunette Toning Spray", "price" => "$17.00", "image" => "img/milksh.jpg", "category" => "hair"],
    ["slug" => "centone", "name" => "SKIN1004 - Centella Tone Brightening Ampoule", "price" => "$10.50", "image" => "img/centella.jpg", "category" => "face"],
    ["slug" => "cenpor", "name" => "SKIN1004 - Centella Poremizing Deep Cleansing Foam", "price" => "$10.00", "image" => "img/centella_oremizing.jpg", "category" => "face"],
    ["slug" => "beauty", "name" => "Beauty Of Joseon - Relief Sun Aqua", "price" => "$12.00", "image" => "img/beauty_of_oseon.jpg", "category" => "face"],
    ["slug" => "trimay", "name" => "Trimay - Mellow U Cleansing Balm", "price" => "$20.00", "image" => "img/trimay.jpg", "category" => "face"],
    ["slug" => "dovescrub", "name" => "Dove - Scrub Brown Sugar & Coconut Butter Exfoliates Body Scrub", "price" => "$10.50", "image" => "img/dove.jpg", "category" => "body"],
];

$pageMap = [
    'manyo' => 'manyo.php',
    'medicube' => 'medicube.php',
    'milk' => 'milk.php',
    'centone' => 'centone.php',
    'cenpor' => 'cenpor.php',
    'beauty' => 'beauty.php',
    'trimay' => 'trimay.php',
    'dovescrub' => 'dovescrub.php'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Beautifo Shop</title>
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
    <!-- Header with Navigation -->
    <header id="main-header">
        <div class="logo">
            <a href="#">Beautifo</a>
        </div>
        <nav>
            <ul class="navbar">
                <li><a href="<?= $home ?>">Home</a></li>
                <li><a href="<?= $about ?>">About</a></li>
                <li><a href="<?= $service ?>">Service</a></li>
            </ul>
        </nav>
        <!-- ICON -->
        <div class="icons">
            <a href="iconbar/search.php"><i class="fas fa-search"></i></a>
            <a href="iconbar/wishlist.php"><i class="far fa-heart"></i></a>
            <a href="iconbar/addcart.php"><i class="fas fa-shopping-cart"></i></a>
            <a href="iconbar/user.php"><i class="far fa-user"></i></a>
        </div>
    </header>

    <!-- Cover Section -->
    <main>
        <section class="cover-section">
            <div class="cover">
                <img src="img/cover.jpg" alt="Beauty Shop Cover" />
                <h1>Welcome to My Beauty Shop</h1>
            </div>
        </section>

        <!-- Product Showcase -->
        <section class="product-section">
            <div class="section-header">
                <h2>Products</h2>
            </div>

            <div class="cate">
                <!-- Left large product -->
                <div class="cate-item large-left">
                    <div class="items">
                        <img src="img/glow_cream.jpg" alt="Glow Cream" />
                        <span class="label">Glow Cream</span>
                    </div>
                </div>

                <!-- Right side products -->
                <div class="cate-item right">
                    <!-- Top row -->
                    <div class="item top-row">
                        <div class="items small">
                            <img src="img/gloosier.jpg" alt="Skincare Product" />
                            <span class="label">Skincare</span>
                        </div>
                        <div class="items small">
                            <img src="img/olay.jpg" alt="Makeup Product" />
                            <span class="label">Makeup</span>
                        </div>
                    </div>

                    <!-- Bottom row -->
                    <div class="item bottom-row">
                        <div class="items wide">
                            <img src="img/soonjung.jpg" alt="Haircare Product" />
                            <span class="label">Haircare</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Grid -->
        <section class="featured-products">
            <h2>Featured Products</h2>
            <div class="filter-buttons">
            <button class="active" data-filter="all">All</button>
                <?php foreach ($categories as $key => $label): ?>
                    <button data-filter="<?= $key ?>"><?= $label ?></button>
                <?php endforeach; ?>
            </div>


            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <?php
                        $slug = $product['slug'];
                        $page = isset($pageMap[$slug]) ? $pageMap[$slug] : '#';
                        $category = $product['category'] ?? 'uncategorized';
                    ?>
                    <div class="product-card <?= htmlspecialchars($category) ?>">
                        <a href="<?= $page ?>?slug=<?= urlencode($slug) ?>">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="price"><?= htmlspecialchars($product['price']) ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- Optional footer -->
    <footer>
        <p>&copy; <?= date("Y") ?> Beauty Shop. All rights reserved.</p>
    </footer>

    <script src="css/index.js"></script>
</body>
</html>
