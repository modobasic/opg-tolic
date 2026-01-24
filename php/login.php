<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Pokreni session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generiraj CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validacija
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'CSRF token validation failed';
    } else {
        $username = sanitize($_POST['username']);
        $password = $_POST['password']; // Ne sanitizirati lozinku
        
        // Rate limiting
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_login_attempt'] = time();
        }
        
        if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_login_attempt']) < 300) {
            $error = 'Previše pokušaja prijave. Pokušajte ponovno za 5 minuta.';
        } else {
            if (login($username, $password)) {
                // Resetiraj brojač pokušaja
                unset($_SESSION['login_attempts']);
                unset($_SESSION['last_login_attempt']);
                
                // Regeneriraj session ID
                session_regenerate_id(true);
                
                // Redirekt na glavnu stranicu
                header('Location: /opg-tolic/opg-tolic.php');
                exit();
            } else {
                $error = 'Neispravno korisničko ime ili lozinka';
                $_SESSION['login_attempts']++;
                $_SESSION['last_login_attempt'] = time();
            }
        }
    }
}

// Ako je korisnik već prijavljen, redirekt na glavnu stranicu
if (isLoggedIn()) {
    header('Location: /opg-tolic/opg-tolic.php');
	exit();
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava - Pčelarstvo Tolić</title>
    <link rel="stylesheet" href="/opg-tolic/css/styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Prijava</h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            
            <div class="form-group">
                <label for="username">Korisničko ime ili email:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Lozinka:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Prijavi se</button>
        </form>
        
        <p>Nemate račun? <a href="register.php">Registrirajte se ovdje</a></p>
    </div>
</body>
</html>