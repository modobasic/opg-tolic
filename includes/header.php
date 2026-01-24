<?php
require_once 'auth.php';
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Pčelarstvo Tolić'; ?></title>
    <link rel="stylesheet" href="/opg-tolic/css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="/opg-tolic/opg-tolic.php">
                <img src="/opg-tolic/img/tolic-logo.jpeg" alt="Pčelarstvo Tolić">
            </a>
            <h1>PČELARSTVO <span class="highlight">TOLIĆ</span></h1>
        </div>
        <nav id="menu">
            <ul>
                <li><a href="/opg-tolic/opg-tolic.php">Početna</a></li>
                <li><a href="/opg-tolic/webshop.php">Proizvodi</a></li>
                <li><a href="/opg-tolic/o-nama.php">O nama</a></li>
                <li><a href="/opg-tolic/kvaliteta.php">Kvaliteta</a></li>
                <li><a href="/opg-tolic/opg-tolic.php#contact">Kontakt</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="/opg-tolic/php/profile.php">Moj profil</a></li>
                    <li><a href="/opg-tolic/php/logout.php">Odjava</a></li>
                <?php else: ?>
                    <li><a href="/opg-tolic/php/login.php">Prijava</a></li>
                    <li><a href="/opg-tolic/php/register.php">Registracija</a></li>
                <?php endif; ?>
            </ul>
            <div class="close-menu" id="closeMenu">&times;</div>
        </nav>
        <div class="icons">
            <a href="#" class="search-icon" id="searchToggle">
                <img src="/opg-tolic/img/search.png" alt="Pretraživanje">
            </a>
            <a href="/opg-tolic/favoriti.php" class="favorites-icon">
                <img src="/opg-tolic/img/heart.png" alt="Favoriti">
                <span id="favorite-count">0</span>
            </a>
            <a href="/opg-tolic/kosarica.php" class="cart-icon">
                <img src="/opg-tolic/img/cart.png" alt="Košarica">
                <span id="cart-count">0</span>
            </a>
        </div>
        <div class="search-container" id="searchContainer" style="display: none; position: relative;">
            <div class="close-search" id="closeSearch">&times;</div>
            <input type="text" id="searchInput" placeholder="Pretraži proizvode...">
            <button id="searchButton"><img src="/opg-tolic/img/search.png" alt="Pretraži"></button>
        </div>
        <div class="menu-icon" id="menuToggle">☰</div>
    </header>