<?php
include "const.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$title?> - Excellence Commerciale</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
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
    overflow-x: hidden;
}

a {
    text-decoration: none;
    color: inherit;
    transition: var(--transition);
}

/* Hero Section */
.hero {
    height: 100vh;
    min-height: 800px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 0 2rem;
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
    position: relative;
}

.hero-content {
    max-width: 900px;
    z-index: 1;
}

.hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem;
    font-weight: 700;
    color: var(--white);
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.hero h1 span {
    color: var(--primary-red);
}

.hero p {
    font-size: 1.2rem;
    color: var(--light-gray);
    max-width: 700px;
    margin: 0 auto 2.5rem;
    font-weight: 300;
}

.btn-container {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.btn {
    padding: 1rem 2.5rem;
    border-radius: 0;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: var(--transition);
    cursor: pointer;
    border: 2px solid transparent;
}

.btn-primary {
    background: var(--primary-red);
    color: var(--white);
}

.btn-primary:hover {
    background: var(--dark-red);
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(209, 0, 0, 0.3);
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--primary-red);
    color: var(--primary-red);
}

.btn-outline:hover {
    background: var(--primary-red);
    color: var(--white);
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(209, 0, 0, 0.3);
}

/* Features Section */
.section {
    padding: 6rem 2rem;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--white);
    margin-bottom: 3rem;
    text-align: center;
    position: relative;
}

.section-title::after {
    content: '';
    display: block;
    width: 80px;
    height: 4px;
    background: var(--primary-red);
    margin: 1rem auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.feature-card {
    background: var(--dark-gray);
    padding: 2.5rem;
    border-radius: 0;
    transition: var(--transition);
    border-left: 4px solid var(--primary-red);
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
}

.feature-icon {
    font-size: 2.5rem;
    color: var(--primary-red);
    margin-bottom: 1.5rem;
}

.feature-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--white);
}

.feature-card p {
    color: var(--light-gray);
    font-size: 1rem;
    font-weight: 300;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), 
                url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
    padding: 8rem 2rem;
    text-align: center;
}

.cta-container {
    max-width: 800px;
    margin: 0 auto;
}

.cta-container h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    color: var(--white);
    margin-bottom: 1.5rem;
}

.cta-container p {
    font-size: 1.2rem;
    color: var(--light-gray);
    margin-bottom: 2.5rem;
    font-weight: 300;
}

.cta-btn {
    padding: 1.2rem 3rem;
    background: var(--primary-red);
    color: var(--white);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
    border-radius: 0;
    transition: var(--transition);
}

.cta-btn:hover {
    background: var(--dark-red);
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(209, 0, 0, 0.4);
}

/* Footer */
footer {
    background: var(--black);
    padding: 4rem 2rem 2rem;
    text-align: center;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    text-align: left;
    margin-bottom: 3rem;
}

.footer-column h3 {
    color: var(--white);
    font-size: 1.2rem;
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 0.5rem;
}

.footer-column h3::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 40px;
    height: 2px;
    background: var(--primary-red);
}

.footer-column p, .footer-column a {
    color: var(--light-gray);
    font-weight: 300;
    margin-bottom: 0.8rem;
    display: block;
}

.footer-column a:hover {
    color: var(--primary-red);
}

.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-links a {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--medium-gray);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.social-links a:hover {
    background: var(--primary-red);
    color: var(--white);
}

.footer-bottom {
    border-top: 1px solid var(--medium-gray);
    padding-top: 2rem;
    margin-top: 2rem;
    text-align: center;
}

.footer-bottom p {
    color: var(--light-gray);
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 992px) {
    .hero h1 {
        font-size: 2.8rem;
    }
}

@media (max-width: 768px) {
    .hero {
        min-height: 700px;
    }
    
    .hero h1 {
        font-size: 2.2rem;
    }
    
    .hero p {
        font-size: 1rem;
    }
    
    .section {
        padding: 4rem 1.5rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .btn {
        padding: 0.8rem 1.8rem;
    }
}

@media (max-width: 576px) {
    .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .footer-column h3::after {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .social-links {
        justify-content: center;
    }
}
</style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1><?=$title?> <span>Excellence</span></h1>
        <p>Une approche premium du commerce, alliant innovation, qualité et service exceptionnel pour une expérience client inégalée.</p>
        <div class="btn-container">
            <a href="./produit.php" class="btn btn-primary">Nos produits</a>
            <a href="#" class="btn btn-outline">Contactez-nous</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section">
    <h2 class="section-title">Nos engagements</h2>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-lock"></i></div>
            <h3>Sécurité absolue</h3>
            <p>Protection maximale de vos données avec les dernières technologies de chiffrement et de sécurité.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-rocket"></i></div>
            <h3>Livraison premium</h3>
            <p>Service express avec suivi en temps réel et garantie de livraison dans les délais impartis.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-certificate"></i></div>
            <h3>Qualité certifiée</h3>
            <p>Produits rigoureusement sélectionnés selon des critères d'excellence stricts.</p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-container">
        <h2>Prêt à vivre l'expérience <?=$title?> ?</h2>
        <p>Rejoignez notre communauté de clients satisfaits et découvrez la différence d'un service haut de gamme.</p>
        <a href="./produit.php" class="cta-btn">Commencer maintenant</a>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="footer-content">
        <div class="footer-column">
            <h3><?=$title?></h3>
            <p>Redéfinir les standards du commerce avec excellence et innovation depuis 2010.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-column">
            <h3>Liens utiles</h3>
            <a href="./produit.php">Nos produits</a>
            <a href="#">À propos</a>
            <a href="#">Services</a>
            <a href="#">Contact</a>
        </div>
        <div class="footer-column">
            <h3>Contact</h3>
            <p><i class="fas fa-map-marker-alt"></i> 123 Avenue Premium, Paris</p>
            <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
            <p><i class="fas fa-envelope"></i> contact@<?=strtolower($title)?>.com</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?=date('Y')?> <?=$title?>. Tous droits réservés.</p>
    </div>
</footer>

</body>
</html>