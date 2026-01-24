<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pčelarstvo Tolić - Webshop</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

  <main>
        <h2 class="webshop">Webshop - Proizvodi</h2>

      <div class="product-item">
      <img src="img/cvjetni.jpg" alt="Cvjetni med">
      <div class="product-details">
        <div class="product-title-wrapper">
      <h3>CVJETNI MED</h3>
      <img src="img/heartt.png" alt="Dodaj u favorite" 
           class="favorit-icon" 
           onclick="toggleFavorite('Cvjetni med', 10, 'cvjetni.jpg')">
    </div>
        <p>Cvjetni med mješavina je nektara raznih cvjetova. Odlikuje ga blaga aroma savršena za doručak ili čaj.</p>
        <h4 class="price">Cijena: 10,00 €</h4>
        <div class="product-actions">
          <button class="add-to-cart" onclick="addToCart('Cvjetni med', 10, 'cvjetni.jpg')">Dodaj u košaricu</button>
        </div>
      </div>
    </div>

    <div class="product-item">
      <img src="img/bagremov.jpg" alt="Bagremov med">
      <div class="product-details">
       <div class="product-title-wrapper">
      <h3>BAGREMOV MED</h3>
      <img src="img/heartt.png" alt="Dodaj u favorite" 
           class="favorit-icon" 
           onclick="toggleFavorite('Bagremov med', 12, 'bagremov.jpg')">
    </div>
        <p>Bagremov med blagog je okusa. Njegova lagana struktura čini ga pogodnim za osobe osjetljive na jače vrste meda.</p>
        <h4 class="price">Cijena: 12,00 €</h4>
        <div class="product-actions">
          <button class="add-to-cart" onclick="addToCart('Bagremov med', 12, 'bagremov.jpg')">Dodaj u košaricu</button>
        </div>
      </div>
    </div>

    <div class="product-item">
      <img src="img/kestenov1.jpg" alt="Kestenov med">
      <div class="product-details">
       <div class="product-title-wrapper">
      <h3>KESTENOV MED</h3>
      <img src="img/heartt.png" alt="Dodaj u favorite" 
           class="favorit-icon" 
           onclick="toggleFavorite('Kestenov med', 13, 'kestenov1.jpg')">
    </div>
        <p>Kestenov med tamne je boje i gorkastog okusa. Bogat je antioksidansima i mineralima koji poboljšavaju cirkulaciju i jačaju krvne žile.</p>
        <h4 class="price">Cijena: 13,00 €</h4>
        <div class="product-actions">
          <button class="add-to-cart" onclick="addToCart('Kestenov med', 13, 'kestenov1.jpg')">Dodaj u košaricu</button>
        </div>
      </div>
    </div>

    <div class="product-item">
      <img src="img/propolis.jpg" alt="Propolis">
      <div class="product-details">
         <div class="product-title-wrapper">
      <h3>PROPOLIS</h3>
      <img src="img/heartt.png" alt="Dodaj u favorite" 
           class="favorit-icon" 
           onclick="toggleFavorite('Propolis', 15, 'propolis.jpg')">
    </div>
        <p>Propolis je snažan prirodni antibiotik koji pomaže tijelu u borbi protiv bakterija, virusa i gljivica.</p>
        <h4 class="price">Cijena: 15,00 €</h4>
        <div class="product-actions">
          <button class="add-to-cart" onclick="addToCart('Propolis', 15, 'propolis.jpg')">Dodaj u košaricu</button>
        </div>
      </div>
    </div>

    <div class="product-item">
      <img src="img/api.jpg" alt="Imuno Api Miks">
      <div class="product-details">
        <div class="product-title-wrapper">
      <h3>IMUNO API MIKS</h3>
      <img src="img/heartt.png" alt="Dodaj u favorite" 
           class="favorit-icon" 
           onclick="toggleFavorite('Imuno Api Miks', 18, 'api.jpg')">
    </div>
        <p>Imuno api miks kombinira moćne sastojke poput meda, propolisa, matične mliječi i peludi, pružajući snažnu podršku imunitetu.</p>
        <h4 class="price">Cijena: 18,00 €</h4>
        <div class="product-actions">
          <button class="add-to-cart" onclick="addToCart('Imuno Api Miks', 18, 'api.jpg')">Dodaj u košaricu</button>
        </div>
      </div>
    </div>
    </main>
    <div id="favorites-container" class="favorites-container">
	</div>

</body>

<?php include 'includes/footer.php'; ?>

</html>
