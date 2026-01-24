<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors['general'] = 'CSRF token validation failed';
    } else {
        $data = [
            'username' => sanitize($_POST['username']),
            'email' => sanitize($_POST['email']),
            'password' => $_POST['password'], // Don't sanitize password
            'first_name' => sanitize($_POST['first_name']),
            'last_name' => sanitize($_POST['last_name']),
            'address' => sanitize($_POST['address']),
            'city' => sanitize($_POST['city']),
            'postal_code' => sanitize($_POST['postal_code']),
            'country' => sanitize($_POST['country']),
            'phone' => sanitize($_POST['phone'])
        ];
        
        // Validate
        if (empty($data['username'])) {
            $errors['username'] = 'Korisničko ime je obavezno';
        } elseif (strlen($data['username']) < 4) {
            $errors['username'] = 'Korisničko ime mora imati najmanje 4 znaka';
        }
        
        if (empty($data['email'])) {
            $errors['email'] = 'Email je obavezan';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Neispravan email format';
        }
        
        if (empty($data['password'])) {
            $errors['password'] = 'Lozinka je obavezna';
        } elseif (strlen($data['password']) < 8) {
            $errors['password'] = 'Lozinka mora imati najmanje 8 znakova';
        } elseif (!preg_match('/[A-Z]/', $data['password']) || !preg_match('/[0-9]/', $data['password'])) {
            $errors['password'] = 'Lozinka mora sadržavati barem jedno veliko slovo i broj';
        }
        
        if (empty($data['first_name'])) {
            $errors['first_name'] = 'Ime je obavezno';
        }
        
        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Prezime je obavezno';
        }
        
        // Check if user exists
        if (userExists($data['username'], $data['email'])) {
            $errors['username'] = 'Korisničko ime ili email već postoji';
        }
        
        if (empty($errors)) {
            if (registerUser($data)) {
                $success = true;
                
                // Automatska prijava nakon registracije
                if (login($data['username'], $data['password'])) {
                    redirect('/opg-tolic/opg-tolic.php');
                }
            } else {
                $errors['general'] = 'Došlo je do greške prilikom registracije';
            }
        }
    }
}

// If already logged in, redirect to home
if (isLoggedIn()) {
    redirect('/opg-tolic/opg-tolic.php');
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija - Pčelarstvo Tolić</title>
    <link rel="stylesheet" href="/opg-tolic/css/styles.css">
</head>
<body>
    <div class="register-container">
        <h1>Registracija</h1>
        
        <?php if ($success): ?>
            <div class="success">
                Registracija uspješna! <a href="login.php">Prijavite se ovdje</a>
            </div>
        <?php else: ?>
            <?php if (!empty($errors['general'])): ?>
                <div class="error"><?php echo $errors['general']; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="form-group">
                    <label for="username">Korisničko ime:</label>
                    <input type="text" id="username" name="username" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>" required>
                    <?php if (!empty($errors['username'])): ?>
                        <span class="error-text"><?php echo $errors['username']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>" required>
                    <?php if (!empty($errors['email'])): ?>
                        <span class="error-text"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="password">Lozinka:</label>
                    <input type="password" id="password" name="password" required>
                    <small>Minimalno 8 znakova, barem jedno veliko slovo i broj</small>
                    <?php if (!empty($errors['password'])): ?>
                        <span class="error-text"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="first_name">Ime:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo isset($data['first_name']) ? $data['first_name'] : ''; ?>" required>
                    <?php if (!empty($errors['first_name'])): ?>
                        <span class="error-text"><?php echo $errors['first_name']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Prezime:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo isset($data['last_name']) ? $data['last_name'] : ''; ?>" required>
                    <?php if (!empty($errors['last_name'])): ?>
                        <span class="error-text"><?php echo $errors['last_name']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="address">Adresa:</label>
                    <input type="text" id="address" name="address" value="<?php echo isset($data['address']) ? $data['address'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="city">Grad:</label>
                    <input type="text" id="city" name="city" value="<?php echo isset($data['city']) ? $data['city'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="postal_code">Poštanski broj:</label>
                    <input type="text" id="postal_code" name="postal_code" value="<?php echo isset($data['postal_code']) ? $data['postal_code'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="country">Država:</label>
                    <input type="text" id="country" name="country" value="<?php echo isset($data['country']) ? $data['country'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="phone">Telefon:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>">
                </div>
                
                <button type="submit" class="btn">Registriraj se</button>
            </form>
            
            <p>Već imate račun? <a href="/opg-tolic/php/login.php">Prijavite se ovdje</a></p>
        <?php endif; ?>
    </div>
</body>
</html>