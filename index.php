<?php
require_once __DIR__ . '/../Backend/data.php';

$restaurants = readData('restaurants.json');
$search = trim($_GET['search'] ?? '');

$restaurants = array_filter($restaurants, function ($r) use ($search) {
    if (($r['status'] ?? '') !== 'approved') {
        return false;
    }

    if ($search === '') {
        return true;
    }

    return stripos($r['name'] ?? '', $search) !== false
        || stripos($r['location'] ?? '', $search) !== false;
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FoodieHub | Discover Local Food</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <a class="brand" href="index.php">Foodie<span>Hub.</span></a>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="#restaurants">Restaurants</a>
        <a href="#spotlight">Local Spotlight</a>
        <a href="promote.php">Promote Restaurant</a>
        <a class="btn" href="../Backend/login.php">Admin</a>
    </div>
</nav>

<section class="hero">
    <div class="hero-content">
        <span class="eyebrow">YOUR CITY. YOUR FLAVOURS.</span>
        <h1>Discover local food worth talking about.</h1>
        <p>
            Explore hidden food gems, discover local restaurants
            and order your favourite dishes.
        </p>

        <form class="search-box" method="GET">
            <input type="text" name="search"
                   placeholder="Search restaurants or locations..."
                   value="<?= htmlspecialchars($search) ?>">
            <button class="btn" type="submit">Find Food</button>
        </form>
    </div>
</section>

<section class="section container" id="restaurants">
    <span class="eyebrow">HANDPICKED FOR YOU</span>
    <h2 class="section-title">Explore local favourites</h2>
    <p class="section-subtitle">
        Support local businesses and discover something delicious.
    </p>

    <div class="restaurant-grid">
    <?php foreach ($restaurants as $r): ?>
        <article class="restaurant-card">
            <img
                src="<?= htmlspecialchars($r['image'] ?? '') ?>"
                alt="<?= htmlspecialchars($r['name'] ?? 'Restaurant') ?>"
                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=800&q=80'">

            <div class="card-content">
                <span class="tag">LOCAL FOOD SPOT</span>
                <h3><?= htmlspecialchars($r['name']) ?></h3>
                <p class="muted">
                    <?= htmlspecialchars($r['location'] ?? '') ?>
                </p>
                <p class="muted">
                    <?= htmlspecialchars($r['description'] ?? '') ?>
                </p>

                <div class="card-bottom">
                    <span>Explore menu</span>
                    <a class="btn"
                       href="restaurant.php?id=<?= (int)$r['id'] ?>">
                        Order Now
                    </a>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
    </div>

    <?php if (count($restaurants) === 0): ?>
        <p>No restaurants found. Try another search.</p>
    <?php endif; ?>
</section>

<section class="section container" id="spotlight">
    <div class="promo-banner">
        <div>
            <span class="eyebrow">GROW YOUR FOOD BUSINESS</span>
            <h2 class="section-title">
                Your food deserves the spotlight.
            </h2>
            <p>Showcase your restaurant to more local customers.</p>
        </div>
        <a class="btn" href="promote.php">Promote My Restaurant</a>
    </div>
</section>

<footer class="footer">
    <h2 class="brand">Foodie<span>Hub.</span></h2>
    <p>Discover local flavours. Support local businesses.</p>
    <p>© <?= date('Y') ?> FoodieHub. All rights reserved.</p>
</footer>

</body>
</html>
