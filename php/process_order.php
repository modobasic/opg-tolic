<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Morate biti prijavljeni da biste naručili.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Provjera da li je košarica prazna
if (empty($data['items']) || !is_array($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'Vaša košarica je prazna.']);
    exit;
}

// Provjera obaveznih podataka
if (empty($data['payment_method']) || empty($data['shipping_address']) || !isset($data['total_amount'])) {
    echo json_encode(['success' => false, 'message' => 'Nedostaju obavezni podaci za narudžbu.']);
    exit;
}

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Počni transakciju
    $db->beginTransaction();

    // Unesi narudžbu
    $orderQuery = $db->prepare("INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, status) 
                              VALUES (:user_id, :total_amount, :payment_method, :shipping_address, 'pending')");
    $orderQuery->execute([
        ':user_id' => $_SESSION['user_id'],
        ':total_amount' => $data['total_amount'],
        ':payment_method' => $data['payment_method'],
        ':shipping_address' => $data['shipping_address']
    ]);
    $orderId = $db->lastInsertId();

    // Unesi stavke narudžbe
    $itemsQuery = $db->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity) 
                               VALUES (:order_id, :product_name, :product_price, :quantity)");
    
    foreach ($data['items'] as $item) {
        if (empty($item['name']) || empty($item['price']) || empty($item['quantity'])) {
            throw new Exception("Nevažeći podaci o proizvodu.");
        }
        
        $itemsQuery->execute([
            ':order_id' => $orderId,
            ':product_name' => $item['name'],
            ':product_price' => $item['price'],
            ':quantity' => $item['quantity']
        ]);
    }

    // Potvrdi transakciju
    $db->commit();

    echo json_encode(['success' => true, 'order_id' => $orderId]);
} catch (PDOException $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Došlo je do greške prilikom obrade narudžbe.']);
} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>