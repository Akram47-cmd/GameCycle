<?php
// Autoload des classes
spl_autoload_register(function ($class) {
    $paths = [
        'controller/' . $class . '.php',
        'model/' . $class . '.php',
        'config/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Router
$action = $_GET['action'] ?? 'products';
$id = $_GET['id'] ?? null;

$productController = new ProductController();

switch ($action) {
    case 'products':
        $productController->index();
        break;
        
    case 'show-product':
        if ($id) {
            $productController->show($id);
        } else {
            header('Location: index.php');
        }
        break;
        
    case 'admin-products':
        $productController->adminIndex();
        break;
        
    case 'create-product':
        $productController->create();
        break;
        
    case 'edit-product':
        if ($id) {
            $productController->edit($id);
        } else {
            header('Location: index.php?action=admin-products');
        }
        break;
        
    case 'delete-product':
        if ($id) {
            $productController->delete($id);
        } else {
            header('Location: index.php?action=admin-products');
        }
        break;
        
    default:
        $productController->index();
        break;
}
?>