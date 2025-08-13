<?php
session_start();
include "const.php";
include "navbar.php";
include "connect.php";

$createur = $_COOKIE["PHPSESSID"] ?? '';

// Requête pour récupérer les commandes
$stmt = $con->prepare("
    SELECT o.*, p.name as product_name, p.image as product_image 
    FROM orders o
    LEFT JOIN products p ON o.product_id = p.id
    WHERE o.createur = :createur 
    ORDER BY o.created_at DESC
");
$stmt->execute(['createur' => $createur]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $orderId = $_POST['order_id'];
    
    $checkStmt = $con->prepare("SELECT id FROM orders WHERE id = :id AND createur = :createur AND status = 'en attente'");
    $checkStmt->execute(['id' => $orderId, 'createur' => $createur]);
    
    if ($checkStmt->fetch()) {
        $deleteStmt = $con->prepare("DELETE FROM orders WHERE id = :id");
        $deleteStmt->execute(['id' => $orderId]);
        
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Commandes | <?=$title?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-red: #d10000;
            --dark-red: #8b0000;
            --black: #000000;
            --dark-gray: #121212;
            --medium-gray: #2a2a2a;
            --light-gray: #e0e0e0;
            --white: #ffffff;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--black);
            color: var(--light-gray);
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 120px auto 50px;
            padding: 0 2rem;
        }

        .page-header {
            margin-bottom: 3rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--medium-gray);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--white);
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -1.5rem;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--primary-red);
        }

        /* Table Styles */
        .orders-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--dark-gray);
            border: 1px solid var(--medium-gray);
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .orders-table thead {
            background: var(--primary-red);
            color: var(--white);
        }

        .orders-table th {
            padding: 1.2rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .orders-table tbody tr {
            transition: var(--transition);
            border-bottom: 1px solid var(--medium-gray);
        }

        .orders-table tbody tr:last-child {
            border-bottom: none;
        }

        .orders-table tbody tr:hover {
            background-color: rgba(209, 0, 0, 0.05);
        }

        .orders-table td {
            padding: 1.5rem 1.2rem;
            vertical-align: middle;
            font-size: 0.95rem;
            color: var(--light-gray);
        }

        /* Product Styles */
        .product-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .product-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 1px solid var(--medium-gray);
            transition: var(--transition);
        }

        .product-image:hover {
            transform: scale(1.05);
            border-color: var(--primary-red);
        }

        .product-name {
            font-weight: 600;
            color: var(--white);
            margin-bottom: 0.5rem;
            font-size: 1.05rem;
        }

        .product-category {
            font-size: 0.8rem;
            color: var(--light-gray);
            background: var(--medium-gray);
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            display: inline-block;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-pending {
            background-color: rgba(209, 0, 0, 0.1);
            color: var(--primary-red);
            border: 1px solid var(--primary-red);
        }

        .status-completed {
            background-color: rgba(0, 128, 0, 0.1);
            color: #008000;
            border: 1px solid #008000;
        }

        .status-cancelled {
            background-color: rgba(139, 0, 0, 0.1);
            color: var(--dark-red);
            border: 1px solid var(--dark-red);
        }

        /* Action Buttons */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.7rem 1.2rem;
            border-radius: 0;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .delete-btn {
            background-color: rgba(209, 0, 0, 0.1);
            color: var(--primary-red);
            border: 1px solid var(--primary-red);
        }

        .delete-btn:hover {
            background-color: var(--primary-red);
            color: var(--white);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: var(--dark-gray);
            border: 1px solid var(--medium-gray);
            border-radius: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--primary-red);
            margin-bottom: 1.5rem;
        }

        .empty-state-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--white);
            font-family: 'Playfair Display', serif;
        }

        .empty-state-text {
            color: var(--light-gray);
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-primary {
            display: inline-block;
            padding: 1rem 2rem;
            background-color: var(--primary-red);
            color: var(--white);
            border-radius: 0;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            background-color: var(--dark-red);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(209, 0, 0, 0.3);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .container {
                padding: 0 1.5rem;
            }
        }

        @media (max-width: 992px) {
            .orders-table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 100px;
                padding: 0 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .orders-table thead {
                display: none;
            }

            .orders-table, .orders-table tbody, .orders-table tr, .orders-table td {
                display: block;
                width: 100%;
            }

            .orders-table tr {
                margin-bottom: 1.5rem;
                border: 1px solid var(--medium-gray);
                padding: 1rem;
            }

            .orders-table td {
                padding: 1rem 1rem 1rem 50%;
                text-align: right;
                position: relative;
                border-bottom: 1px solid var(--medium-gray);
            }

            .orders-table td:last-child {
                border-bottom: none;
            }

            .orders-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                width: 45%;
                text-align: left;
                font-weight: 600;
                color: var(--primary-red);
                font-size: 0.85rem;
                text-transform: uppercase;
            }

            .product-info {
                flex-direction: column;
                align-items: flex-end;
                gap: 0.5rem;
            }

            .product-image {
                width: 60px;
                height: 60px;
            }
        }

        @media (max-width: 576px) {
            .page-title {
                font-size: 1.8rem;
            }

            .orders-table td {
                padding-left: 40%;
            }

            .orders-table td::before {
                width: 35%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Historique des Commandes</h1>
        </div>

        <?php if (empty($orders)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 class="empty-state-title">Aucune commande trouvée</h3>
                <p class="empty-state-text">Vous n'avez pas encore passé de commande. Lorsque vous le ferez, elles apparaîtront ici.</p>
                <a href="produit.php" class="btn-primary">Parcourir les produits</a>
            </div>
        <?php else: ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): 
                        $statusClass = '';
                        $statusText = '';
                        $isPending = false;
                        
                        switch (strtolower($order['status'])) {
                            case 'en attente':
                                $statusClass = 'status-pending';
                                $statusText = 'En attente';
                                $isPending = true;
                                break;
                            case 'validée':
                            case 'validee':
                                $statusClass = 'status-completed';
                                $statusText = 'Validée';
                                break;
                            case 'annulée':
                            case 'annulee':
                                $statusClass = 'status-cancelled';
                                $statusText = 'Annulée';
                                break;
                            default:
                                $statusClass = 'status-pending';
                                $statusText = $order['status'];
                        }

                        $productImage = !empty($order['product_image']) ? 
                            "uploads/{$order['product_image']}" : 
                            "images/default-product.jpg";
                    ?>
                    <tr>
                        <td data-label="Produit">
                            <div class="product-info">
                                <img src="<?= $productImage ?>" alt="<?= htmlspecialchars($order['product_name'] ?? '') ?>" class="product-image">
                                <div>
                                    <div class="product-name"><?= htmlspecialchars($order['product_name'] ?? 'Produit inconnu') ?></div>
                                    <div class="product-category"><?= htmlspecialchars($order['category'] ?? '') ?></div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Client">
                            <div><?= htmlspecialchars($order['username']) ?></div>
                            <div style="font-size:0.8rem; color:var(--light-gray);"><?= htmlspecialchars($order['phone']) ?></div>
                            <div style="font-size:0.8rem; color:var(--light-gray);"><?= htmlspecialchars($order['wilaya']) ?></div>
                        </td>
                        <td data-label="Date"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                        <td data-label="Statut">
                            <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                        <td data-label="Actions">
                            <?php if ($isPending): ?>
                                <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?');">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <button type="submit" name="delete_order" class="action-btn delete-btn">
                                        <i class="fas fa-trash-alt"></i> Annuler
                                    </button>
                                </form>
                            <?php else: ?>
                                <span style="color: var(--medium-gray); font-size: 0.8rem;">Non annulable</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation pour les lignes du tableau
            const rows = document.querySelectorAll('.orders-table tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Gestion des erreurs d'image
            document.querySelectorAll('.product-image').forEach(img => {
                img.addEventListener('error', function() {
                    this.src = 'images/default-product.jpg';
                    this.style.borderColor = 'var(--medium-gray)';
                });
            });
        });
    </script>
</body>
</html>