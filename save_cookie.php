<?php
session_start();

// Si le tableau 'liked' n'existe pas, on le crée
if (!isset($_SESSION['liked'])) {
    $_SESSION['liked'] = [];
}

// Vérifie si un ID a été envoyé
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // sécurité : on force un entier

    // Si déjà liké → on retire
    if (in_array($id, $_SESSION['liked'])) {
        $_SESSION['liked'] = array_diff($_SESSION['liked'], [$id]);
        echo "unliked"; // pour info côté JS
    } 
    // Sinon → on ajoute
    else {
        $_SESSION['liked'][] = $id;
        echo "liked"; // pour info côté JS
    }
} else {
    echo "no_id";
}
