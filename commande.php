<?php
session_start();
include "const.php";
include "navbar.php";
include "connect.php";  // Doit définir $con comme instance PDO

// Récupérer l'id depuis GET et s'assurer que c'est un entier
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($id > 0) {
    // Préparation de la requête avec PDO
    $stmt = $con->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Produit introuvable
if (!$product) {
    echo "<p style='text-align:center; font-weight:bold; color:red;'>Produit introuvable.</p>";
    exit;
}

// Catégorie en minuscules pour la logique
$category = strtolower($product['category']);
$allowed_categories = ['chaussure', 'tshirt', 't-shirt', 'pantalon', 'accessoires mobiles', 'accessoires', 'classique'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Commande du produit - <?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <style>
        /* (Le même CSS que précédemment, pour ne pas répéter ici) */
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f8f8f8;
            margin: 0; padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1rem;
        }
        .product-details {
            margin-bottom: 2rem;
            text-align: center;
        }
        .product-details img {
            max-width: 200px;
            border-radius: 12px;
            margin-bottom: 1rem;
            object-fit: contain;
        }
        .product-details p {
            margin: 0.3rem 0;
            color: #555;
        }
        label {
            font-weight: 600;
            margin-top: 1rem;
            display: block;
            color: #444;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        button {
            margin-top: 1.5rem;
            padding: 12px;
            width: 100%;
            background: #e91e63;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background: #c2185b;
        }
    </style>
</head>
<body>
    
<div style="margin-top: 100px;" class="container">
    <h1>Commande du produit</h1>

    <div class="product-details">
        <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p><strong>Prix actuel :</strong> <?= number_format($product['price'], 0, ',', ' ') ?> DA</p>
        <?php if (!empty($product['old_price']) && $product['old_price'] > 0): ?>
            <p><del>Ancien prix : <?= number_format($product['old_price'], 0, ',', ' ') ?> DA</del></p>
        <?php endif; ?>
        <p><strong>Catégorie :</strong> <?= htmlspecialchars($product['category']) ?></p>
        <p><strong>Description :</strong><br><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <p><strong>Badge :</strong> <?= htmlspecialchars($product['badge']) ?></p>
        <p><strong>Quantité en stock :</strong> <?= intval($product['qte']) ?></p>
    </div>

    <form method="POST" action="save_commande.php" autocomplete="off">
        <input type="hidden" name="product_id" value="<?= intval($product['id']) ?>">
        <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">

        <label for="username">Nom complet</label>
        <input type="text" id="username" name="username" required placeholder="Ex: Mohamed Ali" />

        <label for="phone">Numéro de téléphone</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required placeholder="Ex: 0550123456" title="10 chiffres requis" />

        <label for="wilaya">Wilaya</label>
        <select id="wilaya" name="wilaya" required>
            <option value="">-- Choisir une wilaya --</option>
            <?php
            $wilayas = [
                "Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira",
                "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda",
                "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "M’Sila", "Mascara", "Ouargla",
                "Oran", "El Bayadh", "Illizi", "Bordj Bou Arreridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt", "El Oued", "Khenchela",
                "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane",
                "Timimoun", "Bordj Badji Mokhtar", "Béni Abbès", "In Salah", "In Guezzam", "Touggourt", "Djanet", "El M'Ghair", "El Menia", "Ouled Djellal"
            ];
            foreach ($wilayas as $w) {
                echo '<option value="' . htmlspecialchars($w) . '">' . htmlspecialchars($w) . '</option>';
            }
            ?>
        </select>

        <?php
        // Sélection taille ou pointure selon catégorie
        if (in_array($category, ['tshirt', 't-shirt', 'pantalon', 'classique'])):
        ?>
            <label for="size">Taille</label>
            <select id="size" name="size" required>
                <option value="">-- Choisir la taille --</option>
                <?php foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size): ?>
                    <option value="<?= $size ?>"><?= $size ?></option>
                <?php endforeach; ?>
            </select>
        <?php elseif ($category === 'chaussure'): ?>
            <label for="size">Pointure</label>
            <select id="size" name="size" required>
                <option value="">-- Choisir la pointure --</option>
                <?php for ($i = 36; $i <= 45; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
        <?php endif; ?>

        <button type="submit"><i class="fas fa-check"></i> Valider la commande</button>
    </form>
</div>
</body>
</html>
