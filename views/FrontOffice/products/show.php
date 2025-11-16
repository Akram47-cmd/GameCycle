<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['title']) ?> - GameCycle</title>
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
                    <a href="index.php?action=products" class="nav-link">Produits</a>
                    <a href="index.php?action=admin-products" class="nav-link">Administration</a>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="product-detail">
            <div class="product-detail-grid">
                <div>
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="product-detail-image">
                    <?php else: ?>
                        <div class="product-image" style="height: 300px; font-size: 4rem;">🎮</div>
                    <?php endif; ?>
                </div>

                <div class="product-detail-content">
                    <h1><?= htmlspecialchars($product['title']) ?></h1>
                    
                    <div class="product-detail-price">
                        <?= number_format($product['price'], 2, ',', ' ') ?>€
                    </div>

                    <div class="product-detail-category">
                        📁 Catégorie : <?= htmlspecialchars($product['category_name']) ?>
                    </div>

                    <div class="product-detail-description">
                        <h3>Description :</h3>
                        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    </div>

                    <div class="form-actions">
                        <a href="index.php?action=products" class="btn btn-outline">← Retour aux produits</a>
                        <a href="index.php?action=admin-products" class="btn btn-primary">Gérer les produits</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>