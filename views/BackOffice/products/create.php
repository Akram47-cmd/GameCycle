<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Produit - GameCycle</title>
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
        <div class="form-container form-mode-create">
            <h1 class="section-title">➕ Ajouter un produit</h1>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <strong>❌ Erreurs :</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Titre *</label>
                    <input type="text" id="title" name="title" class="form-control" 
                           value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" 
                           required 
                           minlength="3" 
                           maxlength="100"
                           placeholder="Ex: PlayStation 5 - Édition Standard">
                </div>

                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" class="form-control" 
                              required 
                              minlength="10" 
                              maxlength="2000"
                              placeholder="Décrivez le produit en détail..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Prix (€) *</label>
                    <input type="number" id="price" name="price" class="form-control" 
                           step="0.01" min="0" max="10000"
                           value="<?= $_POST['price'] ?? '' ?>" 
                           required
                           placeholder="Ex: 499.99">
                </div>

                <div class="form-group">
                    <label for="category_id">Catégorie *</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">Choisir une catégorie</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= (isset($_POST['category_id']) && $_POST['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Image du produit</label>
                    <div class="image-upload" onclick="document.getElementById('image').click()">
                        <div style="font-size: 3em; color: var(--primary); margin-bottom: 15px;">📷</div>
                        <p style="margin-bottom: 10px; font-weight: bold; color: var(--light);">Cliquez pour télécharger une image</p>
                        <p class="file-info" style="color: var(--secondary); font-size: 0.9em;">
                            Formats acceptés : JPG, PNG, GIF, WebP (max 5MB)
                        </p>
                        <img id="image-preview" class="image-preview" src="" alt="Aperçu de l'image">
                    </div>
                    <input type="file" id="image" name="image" accept="image/*" style="display: none;" 
                           onchange="previewImage(this)">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Créer le produit</button>
                    <a href="index.php?action=admin-products" class="btn btn-outline">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/validation.js"></script>
</body>
</html>