<?php
include "connect.php";

// Récupérer toutes les commandes
$stmt = $con->prepare("SELECT * FROM orders ORDER BY created_at DESC");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statut des Commandes</title>
<style>
:root{
    --primary: #ff9800;
    --bg-dark: #121212;
    --table-bg: #1e1e1e;
    --text-light: #fff;
    --border-gray: #333;
    --hover-row: rgba(255,152,0,0.2);
}
*{ margin:0; padding:0; box-sizing:border-box; }

body{
    font-family: Arial, sans-serif;
    background: var(--bg-dark);
    color: var(--text-light);
    padding: 20px;
}
h1{
    text-align:center;
    margin-bottom:20px;
    color: var(--primary);
}

table{
    width:100%;
    border-collapse: collapse;
    background: var(--table-bg);
    border-radius:10px;
    overflow:hidden;
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
.product-img{
    width:50px;
    height:50px;
    object-fit: cover;
    border-radius:5px;
}

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
    .product-img{ width:70px; height:70px; }
}
</style>
</head>
<body>

<h1>Statut des Commandes</h1>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Produit</th>
    <th>Image</th>
    <th>Quantité Produit</th>
    <th>Prix Produit</th>
    <th>Nom Client</th>
    <th>Téléphone</th>
    <th>Wilaya</th>
    <th>Taille</th>
    <th>Date</th>
    <th>Status</th>
    <th>Createur</th>
</tr>
</thead>
<tbody>
<?php foreach($orders as $order):
    // Récupérer le détail du produit
    $stmt2 = $con->prepare("SELECT * FROM products WHERE id=?");
    $stmt2->execute([$order['product_id']]);
    $product = $stmt2->fetch(PDO::FETCH_ASSOC);
?>
<tr>
    <td data-label="ID"><?= $order['id'] ?></td>
    <td data-label="Produit"><?= htmlspecialchars($product['name'] ?? '-') ?></td>
    <td data-label="Image">
        <?php if(!empty($product['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" class="product-img">
        <?php endif; ?>
    </td>
    <td data-label="Quantité Produit"><?= $product['qte'] ?? '-' ?></td>
    <td data-label="Prix Produit"><?= isset($product['price'])?$product['price'].' DA':'-' ?></td>
    <td data-label="Nom Client"><?= htmlspecialchars($order['username']) ?></td>
    <td data-label="Téléphone"><?= htmlspecialchars($order['phone']) ?></td>
    <td data-label="Wilaya"><?= htmlspecialchars($order['wilaya']) ?></td>
    <td data-label="Taille"><?= htmlspecialchars($order['size']) ?></td>
    <td data-label="Date"><?= htmlspecialchars($order['created_at']) ?></td>
    <td data-label="Status"><?= htmlspecialchars($order['status']) ?></td>
    <td data-label="Createur"><?= htmlspecialchars($order['createur']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</body>
</html>
