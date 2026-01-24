<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = sanitize($_POST['current_password']);
    $newPassword = sanitize($_POST['new_password']);
    $confirmPassword = sanitize($_POST['confirm_password']);
    
    // Get current password hash
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    // Verify current password
    if (!password_verify($currentPassword, $user['password'])) {
        $error = 'Trenutna lozinka nije točna';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'Nove lozinke se ne podudaraju';
    } elseif (strlen($newPassword) < 6) {
        $error = 'Lozinka mora imati najmanje 6 znakova';
    } else {
        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        
        if ($stmt->execute([$hashedPassword, $_SESSION['user_id']])) {
            $success = 'Lozinka je uspješno promijenjena!';
        } else {
            $error = 'Došlo je do greške prilikom promjene lozinke';
        }
    }
}

if (!empty($success)) {
    $_SESSION['success_message'] = $success;
    redirect('/opg-tolic/php/profile.php');
} else {
    $_SESSION['error_message'] = $error;
    redirect('/opg-tolic/php/profile.php');
}
?>