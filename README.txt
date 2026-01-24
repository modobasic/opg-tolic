#  OPG Tolić - Honey E-commerce Platform

![PHP](https://img.shields.io/badge/PHP-8.2%2B-purple)
![MySQL](https://img.shields.io/badge/MySQL-8.0-blue)
![XAMPP](https://img.shields.io/badge/XAMPP-8.2-orange)
![License](https://img.shields.io/badge/License-Portfolio-green)

Kompletna web aplikacija za prodaju meda i pčelinjih proizvoda. PHP-based e-commerce platforma s punom autentifikacijom korisnika, košaricom, favoritima i administracijom proizvoda.

##  Funkcionalnosti

###  **Sistem Korisnika**
- Registracija i prijava korisnika
- Sigurno hashiranje lozinki (bcrypt)
- Upravljanje korisničkim profilom

###  **E-trgovina**
- Katalog proizvoda s detaljnim opisima
- Košarica za kupovinu
- Sistem favorita (spremanje proizvoda)

###  **Korisničko Iskustvo**
- Responsive dizajn za sve uređaje
- Intuitivna navigacija
- Visokokvalitetne slike proizvoda
- Brzo učitavanje stranica

###  **Informativni Dijelovi**
- "O nama" - Priča OPG-a Tolić
- "Kvaliteta" - Informacije o kvaliteti proizvoda

##  **Struktura Projekta**
opg-tolic/
├── opg-tolic.php # Početna stranica
├── webshop.php # Web shop s proizvodima
├── kosarica.php # Košarica za kupovinu
├── favoriti.php # Omiljeni proizvodi
├── o-nama.php # O nama stranica
├── kvaliteta.php # Kvaliteta proizvoda
│
├── css/ # Stilovi
│ └── styles.css # Glavni CSS fajl
│
├── js/ # JavaScript
│ └── script.js # Glavni JavaScript
│
├── img/ # Slike i grafički elementi
│ ├── tolic-logo.jpeg # Logo
│ ├── bagremov.jpg # Proizvodi...
│ └── ...
│
├── includes/ # Uključeni fajlovi
│ ├── header.php # Zaglavlje stranice
│ ├── footer.php # Podnožje stranice
│ ├── auth.php # Autentifikacija
│ ├── config.php # Konfiguracija baze
│ └── functions.php # Pomocne funkcije
│
└── php/ # PHP procesni fajlovi
├── login.php # Prijava
├── register.php # Registracija
├── logout.php # Odjava
├── profile.php # Profil korisnika
└── process_order.php # Obrada narudžbi
└── change-password.php #Promjena lozinke

text

##  **Instalacija i Pokretanje**

###  **Preduvjeti**
- [XAMPP](https://www.apachefriends.org/), start Apache
- spremiti u /xampp/htdocs
- učitati u Web preglednik (Chrome, Firefox, Edge)
- Git (opcionalno)

###  **Koraci Instalacije**

1. **Preuzmi projekt:**
   ```bash
   git clone https://github.com/modobasic/opg-tolic.git
