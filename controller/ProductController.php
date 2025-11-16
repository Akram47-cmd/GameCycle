<?php
require_once 'model/Product.php';
require_once 'model/Category.php';

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    // FrontOffice - Liste des produits
    public function index() {
        $products = $this->productModel->getAll();
        require 'views/FrontOffice/products/index.php';
    }

    // FrontOffice - Détail produit
    public function show($id) {
        $product = $this->productModel->getById($id);
        if (!$product) {
            die('Produit non trouvé');
        }
        require 'views/FrontOffice/products/show.php';
    }

    // BackOffice - Liste produits
    public function adminIndex() {
        $products = $this->productModel->getAll();
        require 'views/BackOffice/products/index.php';
    }

    // BackOffice - Créer produit
    public function create() {
        $categories = $this->categoryModel->getAll();
        
        if ($_POST) {
            $errors = [];
            if (empty($_POST['title'])) $errors[] = "Le titre est obligatoire";
            if (empty($_POST['description'])) $errors[] = "La description est obligatoire";
            if (!is_numeric($_POST['price']) || $_POST['price'] < 0) $errors[] = "Le prix doit être un nombre positif";

            if (empty($errors)) {
                $imagePath = null;
                
                // Gestion de l'upload d'image
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    $maxSize = 5 * 1024 * 1024; // 5MB
                    
                    if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= $maxSize) {
                        $imagePath = $this->productModel->handleImageUpload($_FILES['image']);
                    } else {
                        $errors[] = "L'image doit être au format JPG, PNG, GIF ou WebP et ne pas dépasser 5MB";
                    }
                }
                
                if (empty($errors)) {
                    $data = [
                        'title' => htmlspecialchars($_POST['title']),
                        'description' => htmlspecialchars($_POST['description']),
                        'price' => $_POST['price'],
                        'category_id' => $_POST['category_id'],
                        'image' => $imagePath
                    ];
                    
                    if ($this->productModel->create($data)) {
                        header('Location: index.php?action=admin-products');
                        exit;
                    }
                }
            }
        }
        require 'views/BackOffice/products/create.php';
    }

    // BackOffice - Modifier produit
    public function edit($id) {
        $product = $this->productModel->getById($id);
        $categories = $this->categoryModel->getAll();
        
        if (!$product) {
            die('Produit non trouvé');
        }

        if ($_POST) {
            $data = [
                'title' => htmlspecialchars($_POST['title']),
                'description' => htmlspecialchars($_POST['description']),
                'price' => $_POST['price'],
                'category_id' => $_POST['category_id'],
                'image' => $product['image'] // Garde l'ancienne image par défaut
            ];
            
            // Gestion de l'upload d'image
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $maxSize = 5 * 1024 * 1024;
                
                if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= $maxSize) {
                    $imagePath = $this->productModel->handleImageUpload($_FILES['image']);
                    if ($imagePath) {
                        $data['image'] = $imagePath;
                    }
                }
            }
            
            if ($this->productModel->update($id, $data)) {
                header('Location: index.php?action=admin-products');
                exit;
            }
        }
        require 'views/BackOffice/products/edit.php';
    }

    // BackOffice - Supprimer produit
    public function delete($id) {
        if ($this->productModel->delete($id)) {
            header('Location: index.php?action=admin-products');
            exit;
        }
    }
}
?>