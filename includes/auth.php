<?php
require_once 'config.php';
require_once 'functions.php';

// Check if user is logged in, if not redirect to login
if (!isLoggedIn() && basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'register.php') {
    redirect('php/login.php');
}
?>