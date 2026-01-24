<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pčelarstvo Tolić</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

<section id="home">
        <section class="hero">
            <div class="hero-slideshow">
                <img src="img/1.png" class="active" alt="Med 1">
                <img src="img/taa.jpg" alt="Med 2">
                <img src="img/3.png" alt="Med 3">
            </div>
            <div class="hero-text">
                <h3>Darovi iz srca košnice</h3>
                <h1>PČELARSTVO <span class="highlight">TOLIĆ</span></h1>
                <a href="webshop.php" class="hero-button">Webshop</a>
            </div>
        </section>


    <div class="container">
        <div class="section">
            <div class="text">
                <h2>TKO SMO?</h2>
                <h4>OBITELJSKO GOSPODARSTVO S DUGOGODIŠNJOM TRADICIJOM PČELARSTVA.</h4>
                <h3>Već 27 godina stvaramo najkvalitetniji med za vas.</h3>
                <h3>Ponosno dijelimo plodove našeg rada donoseći vam samo najčišći med bogat okusima prirode.</h3>
            </div>
            <img src="img/opg2.jpg" alt="OPG Tolić na sajmu">
        </div>

        <div class="section">
            <img src="img/pcele.jpg" alt="Naš štand s medom">
            <div class="text">
                <h2>NAŠA MISIJA</h2>
                <h3>Naša je misija pružiti vam prirodan, vrhunski i zdrav med koji dolazi iz srca prirode. Naše pčele rade s ljubavlju, a mi se trudimo očuvati tradiciju i kvalitetu.</h3>
                <h3>Sposobnost da spojimo prirodu, strast i iskustvo omogućava nam da vam pružimo med koji je više od proizvoda – <b>on je dar prirode.</b></h3>
            </div>
        </div>

        <div class="section">
            <div class="text">
                <h2>ZAŠTO NAŠ MED?</h2>
                <h3>Naš med dolazi iz čistih, prirodnih izvora bez ikakvih aditiva i dodataka. S pažnjom biramo pčelinje paše osiguravajući najvišu kvalitetu u svakom okusu.</h3>
                <h3>Ponosni smo što naš med zadržava svoju autentičnost i čistoću, donoseći vam esenciju prirode u svakom zalogaju.</h3>
            </div>
            <img src="img/5.jpg" alt="Staklenke meda">
        </div>
    </div>

   <section id="products">
  <h1>Naši proizvodi</h1>
  <div class="product-list">
    <div class="product" data-name="Cvjetni med" data-price="8">
      <img src="img/cvjetni.jpg" alt="Cvjetni med">
      <h3 style="margin-bottom: 37px; margin-top: 40px;">CVJETNI MED</h3>
	  <img src="img/heart.png" alt="Dodaj u favorite" class="favorite-icon" onclick="toggleFavorite('Cvjetni med', 10, 'cvjetni.jpg')">
      <p>Cijena proizvoda:</p>
      <h2 class="price">10,00 €</h2>
      <div class="product-actions">
        <button class="buy-btn" onclick="addToCart('Cvjetni med', 10, 'cvjetni.jpg')">Dodaj u košaricu</button>
      </div>
    </div>

   
    <div class="product" data-name="Bagremov med" data-price="10">
      <img src="img/bagremov.jpg" alt="Bagremov med">
      <h3>BAGREMOV MED</h3>
	  <img src="img/heart.png" alt="Dodaj u favorite" class="favorite-icon" onclick="toggleFavorite('Bagremov med', 12, 'bagremov.jpg')">
      <p>Cijena proizvoda:</p>
      <h2 class="price">12,00 €</h2>
      <div class="product-actions">
        <button class="buy-btn" onclick="addToCart('Bagremov med', 12, 'bagremov.jpg')">Dodaj u košaricu</button>
      </div>
    </div>

    
    <div class="product" data-name="Kestenov med" data-price="11">
      <img src="img/kestenov1.jpg" alt="Kestenov med">
      <h3>KESTENOV MED</h3>
	  <img src="img/heart.png" alt="Dodaj u favorite" class="favorite-icon" onclick="toggleFavorite('Kestenov med', 13, 'kestenov1.jpg')">
      <p>Cijena proizvoda:</p>
      <h2 class="price">13,00 €</h2>
      <div class="product-actions">
        <button class="buy-btn" onclick="addToCart('Kestenov med', 13, 'kestenov1.jpg')">Dodaj u košaricu</button>
      </div>
    </div>

   
    <div class="product" data-name="Propolis" data-price="15">
      <img src="img/propolis.jpg" alt="Propolis">
      <h3 style="margin-bottom: 37px; margin-top: 40px;">PROPOLIS</h3>
	  <img src="img/heart.png" alt="Dodaj u favorite" class="favorite-icon" onclick="toggleFavorite('Propolis', 15, 'propolis.jpg')">
      <p>Cijena proizvoda:</p>
      <h2 class="price">15,00 €</h2>
      <div class="product-actions">
        <button class="buy-btn" onclick="addToCart('Propolis', 15, 'propolis.jpg')">Dodaj u košaricu</button>
      </div>
    </div>

  
    <div class="product" data-name="Imuno Api Miks" data-price="18">
      <img src="img/api.jpg" alt="Imuno Api Miks">
      <h3>IMUNO API MIKS</h3>
	  <img src="img/heart.png" alt="Dodaj u favorite" class="favorite-icon" onclick="toggleFavorite('Imuno Api Miks', 18, 'api.jpg')">
      <p>Cijena proizvoda:</p>
      <h2 class="price">18,00 €</h2>
      <div class="product-actions">
        <button class="buy-btn" onclick="addToCart('Imuno Api Miks', 18, 'api.jpg')">Dodaj u košaricu</button>
      </div>
    </div>
  </div>

  <div class="read">
    <a href="webshop.html" class="read-more">➤ Pročitaj više</a>
  </div>
</section>

<section id="contact">
    <h1>Kontakt</h1>
    <div class="contact-container">
        <div class="contact-info owner-box">
            <h2>VLASNIK:</h2>
            <img src="img/vlasnik.jpg" alt="Vlasnik" class="owner-image">
            <div class="info-text">
                <p><strong>Ime i prezime:</strong> Valerijan Tolić</p>
                <p><strong>Email:</strong> valerijan.tolic@gmail.com</p>
                <p><strong>Adresa:</strong> Kolara IV 1.c, 35 000 Slavonski Brod</p>
                <p><strong>Broj mobitela:</strong> +385 123 456 789</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

</body>
</html>