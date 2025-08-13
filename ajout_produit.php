<?php
include "const.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ajouter un produit - <?=$title?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
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
    font-family: 'Montserrat', sans-serif;
    background-color: var(--dark-bg);
    color: var(--text-light);
    padding-top: 50px;
}

/* Container */
.container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: var(--card-bg);
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(255,59,63,0.3);
}

/* Title */
.form-title {
    text-align: center;
    margin-bottom: 2rem;
    color: var(--primary);
    font-size: 1.8rem;
}

/* Form */
.form-group { margin-bottom: 1.5rem; }
.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
}
.form-control {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid var(--border-gray);
    border-radius: 5px;
    font-family: inherit;
    font-size: 1rem;
    background: #222;
    color: #fff;
    transition: border 0.3s ease;
}
.form-control:focus { outline: none; border-color: var(--primary); }
textarea.form-control { min-height: 120px; resize: vertical; }

/* Price inputs */
.price-container { display: flex; gap: 1rem; }
.price-input { flex:1; }

/* File upload */
.file-upload { position: relative; overflow: hidden; display: inline-block; width:100%; }
.file-upload-btn {
    border: 2px dashed var(--border-gray);
    border-radius: 5px;
    padding: 2rem;
    text-align: center;
    width: 100%;
    cursor: pointer;
    transition: all 0.3s ease;
    color: var(--text-light);
}
.file-upload-btn:hover { border-color: var(--primary); background: rgba(255,59,63,0.1); }
.file-upload-input {
    position: absolute; left:0; top:0; opacity:0; width:100%; height:100%; cursor:pointer;
}
.preview-image {
    max-width:200px; max-height:200px; margin-top:1rem; display:none; border-radius:5px;
}

/* Submit button */
.submit-btn {
    background: var(--primary);
    color: #fff;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    font-size:1rem;
}
.submit-btn:hover { background:#cc3238; transform: translateY(-2px); }

/* Responsive */
@media(max-width:768px){
    .container { padding: 1.5rem; margin: 1rem; }
    .price-container { flex-direction: column; gap: 1.5rem; }
}
</style>
</head>
<body>

<div class="container">
    <h1 class="form-title">Ajouter un nouveau produit</h1>

    <form id="productForm" action="traitement_produit.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="productName" class="form-label">Nom du produit</label>
            <input type="text" id="productName" name="productName" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="productDescription" class="form-label">Description</label>
            <textarea id="productDescription" name="productDescription" class="form-control" required></textarea>
        </div>

        <div class="form-group price-container">
            <div class="price-input">
                <label for="newPrice" class="form-label">Prix actuel (DA)</label>
                <input type="number" id="newPrice" name="newPrice" class="form-control" min="0" step="100" required>
            </div>
            <div class="price-input">
                <label for="oldPrice" class="form-label">Ancien prix (DA) <small>(optionnel)</small></label>
                <input type="number" id="oldPrice" name="oldPrice" class="form-control" min="0" step="100">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Image du produit</label>
            <div class="file-upload">
                <div class="file-upload-btn">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary); margin-bottom:1rem;"></i>
                    <p>Cliquez pour télécharger ou glissez-déposez une image</p>
                    <p><small>Format JPG, PNG (max. 2MB)</small></p>
                    <img id="imagePreview" class="preview-image" alt="Aperçu de l'image">
                </div>
                <input type="file" id="productImage" name="productImage" class="file-upload-input" accept="image/*" required>
            </div>
        </div>

        <div class="form-group">
            <label for="Badge" class="form-label">Badge</label>
            <input type="text" id="Badge" name="Badge" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="qte" class="form-label">Quantité</label>
            <input type="number" id="qte" name="qte" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="productCategory" class="form-label">Catégorie</label>
            <select id="productCategory" name="productCategory" class="form-control" required>
                <option value="">-- Sélectionnez une catégorie --</option>
                <option value="chaussure">Chaussure</option>
                <option value="t-shirt">T-shirt</option>
                <option value="pantalon">Pantalon</option>
                <option value="accessoires">Accessoires</option>
                <option value="accessoires mobiles">Accessoires mobiles</option>
            </select>
        </div>

        <button type="submit" class="submit-btn"><i class="fas fa-plus-circle"></i> Ajouter le produit</button>
    </form>
</div>

<script>
// Aperçu image
document.getElementById('productImage').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){ preview.src = e.target.result; preview.style.display = 'block'; }
        reader.readAsDataURL(file);
    }
});

// Validation ancien prix
document.getElementById('productForm').addEventListener('submit', function(e){
    const newPrice = parseFloat(document.getElementById('newPrice').value);
    const oldPrice = parseFloat(document.getElementById('oldPrice').value);
    if(oldPrice && oldPrice <= newPrice){
        alert("L'ancien prix doit être supérieur au prix actuel");
        e.preventDefault();
    }
});
</script>

</body>
</html>
