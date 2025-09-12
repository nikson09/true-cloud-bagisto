// True Cloud Theme JavaScript

// Helpers
const byId = (id) => document.getElementById(id);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    // Year in footer
    const yearElement = byId('year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }

    // Age Gate logic
    initializeAgeGate();
    
    // Mobile menu toggle
    initializeMobileMenu();
    
    // Cart functionality
    initializeCart();
    
    // Search functionality
    initializeSearch();
    
    // Smooth scrolling
    initializeSmoothScrolling();
    
    // Lazy loading
    initializeLazyLoading();
}

// Age Gate functionality
function initializeAgeGate() {
    const ageGate = byId('ageGate');
    const businessTypeGate = byId('businessTypeGate');
    const needsAge = !localStorage.getItem('ageConfirmed');
    const needsBusinessType = !localStorage.getItem('businessTypeConfirmed');
    
    if (needsAge) {
        ageGate.classList.remove('hidden');
    } else if (needsBusinessType) {
        businessTypeGate.classList.remove('hidden');
    }
    
    // Age confirmation
    const ageYesBtn = byId('ageYes');
    const ageNoBtn = byId('ageNo');
    
    if (ageYesBtn) {
        ageYesBtn.addEventListener('click', () => {
            localStorage.setItem('ageConfirmed', '1');
            ageGate.classList.add('hidden');
            if (needsBusinessType) {
                businessTypeGate.classList.remove('hidden');
            }
        });
    }
    
    if (ageNoBtn) {
        ageNoBtn.addEventListener('click', () => {
            window.location.href = 'https://google.com.ua';
        });
    }
    
    // Business Type Gate logic
    const businessYesBtn = byId('businessYes');
    const businessNoBtn = byId('businessNo');
    
    if (businessYesBtn) {
        businessYesBtn.addEventListener('click', () => {
            localStorage.setItem('businessTypeConfirmed', 'business');
            businessTypeGate.classList.add('hidden');
        });
    }
    
    if (businessNoBtn) {
        businessNoBtn.addEventListener('click', () => {
            localStorage.setItem('businessTypeConfirmed', 'personal');
            businessTypeGate.classList.add('hidden');
        });
    }
}

// Mobile menu functionality
function initializeMobileMenu() {
    const mobileMenuBtn = byId('mobileMenuBtn');
    const mobileMenu = byId('mobileMenu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }
}

// Cart functionality
function initializeCart() {
    // Update cart count from Bagisto
    updateCartCount();
    
    // Add to cart functionality
    window.addToCart = function(productId, quantity = 1) {
        // This would integrate with Bagisto's cart system
        fetch('/shop/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount();
                showNotification('Товар додано до кошика');
                animateCartIcon();
            }
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
        });
    };
}

function updateCartCount() {
    // This would fetch the actual cart count from Bagisto
    const cartCount = byId('cartCount');
    if (cartCount) {
        // For now, we'll use a placeholder
        // In real implementation, this would be fetched from the server
        fetch('/shop/cart/count')
            .then(response => response.json())
            .then(data => {
                cartCount.textContent = data.count || 0;
            })
            .catch(error => {
                console.error('Error fetching cart count:', error);
            });
    }
}

function animateCartIcon() {
    const cartCount = byId('cartCount');
    if (cartCount) {
        cartCount.classList.add('animate-ping');
        setTimeout(() => cartCount.classList.remove('animate-ping'), 300);
    }
}

// Search functionality
function initializeSearch() {
    const searchInput = byId('searchInput');
    const searchBtn = byId('searchBtn');
    
    if (searchInput && searchBtn) {
        // Search on button click
        searchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            performSearch(searchInput.value);
        });
        
        // Search on Enter key
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch(searchInput.value);
            }
        });
        
        // Auto-suggest functionality (optional)
        searchInput.addEventListener('input', debounce((e) => {
            const query = e.target.value;
            if (query.length > 2) {
                // Implement auto-suggest here
                console.log('Auto-suggest for:', query);
            }
        }, 300));
    }
}

function performSearch(query) {
    if (!query.trim()) return;
    
    // Redirect to search results page
    window.location.href = `/shop/search?query=${encodeURIComponent(query)}`;
}

// Smooth scrolling for anchor links
function initializeSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Lazy loading for images
function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    if (images.length === 0) return;
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Show notification
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    
    // Add type-specific styling
    if (type === 'error') {
        notification.style.background = '#ef4444';
    } else if (type === 'warning') {
        notification.style.background = '#f59e0b';
    }
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Wishlist functionality
function toggleWishlist(productId) {
    fetch('/shop/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message);
            // Update wishlist icon state
            updateWishlistIcon(productId, data.in_wishlist);
        }
    })
    .catch(error => {
        console.error('Error toggling wishlist:', error);
    });
}

function updateWishlistIcon(productId, inWishlist) {
    const wishlistBtn = document.querySelector(`[data-product-id="${productId}"] .wishlist-btn`);
    if (wishlistBtn) {
        if (inWishlist) {
            wishlistBtn.classList.add('wishlisted');
        } else {
            wishlistBtn.classList.remove('wishlisted');
        }
    }
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Scroll effects
function initializeScrollEffects() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.category-card, .product-card, .feature-item');
    animateElements.forEach(el => observer.observe(el));
}

// Initialize scroll effects
document.addEventListener('DOMContentLoaded', function() {
    initializeScrollEffects();
});

// Export for use in other modules
window.TrueCloud = {
    addToCart,
    toggleWishlist,
    performSearch,
    showNotification,
    debounce,
    throttle
};

// Handle form submissions
document.addEventListener('submit', function(e) {
    const form = e.target;
    if (form.classList.contains('ajax-form')) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const url = form.action;
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            showNotification('Помилка при відправці форми', 'error');
        });
    }
});

// Handle dynamic content loading
function loadMoreProducts(page = 1) {
    const container = document.querySelector('.products-container');
    if (!container) return;
    
    fetch(`/shop/products/load-more?page=${page}`)
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                container.insertAdjacentHTML('beforeend', data.html);
                // Re-initialize lazy loading for new images
                initializeLazyLoading();
            }
        })
        .catch(error => {
            console.error('Error loading more products:', error);
        });
}

// Initialize product filters
function initializeProductFilters() {
    const filterForm = document.querySelector('.product-filters');
    if (!filterForm) return;
    
    const filterInputs = filterForm.querySelectorAll('input, select');
    filterInputs.forEach(input => {
        input.addEventListener('change', debounce(() => {
            filterForm.submit();
        }, 500));
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeProductFilters();
});
