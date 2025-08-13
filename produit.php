<?php
// Début du fichier - doit être la première chose avant tout code HTML
session_start();
include "const.php";
include "navbar.php";
include "connect.php";

// Récupération des produits
$products = showdata("SELECT * FROM `products` ORDER BY `products`.`id` DESC")["lignes"];

// Liste des catégories
$categories = [
    'all' => 'Tous les produits',
    'chaussure' => 'Chaussures',
    't-shirt' => 'T-shirts',
    "pantalon" => "Pantalons",
    'accessoires' => 'Accessoires',
    "accessoires mobiles" => "Accessoires mobiles"
];

// Filtrage par catégorie
$selectedCategory = $_GET['category'] ?? 'all';
$filteredProducts = ($selectedCategory === 'all')
    ? $products
    : array_filter($products, fn($p) => $p['category'] === $selectedCategory);

// Initialisation du tableau liked
if (!isset($_SESSION['liked'])) {
    $_SESSION['liked'] = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - <?=$title?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-red: #d10000;
            --dark-red: #8b0000;
            --black: #000000;
            --dark-gray: #121212;
            --medium-gray: #2a2a2a;
            --light-gray: #e0e0e0;
            --white: #ffffff;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--black);
            color: var(--light-gray);
            padding-top: 100px;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .page-title span {
            color: var(--primary-red);
        }

        .page-subtitle {
            color: var(--light-gray);
            max-width: 700px;
            margin: 0 auto;
            font-weight: 300;
            font-size: 1.1rem;
        }

        .categories {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 3rem 0;
        }

        .category-btn {
            padding: 0.8rem 1.8rem;
            background: var(--dark-gray);
            border: 1px solid var(--medium-gray);
            border-radius: 0;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
            color: var(--light-gray);
        }

        .category-btn:hover,
        .category-btn.active {
            background: var(--primary-red);
            color: var(--white);
            border-color: var(--primary-red);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(209, 0, 0, 0.3);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2.5rem;
        }

        .product-card {
            background: var(--dark-gray);
            border-radius: 0;
            overflow: hidden;
            transition: var(--transition);
            position: relative;
            border: 1px solid var(--medium-gray);
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            border-color: var(--primary-red);
        }

        .product-image {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-bottom: 1px solid var(--medium-gray);
        }

        .product-info {
            padding: 1.8rem;
        }

        .product-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: var(--white);
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-red);
            margin-bottom: 1.2rem;
        }

        .product-old-price {
            text-decoration: line-through;
            color: var(--medium-gray);
            font-size: 1rem;
            margin-left: 0.8rem;
        }

        .product-description {
            color: var(--light-gray);
            font-size: 0.95rem;
            margin-bottom: 1.8rem;
            font-weight: 300;
            line-height: 1.7;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .add-to-cart {
            background: var(--primary-red);
            color: var(--white);
            border: none;
            padding: 0.9rem 1.8rem;
            border-radius: 0;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
        }

        .add-to-cart:hover {
            background: var(--dark-red);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(209, 0, 0, 0.4);
        }

        .wishlist {
            background: none;
            border: none;
            font-size: 1.4rem;
            cursor: pointer;
            transition: var(--transition);
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .wishlist i {
            color: var(--medium-gray);
            transition: var(--transition);
        }

        .wishlist:hover i {
            color: var(--primary-red);
        }

        .wishlist.active i {
            color: var(--primary-red);
        }

        .product-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--primary-red);
            color: var(--white);
            padding: 0.5rem 1.2rem;
            border-radius: 0;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .no-products {
            text-align: center;
            grid-column: 1 / -1;
            padding: 4rem;
            color: var(--light-gray);
        }

        .no-products h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--white);
        }

        .no-products p {
            margin-bottom: 2rem;
            font-weight: 300;
        }

        @media (max-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .container {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 2.2rem;
            }

            .product-image {
                height: 300px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 80px;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .categories {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 1rem;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            .categories::-webkit-scrollbar {
                display: none;
            }

            .category-btn {
                white-space: nowrap;
                padding: 0.7rem 1.5rem;
            }

            .product-info {
                padding: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            .products-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">NOS <span>PRODUITS</span></h1>
            <p class="page-subtitle">Découvrez notre sélection exclusive de produits haut de gamme, alliant qualité et élégance</p>
        </div>
        
        <div class="categories">
            <?php foreach ($categories as $id => $name): ?>
                <a href="?category=<?= $id ?>" class="category-btn <?= $selectedCategory === $id ? 'active' : '' ?>">
                    <?= $name ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <div class="products-grid">
            <?php if (count($filteredProducts) > 0): ?>
                <?php foreach ($filteredProducts as $product): ?>
                    <div class="product-card">
                        <?php if ($product['badge']): ?>
                            <span class="product-badge"><?= $product['badge'] ?></span>
                        <?php endif; ?>
                        
                        <img src="uploads/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-image">
                        
                        <div class="product-info">
                            <h3 class="product-title"><?= $product['name'] ?></h3>
                            <p class="product-price">
                                <?= number_format($product['price'], 2, ',', ' ') ?> DA
                                <?php if ($product['old_price']): ?>
                                    <span class="product-old-price"><?= number_format($product['old_price'], 2, ',', ' ') ?> DA</span>
                                <?php endif; ?>
                            </p>
                            <p class="product-description"><?= $product['description'] ?></p>
                            
                            <div class="product-actions">
                                <button class="add-to-cart" onclick="location.href='commande.php?id=<?= $product['id'] ?>&category=<?= $product['category'] ?>'">
                                    <i class="fas fa-shopping-cart"></i> Ajouter
                                </button>
                                <button class="wishlist <?= in_array($product['id'], $_SESSION['liked']) ? 'active' : '' ?>" onclick="saveLike(<?= $product['id'] ?>, this)">
                                    <i class="<?= in_array($product['id'], $_SESSION['liked']) ? 'fas' : 'far' ?> fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <h3>Aucun produit disponible dans cette catégorie</h3>
                    <p>Explorez nos autres collections pour découvrir nos produits exclusifs</p>
                    <a href="?category=all" class="category-btn active">
                        Voir tous les produits
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    function saveLike(id, btn) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "save_cookie.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function() {
            // Toggle affichage
            btn.classList.toggle('active');
            let icon = btn.querySelector("i");
            if (btn.classList.contains("active")) {
                icon.classList.remove("far");
                icon.classList.add("fas");
            } else {
                icon.classList.remove("fas");
                icon.classList.add("far");
            }
        }

        xhr.send("id=" + encodeURIComponent(id));
    }
    </script>
</body>
</html>