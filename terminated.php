<?php
include "connect.php";

// Récupérer les commandes completed
$stmtCompleted = $con->prepare("SELECT * FROM orders WHERE status='completed'");
$stmtCompleted->execute();
$completedOrders = $stmtCompleted->fetchAll(PDO::FETCH_ASSOC);
$completedCount = count($completedOrders);

// Récupérer les commandes retour
$stmtRetour = $con->prepare("SELECT * FROM orders WHERE status='retour'");
$stmtRetour->execute();
$retourOrders = $stmtRetour->fetchAll(PDO::FETCH_ASSOC);
$retourCount = count($retourOrders);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Commandes Completed et Retour</title>
<style>
:root{
    --primary: #ff3b3f;
    --bg-dark: #111;
    --table-bg: #1c1c1c;
    --text-light: #e0e0e0;
    --border-gray: #333;
    --hover-row: rgba(255,59,63,0.2);
    --btn-completed: #27ae60;
    --btn-retour: #e67e22;
}
*{ margin:0; padding:0; box-sizing:border-box; }

body{
    font-family: Arial, sans-serif;
    background: var(--bg-dark);
    color: var(--text-light);
    padding: 20px;
}
h1,h2{
    text-align:center;
    margin-bottom:10px;
    color: var(--primary);
}
table{
    width:100%;
    border-collapse: collapse;
    background: var(--table-bg);
    border-radius:10px;
    overflow:hidden;
    margin-bottom:30px;
}
th, td{
    padding:12px;
    text-align:left;
}
th{
    background: #222;
    position: sticky;
    top:0;
}
tr{
    border-bottom:1px solid var(--border-gray);
    transition: background 0.3s;
}
tr:hover{ background: var(--hover-row); }

/* Mobile stacked table */
@media(max-width:768px){
    table, thead, tbody, th, td, tr{ display:block; width:100%; }
    thead tr{ display:none; }
    tr{
        margin-bottom:15px;
        border:1px solid var(--border-gray);
        border-radius:10px;
        padding:10px;
    }
    td{
        padding:8px;
        position:relative;
        text-align:left;
    }
    td::before{
        content: attr(data-label);
        font-weight:bold;
        width:120px;
        display:inline-block;
        color:#aaa;
    }
}
</style>
</head>
<body>

<h1>Commandes Completed et Retour</h1>

<h2>Completed (<?= $completedCount ?>)</h2>
<table>
<thead>
<tr>
    <th>ID</th>
    <th>Produit</th>
    <th>Nom</th>
    <th>Téléphone</th>
    <th>Date</th>
</tr>
</thead>
<tbody>
<?php foreach($completedOrders as $order): 
    $stmt2 = $con->prepare("SELECT name FROM products WHERE id=?");
    $stmt2->execute([$order['product_id']]);
    $product = $stmt2->fetch(PDO::FETCH_ASSOC);
?>
<tr>
    <td data-label="ID"><?= $order['id'] ?></td>
    <td data-label="Produit"><?= htmlspecialchars($product['name'] ?? '-') ?></td>
    <td data-label="Nom"><?= htmlspecialchars($order['username']) ?></td>
    <td data-label="Téléphone"><?= htmlspecialchars($order['phone']) ?></td>
    <td data-label="Date"><?= htmlspecialchars($order['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<h2>Retour (<?= $retourCount ?>)</h2>
<table>
<thead>
<tr>
    <th>ID</th>
    <th>Produit</th>
    <th>Nom</th>
    <th>Téléphone</th>
    <th>Date</th>
</tr>
</thead>
<tbody>
<?php foreach($retourOrders as $order): 
    $stmt2 = $con->prepare("SELECT name FROM products WHERE id=?");
    $stmt2->execute([$order['product_id']]);
    $product = $stmt2->fetch(PDO::FETCH_ASSOC);
?>
<tr>
    <td data-label="ID"><?= $order['id'] ?></td>
    <td data-label="Produit"><?= htmlspecialchars($product['name'] ?? '-') ?></td>
    <td data-label="Nom"><?= htmlspecialchars($order['username']) ?></td>
    <td data-label="Téléphone"><?= htmlspecialchars($order['phone']) ?></td>
    <td data-label="Date"><?= htmlspecialchars($order['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</body>
</html>
