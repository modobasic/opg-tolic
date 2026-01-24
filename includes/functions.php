<?php
require_once 'config.php';

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redirect function
function redirect($url) {
    header("Location: $url");
    exit();
}

// Get user data
function getUserData($userId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Login function
function login($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    
    return false;
}

// Register new user
function registerUser($data) {
    global $pdo;
    
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, first_name, last_name, address, city, postal_code, country, phone) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    return $stmt->execute([
        $data['username'],
        $data['email'],
        $hashedPassword,
        $data['first_name'],
        $data['last_name'],
        $data['address'],
        $data['city'],
        $data['postal_code'],
        $data['country'],
        $data['phone']
    ]);
}

// Check if username or email exists
function userExists($username, $email) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    return $stmt->fetch() !== false;
}

// Create an order
function createOrder($userId, $cartItems, $totalAmount, $paymentMethod, $shippingAddress) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Insert order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, payment_method, shipping_address) 
                              VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $totalAmount, $paymentMethod, $shippingAddress]);
        $orderId = $pdo->lastInsertId();
        
        // Insert order items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity) 
                              VALUES (?, ?, ?, ?)");
        
        foreach ($cartItems as $item) {
            $stmt->execute([$orderId, $item['name'], $item['price'], $item['quantity']]);
        }
        
        $pdo->commit();
        return $orderId;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

// Get user orders
function getUserOrders($userId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get order details
function getOrderDetails($orderId) {
    global $pdo;
    
    // Get order info
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) return false;
    
    // Get order items
    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->execute([$orderId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return [
        'order' => $order,
        'items' => $items
    ];
}
?>