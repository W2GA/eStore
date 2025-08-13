<?php
include "connect.php";
include "files.php";

$response = json_decode(imageUpload("productImage"), true);

// Vérification de l'upload
if (!$response || !isset($response['imagename'])) {
    die("Erreur : l'image n'a pas été téléchargée correctement.");
}

$name     = $_POST['productName']     ?? '';
$desc     = $_POST['productDescription'] ?? '';
$price    = $_POST['newPrice']        ?? 0;
$oldprice = $_POST['oldPrice']        ?? 0;
$badge    = $_POST['Badge']           ?? '';
$category = $_POST['productCategory'] ?? '';
$imgname  = $response['imagename'];
$qte = $_POST["qte"];

// Vérification des champs obligatoires
if (empty($name) || empty($price) || empty($category)) {
    die("Erreur : certains champs obligatoires sont manquants.");
}

try {
    $stmt = $con->prepare("
        INSERT INTO products (name, price, old_price, category, image, description, badge,qte)
        VALUES (?, ?, ?, ?, ?, ?, ?,?)
    ");
    $stmt->execute([$name, $price, $oldprice, $category, $imgname, $desc, $badge,$qte]);

    echo "Produit ajouté avec succès !";
    header("location:ajout_produit.php");
} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}
?>
