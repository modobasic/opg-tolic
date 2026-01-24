<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/config.php'; 

session_start(); // Dodajte ovu liniju

if (!isset($_GET['id'])) {
    redirect('/opg-tolic/php/profile.php');
}

$orderId = (int)$_GET['id'];
$orderDetails = getOrderDetails($orderId);

// Check if order exists and belongs to user
if (!$orderDetails || $orderDetails['order']['user_id'] != $_SESSION['user_id']) {
    redirect('/opg-tolic/php/profile.php');
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalji narudžbe - Pčelarstvo Tolić</title>
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
                <li><a href="/opg-tolic/php/logout.php">Odjava</a></li>
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

    <main>
        <h1 class="order-title">Detalji narudžbe #<?php echo $orderDetails['order']['id']; ?></h1>
        
        <div class="order-details-container">
            <div class="order-info">
                <h2>Informacije o narudžbi</h2>
                
                <div class="info-row">
                    <span class="info-label">Datum narudžbe:</span>
                    <span class="info-value"><?php echo date('d.m.Y H:i', strtotime($orderDetails['order']['order_date'])); ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value"><?php echo ucfirst($orderDetails['order']['status']); ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Način plaćanja:</span>
                    <span class="info-value"><?php echo $orderDetails['order']['payment_method']; ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Ukupno:</span>
                    <span class="info-value"><?php echo number_format($orderDetails['order']['total_amount'], 2, ',', '.'); ?> €</span>
                </div>
                
                <h3>Adresa za dostavu</h3>
                <div class="shipping-address">
                    <?php echo nl2br($orderDetails['order']['shipping_address']); ?>
                </div>
            </div>
            
            <div class="order-items">
                <h2>Proizvodi</h2>
                
                <table>
                    <thead>
                        <tr>
                            <th>Proizvod</th>
                            <th>Cijena</th>
                            <th>Količina</th>
                            <th>Ukupno</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails['items'] as $item): ?>
                            <tr>
                                <td><?php echo $item['product_name']; ?></td>
                                <td><?php echo number_format($item['product_price'], 2, ',', '.'); ?> €</td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo number_format($item['product_price'] * $item['quantity'], 2, ',', '.'); ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Ukupno:</td>
                            <td><?php echo number_format($orderDetails['order']['total_amount'], 2, ',', '.'); ?> €</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <a href="/opg-tolic/php/profile.php" class="back-link">← Povratak na profil</a>
    </main>

    <footer>
        <p>Pratite nas:</p>
        <a href="https://www.instagram.com" target="_blank" class="social-link">
            <img src="/opg-tolic/img/instagram.png" alt="Instagram">
        </a>
        <a href="https://www.facebook.com" target="_blank" class="social-link">
            <img src="/opg-tolic/img/fb.png" alt="Facebook">
        </a>
        <p>&copy; 2025 Marija Odobašić. Sva prava pridržana.</p>
    </footer>

    <script src="/opg-tolic/js/script.js"></script>
</body>
</html>