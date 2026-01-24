<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Košarica - Pčelarstvo Tolić</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

    <section id="cart">
        <h2>Vaša košarica</h2>
        <div id="cart-items-container"></div>
        <p>Ukupna cijena: <span id="cart-total">0</span> €</p>
        <button class="cart-btn" onclick="clearCart()">Isprazni košaricu</button>
    </section>

<?php include 'includes/footer.php'; ?>

</body>
</html>