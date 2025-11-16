<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - GameCycle</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="index.php" class="logo">
                    <span>🎮 GameCycle</span>
                </a>
                <div class="nav-links">
                    <a href="index.php" class="nav-link">Accueil</a>
                    <a href="index.php?action=products" class="nav-link active">Produits</a>
                    <a href="index.php?action=admin-products" class="nav-link">Administration</a>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1 class="section-title">🎮 Nos Produits Gaming</h1>
        
        <div class="products-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="product-image">
                        <?php else: ?>
                            <div class="product-image">🎮</div>
                        <?php endif; ?>
                        
                        <div class="product-content">
                            <h3 class="product-title"><?= htmlspecialchars($product['title']) ?></h3>
                            <div class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?>€</div>
                            <div class="product-category"><?= htmlspecialchars($product['category_name']) ?></div>
                            <p class="product-description"><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...</p>
                            <div class="form-actions">
                                <a href="index.php?action=show-product&id=<?= $product['id'] ?>" class="btn btn-primary">Voir détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <h3>Aucun produit disponible</h3>
                    <p>Revenez plus tard pour découvrir nos produits gaming !</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>