document.addEventListener('DOMContentLoaded', () => {
    // Hamburger menu funkcionalnost
    const menuIcon = document.querySelector('.menu-icon');
    const menu = document.querySelector('#menu');
    const closeMenu = document.querySelector('#closeMenu');

    if (menuIcon) {
        menuIcon.addEventListener('click', () => {
            menu.classList.toggle('show');
        });
    }

    if (closeMenu) {
        closeMenu.addEventListener('click', () => {
            menu.classList.remove('show');
        });
    }

    const navLinks = document.querySelectorAll('nav ul li a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.remove('show');
        });
    });

    // Aktivna navigacija na scroll
    document.addEventListener('scroll', function() {
        const contactSection = document.getElementById('contact');
        const pocetnaLink = document.querySelector('nav ul li a[href="#home"]');
        const kontaktLink = document.querySelector('nav ul li a[href="#contact"]');

        if (contactSection && pocetnaLink && kontaktLink) {
            const contactSectionTop = contactSection.offsetTop;
            const scrollPosition = window.scrollY;

            pocetnaLink.classList.remove('active');
            kontaktLink.classList.remove('active');

            if (scrollPosition >= contactSectionTop - 250) {
                kontaktLink.classList.add('active');
            } else {
                pocetnaLink.classList.add('active');
            }
        }
    });

    // Hero Slideshow
    const slides = document.querySelectorAll('.hero-slideshow img');
    if (slides.length > 0) {
        let slideIndex = 0;
        
        slides.forEach((slide, index) => {
            slide.style.position = 'absolute';
            slide.style.top = '0';
            slide.style.left = '0';
            slide.style.width = '100%';
            slide.style.height = '100vh';
            slide.style.opacity = index === slideIndex ? '1' : '0';
            slide.style.transition = 'opacity 1.5s ease-in-out';
        });

        function showSlides() {
            slides.forEach((slide, index) => {
                slide.style.opacity = index === slideIndex ? '1' : '0';
            });
            slideIndex = (slideIndex + 1) % slides.length;
            setTimeout(showSlides, 4000);
        }
        showSlides();
    }

        loadCartCount();

    // Search funkcionalnost
    const searchIcon = document.querySelector('.search-icon');
    const closeSearch = document.getElementById('closeSearch');
    const searchButton = document.getElementById('searchButton');
    const searchInput = document.getElementById('searchInput');

    if (searchIcon) {
        searchIcon.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSearch();
        });
    }

    if (closeSearch) {
        closeSearch.addEventListener('click', toggleSearch);
    }

    if (searchButton) {
        searchButton.addEventListener('click', (e) => {
            e.preventDefault();
            searchProducts();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', debounce(searchProducts, 300));
        
        searchInput.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                searchProducts();
            }
        });
    }

    // Klik izvan zatvara search
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-container') && 
            !e.target.closest('.search-icon') && 
            !e.target.closest('.search-results')) {
            const searchContainer = document.getElementById('searchContainer');
            if (searchContainer) searchContainer.style.display = 'none';
            
            const results = document.querySelector('.search-results');
            if (results) results.remove();
        }
    });
});



// Funkcije za košaricu
function addToCart(productName, price, image) {
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    let existingProduct = cartItems.find(item => item.name === productName);

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cartItems.push({ 
            name: productName, 
            price: price, 
            image: image,  
            quantity: 1 
        });
    }

    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    updateCartCount();
    alert(`${productName} je dodan u košaricu!`);
    

    if (window.location.pathname.includes('/opg-tolic/kosarica.php')) {
        displayCartItems();
    }
}

function loadCartCount() {
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const totalCount = cartItems.reduce((total, item) => total + item.quantity, 0);
    const cartCountElements = document.querySelectorAll('#cart-count');
    
    cartCountElements.forEach(element => {
        element.textContent = totalCount;
    });
}

function displayCartItems() {
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    let cartItemsContainer = document.getElementById('cart-items-container');
    let cartTotalElement = document.getElementById('cart-total');
    let total = 0;

    if (cartItemsContainer) {
        cartItemsContainer.innerHTML = '';

        if (cartItems.length === 0) {
            cartItemsContainer.innerHTML = '<p>Vaša košarica je prazna.</p>';
            if (cartTotalElement) cartTotalElement.textContent = '0';
            return;
        }

        cartItems.forEach((item, index) => {
            total += item.price * item.quantity;
            cartItemsContainer.innerHTML += `
                <div class="cart-item">
                    <div class="cart-item-image-section">
                        <img src="img/${item.image}" alt="${item.name}" class="cart-item-image">
                    </div>
                    <div class="cart-item-name">
                        <span class="cart-item-label">Proizvod:</span>
                        <span class="cart-item-name-text">${item.name}</span>
                    </div>
                    <div class="cart-item-quantity">
                        <span class="cart-item-label">Količina:</span>
                        <div class="quantity-control">
                            <button onclick="changeQuantity(${index}, -1)">-</button>
                            <span class="quantity">${item.quantity}</span>
                            <button onclick="changeQuantity(${index}, 1)">+</button>
                        </div>
                    </div>
                    <div class="cart-item-price-section">
                        <span class="cart-item-label">Cijena:</span>
                        <span class="cart-item-price">${(item.price * item.quantity).toFixed(2)} €</span>
                    </div>
                    <div class="cart-item-remove">
                        <button class="remove-btn" onclick="removeItem(${index})">Ukloni</button>
                    </div>
                </div>
            `;
        });

        if (cartTotalElement) cartTotalElement.textContent = total.toFixed(2);
    }
}

function changeQuantity(index, change) {
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    
    if (cartItems[index]) {
        cartItems[index].quantity += change;
        
        if (cartItems[index].quantity <= 0) {
            cartItems.splice(index, 1);
        }
        
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateCartCount();
        displayCartItems();
    }
}

function removeItem(index) {
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    cartItems.splice(index, 1);
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    updateCartCount();
    displayCartItems();
}

function clearCart() {
    localStorage.removeItem('cartItems');
    updateCartCount();
    displayCartItems();
    alert('Košarica je ispražnjena');
}

function updateCartCount() {
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const totalCount = cartItems.reduce((total, item) => total + item.quantity, 0);
    const cartCountElements = document.querySelectorAll('#cart-count');
    
    cartCountElements.forEach(element => {
        element.textContent = totalCount;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    
    if (window.location.pathname.includes('/opg-tolic/kosarica.php')) {
        displayCartItems();
    }
});

window.addToCart = addToCart;
window.changeQuantity = changeQuantity;
window.removeItem = removeItem;
window.clearCart = clearCart;
window.updateCartCount = updateCartCount;
window.displayCartItems = displayCartItems;



// Funkcije za pretraživanje
function toggleSearch() {
    const searchContainer = document.getElementById('searchContainer');
    if (searchContainer.style.display === 'block') {
        searchContainer.style.display = 'none';
        const results = document.querySelector('.search-results');
        if (results) results.remove();
    } else {
        searchContainer.style.display = 'block';
        document.getElementById('searchInput').focus();
    }
}

function searchProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    const searchResultsContainer = document.createElement('div');
    searchResultsContainer.className = 'search-results';
    
    if (searchTerm === '') {
        const oldResults = document.querySelector('.search-results');
        if (oldResults) oldResults.remove();
        return;
    }

    const products = [];
    
    // Proizvodi na početnoj stranici
    const homeProducts = document.querySelectorAll('.product');
    homeProducts.forEach(p => products.push({
        element: p,
        name: p.getAttribute('data-name') || p.querySelector('h3').textContent,
        price: p.querySelector('.price').textContent,
        image: p.querySelector('img').src
    }));
    
    // Proizvodi na webshop stranici
    const shopProducts = document.querySelectorAll('.product-item');
    shopProducts.forEach(p => products.push({
        element: p,
        name: p.querySelector('h3').textContent,
        price: p.querySelector('.price').textContent,
        image: p.querySelector('img').src
    }));

    let hasResults = false;
    
    products.forEach(product => {
        const productName = product.name.toLowerCase();
        
        if (productName.includes(searchTerm)) {
            hasResults = true;
            
            const resultItem = document.createElement('div');
            resultItem.className = 'search-result-item';
            resultItem.innerHTML = `
                <img src="${product.image}" alt="${product.name}">
                <div>
                    <h3>${product.name}</h3>
                    <p>${product.price}</p>
                </div>
            `;
            
            resultItem.addEventListener('click', () => {
                if (product.element) {
                    product.element.scrollIntoView({ behavior: 'smooth' });
                    product.element.style.boxShadow = '0 0 0 3px gold';
                    setTimeout(() => {
                        product.element.style.boxShadow = 'none';
                    }, 2000);
                }
                
                searchResultsContainer.remove();
                document.getElementById('searchContainer').style.display = 'none';
            });
            
            searchResultsContainer.appendChild(resultItem);
        }
    });
    
    if (!hasResults) {
        searchResultsContainer.innerHTML = `
            <div class="no-results">
                Nema rezultata za "${searchTerm}".
                <p>Pokušajte s drugim pojmom ili pogledajte sve proizvode u <a href="webshop.php">webshopu</a></p>
            </div>
        `;
    }
    
    const oldResults = document.querySelector('.search-results');
    if (oldResults) oldResults.remove();
    
    const searchContainer = document.getElementById('searchContainer');
    searchContainer.appendChild(searchResultsContainer);
}

function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}
window.onload = function() {
    if (window.location.pathname.includes('kosarica.php')) {
        displayCartItems();
    }
    loadCartCount();
};


// Funkcije za upravljanje favoritima
function toggleFavorite(name, price, image) {
    let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    const index = favorites.findIndex(item => item.name === name);
    
    if (index === -1) {
        favorites.push({ name, price, image});
        alert(`${name} je dodan u favorite!`);
    } else {
 
        favorites.splice(index, 1);
        alert(`${name} je uklonjen iz favorita!`);
    }
    
    localStorage.setItem('favorites', JSON.stringify(favorites));
    updateFavoriteIcon(name);
    updateFavoriteCount();
}

function updateFavoriteIcon(name) {
    const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    const isFavorite = favorites.some(item => item.name === name);
    
    document.querySelectorAll(`[onclick="toggleFavorite('${name}']`).forEach(icon => {
        if (isFavorite) {
            icon.classList.add('active');
        } else {
            icon.classList.remove('active');
        }
    });
}

function updateFavoriteCount() {
    const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    const favoriteCountElement = document.getElementById('favorite-count');
    
    if (favoriteCountElement) {
        favoriteCountElement.textContent = favorites.length;
    }
}

function loadFavoritesPage() {
    const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    const favoritesContainer = document.getElementById('favorites-container');
    
    if (!favoritesContainer) return;
    
   if (favorites.length === 0) {
    favoritesContainer.innerHTML = `
        <div class="no-favorites">
            <p>Trenutno nemate proizvoda.</p>
        </div>
    `;
    return;
}

    
    favoritesContainer.innerHTML = favorites.map(item => `
        <div class="favorite-item">
            <img src="img/${item.image}" alt="${item.name}">
            <h3>${item.name}</h3>
            <div class="price">${item.price.toFixed(2)} €</div>
            <div class="favorite-actions">
                <button class="buy-bttn" onclick="addToCart('${item.name}', ${item.price}, '${item.image}')">Dodaj u košaricu</button>
                <img src="img/heartt.png" alt="Ukloni iz favorita" class="favorite-icon active" onclick="toggleFavorite('${item.name}', ${item.price}, '${item.image}')">
            </div>
        </div>
    `).join('');
}

document.addEventListener('DOMContentLoaded', () => {
    updateFavoriteCount();
    
    const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    favorites.forEach(item => {
        updateFavoriteIcon(item.name);
    });
    
    if (document.getElementById('favorites-container')) {
        loadFavoritesPage();
    }
    
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        const name = btn.getAttribute('data-name');
        const price = parseFloat(btn.getAttribute('data-price'));
        const image = btn.getAttribute('data-image');
        
        btn.addEventListener('click', () => {
            toggleFavorite(name, price, image);
        });
    });
});

function submitContactForm() {
    const formData = new FormData(document.getElementById('contact-form'));
    
    fetch('contact-form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        if (response.ok) {
            document.getElementById('contact-form').reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Došlo je do greške pri slanju poruke.');
    });
}


