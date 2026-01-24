<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/config.php'; 

if (!isset($pdo)) {
    die("Database connection not established");
}
$user = getUserData($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'first_name' => sanitize($_POST['first_name']),
        'last_name' => sanitize($_POST['last_name']),
        'address' => sanitize($_POST['address']),
        'city' => sanitize($_POST['city']),
        'postal_code' => sanitize($_POST['postal_code']),
        'country' => sanitize($_POST['country']),
        'phone' => sanitize($_POST['phone']),
        'email' => sanitize($_POST['email'])
    ];
    
    // Update user data
    $stmt = $pdo->prepare("UPDATE users SET 
                          first_name = ?, 
                          last_name = ?, 
                          address = ?, 
                          city = ?, 
                          postal_code = ?, 
                          country = ?, 
                          phone = ?, 
                          email = ? 
                          WHERE id = ?");
    
    if ($stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['address'],
        $data['city'],
        $data['postal_code'],
        $data['country'],
        $data['phone'],
        $data['email'],
        $_SESSION['user_id']
    ])) {
        $success = "Podaci su uspješno ažurirani!";
        $user = getUserData($_SESSION['user_id']); // Refresh user data
    } else {
        $error = "Došlo je do greške prilikom ažuriranja podataka.";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moj profil - Pčelarstvo Tolić</title>
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
        <h1 class="profile-title">Moj profil</h1>
        
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="profile-container">
            <div class="profile-info">
                <h2>Osobni podaci</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Korisničko ime:</label>
                        <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="first_name">Ime:</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Prezime:</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Adresa:</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="city">Grad:</label>
                        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="postal_code">Poštanski broj:</label>
                        <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($user['postal_code']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="country">Država:</label>
                        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($user['country']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Telefon:</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                    </div>
                    
                    <button type="submit" class="btn">Ažuriraj podatke</button>
                </form>
                
                <h3>Promijeni lozinku</h3>
                <form method="POST" action="change-password.php">
                    <div class="form-group">
                        <label for="current_password">Trenutna lozinka:</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">Nova lozinka:</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Potvrdi novu lozinku:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" class="btn">Promijeni lozinku</button>
                </form>
            </div>
        </div>
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