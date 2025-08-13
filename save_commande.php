<?php
session_start();
include "connect.php"; // Assure-toi que la connexion est dans $con (ou adapte la variable)

// Fonction simple de nettoyage des données
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Nettoyage et récupération des données POST
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $username = isset($_POST['username']) ? cleanInput($_POST['username']) : '';
    $phone = isset($_POST['phone']) ? cleanInput($_POST['phone']) : '';
    $wilaya = isset($_POST['wilaya']) ? cleanInput($_POST['wilaya']) : '';
    $size = isset($_POST['size']) ? cleanInput($_POST['size']) : null;

    // Validation simple des champs obligatoires
    if ($product_id <= 0 || empty($username) || empty($wilaya)) {
        die("Erreur : Tous les champs obligatoires doivent être remplis.");
    }

    // Gestion du tableau de commandes dans la session
    if (isset($_SESSION['mes_commandes'])) {
        $_SESSION['mes_commandes'][] = $product_id;
    } else {
        $_SESSION['mes_commandes'] = [$product_id];
    }

    // Exemple : récupérer la catégorie liée au produit (à adapter selon ta base)
    // Ici, on suppose que la catégorie est envoyée dans le formulaire en POST
    $category = isset($_POST['category']) ? cleanInput($_POST['category']) : 'non définie';

    // Préparation de la requête SQL sécurisée
    $stmt = $con->prepare("INSERT INTO orders (product_id, category, username, phone, wilaya, size, createur) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Identification du createur par session PHPSESSID (cookie)
    $createur = isset($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : 'inconnu';

    // Exécution de la requête avec gestion d'erreur
    $success = $stmt->execute([$product_id, $category, $username, $phone, $wilaya, $size, $createur]);

    if ($success) {
        // Redirection vers la page produit après succès
        header("Location: produit.php");
        exit();
    } else {
        die("Erreur lors de l'enregistrement de la commande.");
    }

} else {
    die("Méthode non autorisée.");
}
