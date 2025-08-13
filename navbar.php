<?php
include "const.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
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

        #navbar {
            background-color: var(--black);
            color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            border-bottom: 2px solid var(--primary-red);
        }

        .logo .title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .logo .title span {
            color: var(--primary-red);
        }

        .links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .links a {
            color: var(--light-gray);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            position: relative;
            padding: 0.5rem 0;
            transition: var(--transition);
        }

        .links a:hover {
            color: var(--primary-red);
        }

        .links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-red);
            transition: var(--transition);
        }

        .links a:hover::after {
            width: 100%;
        }

        /* Menu mobile */
        .menu-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
            z-index: 1001;
        }

        .menu-toggle span {
            display: block;
            height: 3px;
            width: 100%;
            background: var(--white);
            transition: var(--transition);
        }

        .menu-toggle.active span:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 70%;
                height: 100vh;
                background: var(--black);
                flex-direction: column;
                justify-content: center;
                gap: 2.5rem;
                transition: 0.5s ease;
                border-left: 2px solid var(--primary-red);
            }

            .links.active {
                right: 0;
            }

            .menu-toggle {
                display: flex;
            }

            .hero {
                margin-top: 80px;
            }
        }

        @media (max-width: 576px) {
            #navbar {
                padding: 1rem;
            }

            .logo .title {
                font-size: 1.5rem;
            }

            .links {
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <nav id="navbar">
        <div class="logo">
            <h3 class="title"><?=$title?></h3>
        </div>
        
        <div class="menu-toggle" id="mobile-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <div class="links" id="nav-links">
            <a href="index.php">Accueil</a>
            <a href="produit.php">Produits</a>
            <a href="panier.php">Panier</a>
            <a href="liked_products.php">Favoris</a>
            <a href="https://wa.me/213697500919">Contact</a>
            <a href="http://wahid-portfillo.atwebpages.com/">Développeur</a>
        </div>
    </nav>

    <script>
        // Menu mobile
        const mobileMenu = document.getElementById('mobile-menu');
        const navLinks = document.getElementById('nav-links');

        mobileMenu.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            navLinks.classList.toggle('active');
        });

        // Fermer le menu quand on clique sur un lien
        document.querySelectorAll('#nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });

        // Changement de couleur au scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                document.getElementById('navbar').style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
                document.getElementById('navbar').style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.7)';
            } else {
                document.getElementById('navbar').style.backgroundColor = 'var(--black)';
                document.getElementById('navbar').style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.5)';
            }
        });
    </script>
</body>
</html>