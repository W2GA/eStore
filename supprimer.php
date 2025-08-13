<?php
include "./connect.php";
$stmt = $con->prepare("SELECT * FROM `products`");
$stmt->execute();
$rpns = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produits</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
    --primary: #ff3b3f;       /* rouge vif */
    --dark-bg: #111;          /* noir principal */
    --card-bg: #1c1c1c;       /* fond card */
    --text-light: #e0e0e0;    /* texte clair */
    --border-gray: #333;
}

/* Reset */
* { margin:0; padding:0; box-sizing:border-box; }

body {
    background-color: var(--dark-bg);
    color: var(--text-light);
    font-family: Arial, sans-serif;
    padding: 20px;
}

/* Title */
h1 {
    text-align: center;
    color: var(--primary);
    margin-bottom: 20px;
}

/* Container */
.product-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

/* Card */
.product-card {
    background-color: var(--card-bg);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 8px rgba(0,0,0,0.5);
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.product-card:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 15px rgba(255,59,63,0.5);
}

/* Image */
.product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* Info */
.product-info {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.product-info h2 {
    font-size: 1.3em;
    margin: 0.5rem 0;
    color: var(--primary);
}

.price {
    font-size: 1.1em;
    color: #4caf50;
}
.old-price {
    text-decoration: line-through;
    color: #bbb;
    margin-left: 8px;
}

.description {
    font-size: 0.9em;
    margin: 8px 0;
    color: #ccc;
}

/* Badge */
.badge {
    background-color: var(--primary);
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 0.8em;
    display: inline-block;
    margin-bottom: 10px;
}

/* Buttons */
.btn-group {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}
.btn {
    flex: 1;
    padding: 8px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: opacity 0.2s ease;
    color: #fff;
}
.btn-edit { background-color: #4caf50; }
.btn-delete { background-color: #ff3b3f; }
.btn:hover { opacity: 0.85; }

/* Responsive */
@media(max-width:768px){
    .product-container { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<h1>Liste des Produits</h1>

<div class="product-container">
    <?php foreach($rpns as $rpn): ?>
    <div class="product-card">
        <img src="uploads/<?= htmlspecialchars($rpn["image"]) ?>" alt="Produit" class="product-image">
        <div class="product-info">
            <div>
                <?php if(!empty($rpn["badge"])): ?>
                    <span class="badge"><?= htmlspecialchars($rpn["badge"]) ?></span>
                <?php endif; ?>
                <h2><?= htmlspecialchars($rpn["name"]) ?></h2>
                <p class="price"><?= htmlspecialchars($rpn["price"]) ?> €
                    <?php if($rpn["old_price"] > 0): ?>
                        <span class="old-price"><?= htmlspecialchars($rpn["old_price"]) ?> €</span>
                    <?php endif; ?>
                </p>
                <p>Quantité : <?= htmlspecialchars($rpn["qte"]) ?></p>
                <p>Catégorie : <?= htmlspecialchars($rpn["category"]) ?></p>
                <p class="description"><?= htmlspecialchars($rpn["description"]) ?></p>
            </div>
            <div class="btn-group">
                <button class="btn btn-edit" onclick="editProduct(<?= $rpn['id'] ?>)"><i class="fas fa-edit"></i> Modifier</button>
                <button class="btn btn-delete" onclick="deleteProduct(<?= $rpn['id'] ?>)"><i class="fas fa-trash-alt"></i> Supprimer</button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
function editProduct(id) {
    window.location.href = "edit_product.php?id=" + id;
}
function deleteProduct(id) {
    if(confirm("Voulez-vous vraiment supprimer ce produit ?")){
        window.location.href = "delete_product.php?id=" + id;
    }
}
</script>

</body>
</html>
