<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
:root {
  --bg-dark: #111;        /* noir principal */
  --bg-card: #1c1c1c;     /* sidebar et cards */
  --primary: #ff3b3f;     /* rouge vif */
  --text-light: #e0e0e0;  /* texte clair */
  --transition: 0.3s ease;
}

/* Reset */
html, body {
  margin:0;
  padding:0;
  height:100%;
  font-family: "Segoe UI", sans-serif;
  background: var(--bg-dark);
  color: var(--text-light);
}

body {
  display:flex;
  min-height:100vh;
}

/* Sidebar */
.sidebar {
  width:260px;
  background: var(--bg-card);
  display:flex;
  flex-direction:column;
  padding:1rem;
}

.sidebar h1 {
  font-size:1.5rem;
  text-align:center;
  margin-bottom:2rem;
  color: var(--primary);
}

.menu {
  list-style:none;
  padding:0;
  margin:0;
  flex:1;
}

.menu-item { margin-bottom:0.5rem; }

.menu-link {
  display:flex;
  align-items:center;
  gap:10px;
  padding:0.8rem 1rem;
  color: var(--text-light);
  text-decoration:none;
  border-radius:8px;
  transition: background var(--transition), transform var(--transition);
}

.menu-link:hover, .menu-link.active {
  background: var(--primary);
  color:#fff;
  transform: translateX(5px);
}

.menu-link i { min-width:20px; text-align:center; }

/* Badge */
.badge {
  position:absolute;
  right:12px;
  background: var(--primary);
  color:#fff;
  border-radius:50%;
  font-size:0.75rem;
  padding:4px 7px;
}

/* Main content with iframe */
.main-content {
  flex:1;
  display:flex;
  flex-direction:column;
}

iframe {
  flex:1;
  width:100%;
  border:none;
}

/* Responsive */
@media (max-width:768px){
  body { flex-direction:column; }
  .sidebar {
    width:100%;
    flex-direction:row;
    overflow-x:auto;
    padding:0.5rem;
  }
  .menu {
    display:flex;
    flex-direction:row;
    gap:0.5rem;
  }
  .menu-link {
    flex-direction:column;
    font-size:0.75rem;
    padding:0.5rem;
    min-width:70px;
    justify-content:center;
  }
  iframe { height:calc(100vh - 80px); }
}
</style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
  <h1>Admin</h1>
  <ul class="menu">
    <li class="menu-item"><a href="ajout_produit.php" class="menu-link" data-page="ajout_produit.php"><i class="fas fa-plus-circle"></i> Ajouter</a></li>
    <li class="menu-item"><a href="supprimer.php" class="menu-link" data-page="supprimer.php"><i class="fas fa-trash-alt"></i> Supprimer</a></li>
    <li class="menu-item"><a href="enAttentCommande.php" class="menu-link" data-page="enAttentCommande.php"><i class="fas fa-clock"></i> Attente</a></li>
    <li class="menu-item"><a href="confirmedCommande.php" class="menu-link" data-page="confirmedCommande.php"><i class="fas fa-check-circle"></i> Confirmée</a></li>
    <li class="menu-item"><a href="livrée.php" class="menu-link" data-page="livrée.php"><i class="fas fa-truck"></i> Livrée</a></li>
    <li class="menu-item"><a href="terminated.php" class="menu-link" data-page="terminated.php"><i class="fas fa-flag-checkered"></i> Terminée</a></li>
    <li class="menu-item"><a href="status.php" class="menu-link" data-page="status.php"><i class="fas fa-chart-line"></i> Status</a></li>
  </ul>
</aside>

<!-- Main content -->
<main class="main-content">
  <iframe id="content-frame" src="ajout_produit.php"></iframe>
</main>

<script>
const links = document.querySelectorAll('.menu-link');
links.forEach(link=>{
  link.addEventListener('click', function(e){
    e.preventDefault();
    document.getElementById('content-frame').src = this.getAttribute('data-page');
    
    // Active link
    links.forEach(l=>l.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>

</body>
</html>
