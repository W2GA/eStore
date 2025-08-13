<?php
include "connect.php";

// Récupérer toutes les commandes "livrée"
$stmt = $con->prepare("SELECT * FROM `orders` WHERE `status` = 'livrée'");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Commandes livrées</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
    --primary: #ff3b3f; /* rouge vif */
    --bg-dark: #111;
    --table-bg: #1c1c1c;
    --text-light: #e0e0e0;
    --border-gray: #333;
    --hover-row: rgba(255,59,63,0.2);
    --btn-return: #e67e22; /* orange pour retour */
    --btn-completed: #27ae60; /* vert pour completed */
}

/* Reset */
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: Arial, sans-serif;
    background: var(--bg-dark);
    color: var(--text-light);
    padding: 20px;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: var(--primary);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    background: var(--table-bg);
    border-radius: 10px;
    overflow: hidden;
}
th, td {
    padding: 12px;
    text-align: left;
}
th {
    background: #222;
    position: sticky;
    top: 0;
}
tr {
    border-bottom: 1px solid var(--border-gray);
    transition: background 0.3s;
}
tr:hover { background: var(--hover-row); }

/* Buttons */
td button {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    margin-right: 5px;
    color: #fff;
    transition: opacity 0.2s ease;
}
td button.return { background-color: var(--btn-return); }
td button.completed { background-color: var(--btn-completed); }
td button:hover { opacity: 0.85; }

/* Images */
.product-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
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
    td button{
        display:inline-block;
        margin-top:5px;
    }
    .product-img{
        width:70px;
        height:70px;
    }
}
</style>
</head>
<body>

<h1>Commandes livrées</h1>

<table id="ordersTable">
<thead>
<tr>
    <th>ID</th>
    <th>Produit</th>
    <th>Image</th>
    <th>Quantité</th>
    <th>Prix</th>
    <th>Nom</th>
    <th>Téléphone</th>
    <th>Wilaya</th>
    <th>Taille</th>
    <th>Date</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach($orders as $order):
    $stmt2 = $con->prepare("SELECT * FROM products WHERE id=?");
    $stmt2->execute([$order['product_id']]);
    $product = $stmt2->fetch(PDO::FETCH_ASSOC);
?>
<tr data-id="<?= $order['id'] ?>">
    <td data-label="ID"><?= $order['id'] ?></td>
    <td data-label="Produit"><?= $product['name'] ?? '-' ?></td>
    <td data-label="Image">
        <?php if(!empty($product['image'])): ?>
            <img src="uploads/<?= $product['image'] ?>" class="product-img">
        <?php endif; ?>
    </td>
    <td data-label="Quantité"><?= $product['qte'] ?? '-' ?></td>
    <td data-label="Prix"><?= isset($product['price'])?$product['price'].' DA':'-' ?></td>
    <td data-label="Nom"><?= $order['username'] ?></td>
    <td data-label="Téléphone"><?= $order['phone'] ?></td>
    <td data-label="Wilaya"><?= $order['wilaya'] ?></td>
    <td data-label="Taille"><?= $order['size'] ?></td>
    <td data-label="Date"><?= $order['created_at'] ?></td>
    <td data-label="Status"><?= $order['status'] ?></td>
    <td data-label="Actions">
        <button class="return"><i class="fas fa-undo"></i> Retour</button>
        <button class="completed"><i class="fas fa-check-circle"></i> Completed</button>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', ()=>{
    const table = document.getElementById('ordersTable');
    table.addEventListener('click', e=>{
        const btn = e.target.closest('button');
        if(!btn) return;
        const row = btn.closest('tr');
        const id = row.dataset.id;

        let newStatus = '';
        if(btn.classList.contains('return')) newStatus = 'retour';
        if(btn.classList.contains('completed')) newStatus = 'completed';

        if(newStatus){
            if(confirm(`Changer le statut en "${newStatus}" ?`)){
                fetch('update_status.php',{
                    method:'POST',
                    headers:{'Content-Type':'application/json'},
                    body:JSON.stringify({id:id, status:newStatus})
                }).then(res=>res.json()).then(data=>{
                    if(data.success){
                        row.remove(); // Supprime la ligne de la page
                    } else {
                        alert('Erreur lors de la mise à jour');
                    }
                });
            }
        }
    });
});
</script>

</body>
</html>
