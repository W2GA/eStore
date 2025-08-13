<?php
include "./connect.php";

// Récupérer l'ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

// Charger les données du produit
if ($id > 0) {
    $stmt = $con->prepare("SELECT * FROM `products` WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Produit introuvable !");
    }
}

// Mise à jour si formulaire soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? '';
    $qte = intval($_POST["qte"] ?? 0);
    $price = floatval($_POST["price"] ?? 0);
    $old_price = floatval($_POST["old_price"] ?? 0);
    $category = $_POST["category"] ?? '';
    $image = $_POST["image"] ?? '';
    $description = $_POST["description"] ?? '';
    $badge = $_POST["badge"] ?? '';

    $stmt = $con->prepare("UPDATE `products` SET 
        name = ?, qte = ?, price = ?, old_price = ?, category = ?, image = ?, description = ?, badge = ?
        WHERE id = ?");
    $stmt->execute([$name, $qte, $price, $old_price, $category, $image, $description, $badge, $id]);

    header("Location: supprimer.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Produit</title>
<style>
    body {
        background-color: #121212;
        color: #fff;
        font-family: Arial, sans-serif;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #ff9800;
    }
    form {
        max-width: 500px;
        margin: auto;
        background: #1e1e1e;
        padding: 20px;
        border-radius: 10px;
    }
    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }
    input, textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: none;
        border-radius: 5px;
        background: #2c2c2c;
        color: #fff;
    }
    button {
        margin-top: 15px;
        padding: 10px;
        background: #4caf50;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
        font-weight: bold;
    }
    button:hover {
        opacity: 0.85;
    }
</style>
</head>
<body>

<h1>Modifier Produit</h1>

<form method="POST"  >
    <label>Nom :</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label>Quantité :</label>
    <input type="number" name="qte" value="<?= htmlspecialchars($product['qte']) ?>" required>

    <label>Prix :</label>
    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

    <label>Ancien Prix :</label>
    <input type="number" step="0.01" name="old_price" value="<?= htmlspecialchars($product['old_price']) ?>">

    <label>Catégorie :</label>
    <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>">

    <label>Image (URL) :</label>
    <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>">

    <label>Description :</label>
    <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

    <label>Badge :</label>
    <input type="text" name="badge" value="<?= htmlspecialchars($product['badge']) ?>">

    <button type="submit">Enregistrer</button>
</form>

</body>
</html>
