<?php
include "./connect.php";
include "./files.php";
// Vérification de l'ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
 $stmt = $con->prepare("SELECT * FROM `products` WHERE id = ?");
    $stmt->execute([$id]);
    $rpns= $stmt->fetchall(PDO::FETCH_ASSOC);
if ($id > 0) {
    $stmt = $con->prepare("DELETE FROM `products` WHERE id = ?");
    $stmt->execute([$id]);
  
}
echo "<pre>";
print_r($rpns);
echo "</pre>";

deletefile("uploads",$rpns[0]["image"]);
// Retour à la liste
header("Location: supprimer.php");
exit;
