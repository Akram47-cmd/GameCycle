<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Produits - GameCycle</title>
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
                    <a href="index.php?action=products" class="nav-link">FrontOffice</a>
                    <a href="index.php?action=admin-products" class="nav-link active">BackOffice</a>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="manage-header">
            <h1 class="manage-title">📦 Gestion des Produits</h1>
            <a href="index.php?action=create-product" class="btn btn-success">➕ Ajouter un produit</a>
        </div>

        <div class="table-container">
            <?php if (!empty($products)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Prix</th>
                            <th>Catégorie</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td>
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['title']) ?>" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    <?php else: ?>
                                        <div style="width: 50px; height: 50px; background: var(--dark-light); border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                            🎮
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product['title']) ?></td>
                                <td><strong><?= number_format($product['price'], 2, ',', ' ') ?>€</strong></td>
                                <td><?= htmlspecialchars($product['category_name']) ?></td>
                                <td><?= date('d/m/Y', strtotime($product['created_at'])) ?></td>
                                <td class="actions">
                                    <a href="index.php?action=show-product&id=<?= $product['id'] ?>" class="btn btn-small btn-primary" title="Voir">👁️</a>
                                    <a href="index.php?action=edit-product&id=<?= $product['id'] ?>" class="btn btn-small btn-warning" title="Modifier">✏️</a>
                                    <a href="index.php?action=delete-product&id=<?= $product['id'] ?>" class="btn btn-small btn-danger" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')" title="Supprimer">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-products">
                    <h3>Aucun produit trouvé</h3>
                    <p>Commencez par ajouter votre premier produit !</p>
                    <a href="index.php?action=create-product" class="btn btn-success" style="margin-top: 20px;">➕ Ajouter un produit</a>
                </div>
            <?php endif; ?>
            
            <div class="form-actions" style="margin-top: 2rem;">
                <a href="index.php" class="btn btn-outline">← Retour à l'accueil</a>
            </div>
        </div>
    </div>
</body>
</html>