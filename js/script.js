// JavaScript for Magadh Institute of Pharmacy Website

// Medicine Loader Control
window.addEventListener('load', function() {
    const loader = document.getElementById('medicineLoader');
    
    // Show loader for minimum 2 seconds for better UX
    setTimeout(function() {
        loader.classList.add('fade-out');
        
        // Remove loader from DOM after fade out
        setTimeout(function() {
            loader.style.display = 'none';
        }, 500);
    }, 2000);
});

// Enhanced Dropdown Hover Functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.navbar-nav .dropdown');
    
    dropdowns.forEach(dropdown => {
        const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        let hoverTimeout;
        
        // Show dropdown on hover with slight delay
        dropdown.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
            dropdownMenu.style.display = 'block';
            dropdownToggle.setAttribute('aria-expanded', 'true');
            dropdown.classList.add('show');
            dropdownMenu.classList.add('show');
        });
        
        // Hide dropdown when leaving with delay for smooth transition
        dropdown.addEventListener('mouseleave', function() {
            hoverTimeout = setTimeout(function() {
                dropdownMenu.style.display = 'none';
                dropdownToggle.setAttribute('aria-expanded', 'false');
                dropdown.classList.remove('show');
                dropdownMenu.classList.remove('show');
            }, 100); // 100ms delay to allow smooth transition
        });
        
        // Also handle click events for mobile
        dropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = dropdownToggle.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                dropdownMenu.style.display = 'none';
                dropdownToggle.setAttribute('aria-expanded', 'false');
                dropdown.classList.remove('show');
                dropdownMenu.classList.remove('show');
            } else {
                // Close other dropdowns first
                dropdowns.forEach(otherDropdown => {
                    if (otherDropdown !== dropdown) {
                        const otherMenu = otherDropdown.querySelector('.dropdown-menu');
                        const otherToggle = otherDropdown.querySelector('.dropdown-toggle');
                        otherMenu.style.display = 'none';
                        otherToggle.setAttribute('aria-expanded', 'false');
                        otherDropdown.classList.remove('show');
                        otherMenu.classList.remove('show');
                    }
                });
                
                dropdownMenu.style.display = 'block';
                dropdownToggle.setAttribute('aria-expanded', 'true');
                dropdown.classList.add('show');
                dropdownMenu.classList.add('show');
            }
        });
        
        // Handle dropdown item clicks
        const dropdownItems = dropdown.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                // Close dropdown after item click
                setTimeout(function() {
                    dropdownMenu.style.display = 'none';
                    dropdownToggle.setAttribute('aria-expanded', 'false');
                    dropdown.classList.remove('show');
                    dropdownMenu.classList.remove('show');
                }, 150);
            });
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            dropdowns.forEach(dropdown => {
                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                dropdownMenu.style.display = 'none';
                dropdownToggle.setAttribute('aria-expanded', 'false');
                dropdown.classList.remove('show');
                dropdownMenu.classList.remove('show');
            });
        }
    });
});

// JavaScript for Magadh Institute of Pharmacy Website

// Medicine Loader Control
window.addEventListener('load', function() {
    const loader = document.getElementById('medicineLoader');
    
    // Initialize typewriter effect
    initTypewriter();
    
    // Show loader for minimum 4 seconds to allow typewriter animation to complete
    setTimeout(function() {
        loader.classList.add('fade-out');
        
        // Remove loader from DOM after fade out
        setTimeout(function() {
            loader.style.display = 'none';
        }, 500);
    }, 4000);
});

// Typewriter Effect Function
function initTypewriter() {
    const text = "Loading Excellence in Pharmaceutical Education";
    const typewriterElement = document.getElementById('typewriterText');
    const cursor = document.querySelector('.typewriter-cursor');
    
    if (typewriterElement) {
        // Clear the text initially
        typewriterElement.textContent = '';
        
        // Add typing effect with realistic timing
        let index = 0;
        const typingSpeed = 80; // milliseconds per character
        
        function typeCharacter() {
            if (index < text.length) {
                typewriterElement.textContent += text.charAt(index);
                index++;
                setTimeout(typeCharacter, typingSpeed);
            } else {
                // After typing is complete, make cursor blink continuously
                if (cursor) {
                    cursor.style.animation = 'blink 1s infinite';
                }
            }
        }
        
        // Start typing after a short delay
        setTimeout(typeCharacter, 800);
    }
}

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });
    
    // Disable AOS on hero section elements to prevent displacement
    const heroElements = document.querySelectorAll('.hero-slider [data-aos], #heroCarousel [data-aos], .carousel-inner [data-aos], .carousel-item [data-aos], .hero-slide [data-aos]');
    heroElements.forEach(element => {
        element.removeAttribute('data-aos');
        element.removeAttribute('data-aos-delay');
        element.removeAttribute('data-aos-duration');
        element.style.transform = 'none';
        element.style.opacity = '1';
        element.style.transition = 'none';
    });

    // Initialize all functionalities
    initNavigation();
    initHeroSlider();
    initUniversityCarousel();
    initDropdownMenus();
    initBackToTop();
    initLoadingScreen();
    initSmoothScrolling();
    initFormValidation();
    initCounterAnimation();
    initParallaxEffect();
    initImageLazyLoading();
    initTypingAnimation();
    initMouseFollower();
    initScrollProgressBar();
});

// Navigation Functionality
function initNavigation() {
    const navbar = document.querySelector('.main-navbar');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
            navbar.style.background = 'rgba(139, 69, 19, 0.95)';
            navbar.style.backdropFilter = 'blur(10px)';
        } else {
            navbar.classList.remove('scrolled');
            navbar.style.background = 'linear-gradient(135deg, #8B4513, #DAA520)';
            navbar.style.backdropFilter = 'none';
        }
    });

    // Active link highlighting
    window.addEventListener('scroll', function() {
        let current = '';
        const sections = document.querySelectorAll('section[id]');
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (scrollY >= (sectionTop - 200)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    });

    // Mobile menu close on link click
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse.classList.contains('show')) {
                bootstrap.Collapse.getInstance(navbarCollapse).hide();
            }
        });
    });
}

// Dropdown Menu Enhancements
function initDropdownMenus() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        const dropdown = new bootstrap.Dropdown(toggle);
        
        // Add hover effect for desktop
        if (window.innerWidth > 991) {
            const dropdownMenu = toggle.nextElementSibling;
            
            toggle.addEventListener('mouseenter', function() {
                dropdown.show();
            });
            
            toggle.parentElement.addEventListener('mouseleave', function() {
                dropdown.hide();
            });
            
            // Prevent dropdown from closing when hovering over menu
            if (dropdownMenu) {
                dropdownMenu.addEventListener('mouseenter', function() {
                    dropdown.show();
                });
                
                dropdownMenu.addEventListener('mouseleave', function() {
                    dropdown.hide();
                });
            }
        }
        
        // Smooth scroll for dropdown links
        const dropdownItems = toggle.parentElement.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href.startsWith('#')) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                    dropdown.hide();
                }
            });
        });
    });
}

// University Carousel Enhancements
function initUniversityCarousel() {
    const universityCarousel = document.querySelector('#universityCarousel');
    if (universityCarousel) {
        // Initialize Bootstrap carousel with custom options
        const carousel = new bootstrap.Carousel(universityCarousel, {
            interval: 3000,
            wrap: true,
            touch: true
        });
        
        // Add smooth transitions for text elements
        universityCarousel.addEventListener('slide.bs.carousel', function(e) {
            const activeSlide = e.relatedTarget;
            const textElement = activeSlide.querySelector('p');
            
            if (textElement) {
                // Reset animation
                textElement.style.opacity = '0';
                textElement.style.transform = 'translateY(20px)';
                
                // Trigger animation after slide transition
                setTimeout(() => {
                    textElement.style.transition = 'all 0.6s ease';
                    textElement.style.opacity = '1';
                    textElement.style.transform = 'translateY(0)';
                }, 300);
            }
        });
        
        // Pause on hover
        universityCarousel.addEventListener('mouseenter', function() {
            carousel.pause();
        });
        
        universityCarousel.addEventListener('mouseleave', function() {
            carousel.cycle();
        });
        
        // Add smooth scrolling prevention for the header section
        const header = document.querySelector('.main-header');
        if (header) {
            header.style.scrollBehavior = 'auto';
        }
    }
}

// Hero Slider Enhancements
function initHeroSlider() {
    const heroCarousel = document.querySelector('#heroCarousel');
    if (heroCarousel) {
        // Ensure no unwanted transforms on carousel items
        const carouselItems = heroCarousel.querySelectorAll('.carousel-item');
        const heroSlides = heroCarousel.querySelectorAll('.hero-slide');
        
        // Remove any transforms that might cause displacement
        carouselItems.forEach(item => {
            item.style.transform = 'none';
            item.style.margin = '0';
            item.style.padding = '0';
        });
        
        heroSlides.forEach(slide => {
            slide.style.transform = 'none';
            slide.style.margin = '0';
            slide.style.padding = '0';
        });
        
        // Add custom controls
        heroCarousel.addEventListener('slide.bs.carousel', function(e) {
            const activeSlide = e.relatedTarget;
            const content = activeSlide.querySelector('.hero-content');
            
            // Animate content only, not the slide itself
            if (content) {
                content.style.opacity = '0';
                content.style.transform = 'translateY(50px)';
                
                setTimeout(() => {
                    content.style.transition = 'all 0.8s ease';
                    content.style.opacity = '1';
                    content.style.transform = 'translateY(0)';
                }, 300);
            }
        });

        // Auto-play pause on hover
        heroCarousel.addEventListener('mouseenter', function() {
            bootstrap.Carousel.getInstance(heroCarousel).pause();
        });

        heroCarousel.addEventListener('mouseleave', function() {
            bootstrap.Carousel.getInstance(heroCarousel).cycle();
        });
        
        // Fix any Bootstrap carousel transforms
        heroCarousel.addEventListener('slid.bs.carousel', function() {
            carouselItems.forEach(item => {
                item.style.transform = 'none';
            });
            heroSlides.forEach(slide => {
                slide.style.transform = 'none';
            });
        });
    }
}

// Back to Top Button
function initBackToTop() {
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });

    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Loading Screen
function initLoadingScreen() {
    const loadingScreen = document.createElement('div');
    loadingScreen.className = 'loading';
    loadingScreen.innerHTML = '<div class="loading-spinner"></div>';
    document.body.appendChild(loadingScreen);

    window.addEventListener('load', function() {
        setTimeout(() => {
            loadingScreen.style.opacity = '0';
            setTimeout(() => {
                loadingScreen.remove();
            }, 500);
        }, 1000);
    });
}

// Smooth Scrolling for Anchor Links
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.offsetTop;
                const offsetPosition = elementPosition - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Form Validation and Enhancement
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate all fields
            const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
            let isFormValid = true;
            
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isFormValid = false;
                }
            });
            
            if (!isFormValid) {
                showNotification('Please fill all required fields correctly.', 'error');
                return;
            }
            
            // Add loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;

            // Simulate form submission
            setTimeout(() => {
                // Show success message
                showNotification('Message sent successfully!', 'success');
                form.reset();
                // Remove validation classes
                inputs.forEach(input => {
                    input.classList.remove('is-valid', 'is-invalid');
                });
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });

        // Real-time validation
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });
    });
}

// Field Validation
function validateField(field) {
    const value = field.value.trim();
    const type = field.type;
    let isValid = true;
    let message = '';

    // Required field check
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        message = 'This field is required';
    }

    // Email validation
    if (type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            message = 'Please enter a valid email address';
        }
    }

    // Phone validation
    if (type === 'tel' && value) {
        const phoneRegex = /^[\+]?[0-9]{10,15}$/;
        if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
            isValid = false;
            message = 'Please enter a valid phone number';
        }
    }

    // Name validation
    if (field.name === 'name' || field.placeholder?.toLowerCase().includes('name')) {
        if (value && value.length < 2) {
            isValid = false;
            message = 'Name must be at least 2 characters long';
        }
    }

    // Update field appearance
    if (isValid) {
        field.classList.remove('is-invalid');
        if (value) {
            field.classList.add('is-valid');
        }
    } else {
        field.classList.remove('is-valid');
        field.classList.add('is-invalid');
    }

    // Show/hide error message
    let errorDiv = field.parentNode.querySelector('.invalid-feedback');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.style.display = 'block';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.style.color = '#dc3545';
        errorDiv.style.marginTop = '0.25rem';
        field.parentNode.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
    
    return isValid;
}

// Counter Animation for Statistics
function initCounterAnimation() {
    const counters = document.querySelectorAll('.info-card h3');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.textContent.replace(/\D/g, ''));
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current) + (counter.textContent.includes('+') ? '+' : '') + 
                                    (counter.textContent.includes('%') ? '%' : '');
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target + (counter.textContent.includes('+') ? '+' : '') + 
                                    (counter.textContent.includes('%') ? '%' : '');
            }
        };
        
        updateCounter();
    };

    // Intersection Observer for counter animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    });

    counters.forEach(counter => {
        observer.observe(counter);
    });
}

// Parallax Effect (Disabled to fix gaps)
function initParallaxEffect() {
    // Parallax effect disabled to prevent slider displacement issues
    // If you want to re-enable, uncomment the code below
    /*
    const parallaxElements = document.querySelectorAll('.hero-slide');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const heroHeight = document.querySelector('.hero-slider').offsetHeight;
        
        if (scrolled < heroHeight) {
            const rate = scrolled * 0.1; // Reduced rate
            
            parallaxElements.forEach(element => {
                element.style.transform = `translateY(${rate}px)`;
            });
        }
    });
    */
}

// Lazy Loading for Images
function initImageLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
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

// Typing Animation for Hero Text
function initTypingAnimation() {
    const typingElements = document.querySelectorAll('.hero-title');
    
    typingElements.forEach(element => {
        const text = element.textContent;
        element.textContent = '';
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    typeText(element, text, 100);
                    observer.unobserve(element);
                }
            });
        });
        
        observer.observe(element);
    });
}

function typeText(element, text, speed) {
    let i = 0;
    const timer = setInterval(() => {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
        } else {
            clearInterval(timer);
        }
    }, speed);
}

// Mouse Follower Effect
function initMouseFollower() {
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    cursor.style.cssText = `
        position: fixed;
        width: 20px;
        height: 20px;
        background: linear-gradient(45deg, #8B4513, #DAA520);
        border-radius: 50%;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.1s ease;
        opacity: 0;
    `;
    document.body.appendChild(cursor);

    document.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX - 10 + 'px';
        cursor.style.top = e.clientY - 10 + 'px';
        cursor.style.opacity = '1';
    });

    document.addEventListener('mouseleave', () => {
        cursor.style.opacity = '0';
    });

    // Cursor effects on interactive elements
    const interactiveElements = document.querySelectorAll('a, button, .course-card, .gallery-item');
    interactiveElements.forEach(element => {
        element.addEventListener('mouseenter', () => {
            cursor.style.transform = 'scale(1.5)';
            cursor.style.background = 'linear-gradient(45deg, #DC143C, #8B4513)';
        });

        element.addEventListener('mouseleave', () => {
            cursor.style.transform = 'scale(1)';
            cursor.style.background = 'linear-gradient(45deg, #8B4513, #DAA520)';
        });
    });
}

// Scroll Progress Bar
function initScrollProgressBar() {
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, #8B4513, #DAA520);
        z-index: 9999;
        transition: width 0.3s ease;
    `;
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + '%';
    });
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
        color: white;
        border-radius: 5px;
        z-index: 10000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Course Card Interactions
document.addEventListener('DOMContentLoaded', function() {
    const courseCards = document.querySelectorAll('.course-card');
    
    courseCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) rotateY(5deg)';
            this.style.boxShadow = '0 25px 50px rgba(0,0,0,0.2)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotateY(0deg)';
            this.style.boxShadow = '0 15px 35px rgba(0,0,0,0.1)';
        });
    });
});

// Gallery Lightbox Effect
document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item img');
    
    galleryItems.forEach(img => {
        img.addEventListener('click', function() {
            createLightbox(this.src, this.alt);
        });
    });
});

function createLightbox(src, alt) {
    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        opacity: 0;
        transition: opacity 0.3s ease;
    `;

    const img = document.createElement('img');
    img.src = src;
    img.alt = alt;
    img.style.cssText = `
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    `;

    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '&times;';
    closeBtn.style.cssText = `
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s ease;
    `;

    closeBtn.addEventListener('mouseenter', () => {
        closeBtn.style.background = 'rgba(255,255,255,0.2)';
    });

    closeBtn.addEventListener('mouseleave', () => {
        closeBtn.style.background = 'none';
    });

    lightbox.appendChild(img);
    lightbox.appendChild(closeBtn);
    document.body.appendChild(lightbox);

    setTimeout(() => {
        lightbox.style.opacity = '1';
    }, 10);

    const closeLightbox = () => {
        lightbox.style.opacity = '0';
        setTimeout(() => {
            lightbox.remove();
        }, 300);
    };

    closeBtn.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
}

// Interactive News Ticker
document.addEventListener('DOMContentLoaded', function() {
    const newsItems = document.querySelectorAll('.news-item');
    
    newsItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.2}s`;
        item.classList.add('fade-in-up');
    });
});

// Testimonial Auto-rotation
document.addEventListener('DOMContentLoaded', function() {
    const testimonialCarousel = document.querySelector('#testimonialCarousel');
    if (testimonialCarousel) {
        const carousel = new bootstrap.Carousel(testimonialCarousel, {
            interval: 5000,
            wrap: true
        });
    }
});

// Search Functionality (if needed)
function initSearch() {
    const searchInput = document.querySelector('#searchInput');
    const searchBtn = document.querySelector('#searchBtn');
    
    if (searchInput && searchBtn) {
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
}

function performSearch() {
    const query = document.querySelector('#searchInput').value.toLowerCase();
    const sections = document.querySelectorAll('section[id]');
    
    sections.forEach(section => {
        const content = section.textContent.toLowerCase();
        if (content.includes(query)) {
            section.scrollIntoView({ behavior: 'smooth' });
            highlightSearchTerm(section, query);
            return;
        }
    });
}

function highlightSearchTerm(element, term) {
    // Simple highlight implementation
    const walker = document.createTreeWalker(
        element,
        NodeFilter.SHOW_TEXT,
        null,
        false
    );

    const textNodes = [];
    let node;
    while (node = walker.nextNode()) {
        textNodes.push(node);
    }

    textNodes.forEach(textNode => {
        const content = textNode.textContent;
        const regex = new RegExp(`(${term})`, 'gi');
        if (regex.test(content)) {
            const highlightedContent = content.replace(regex, '<mark>$1</mark>');
            const span = document.createElement('span');
            span.innerHTML = highlightedContent;
            textNode.parentNode.replaceChild(span, textNode);
            
            setTimeout(() => {
                span.outerHTML = span.innerHTML;
            }, 3000);
        }
    });
}

// Add CSS for animations
const additionalStyles = `
    .fade-in-up {
        animation: fadeInUp 0.8s ease forwards;
    }
    
    .custom-cursor {
        mix-blend-mode: difference;
    }
    
    .notification {
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
    }
    
    .lightbox {
        backdrop-filter: blur(5px);
    }
    
    mark {
        background: linear-gradient(90deg, #DAA520, #8B4513);
        color: white;
        padding: 2px 4px;
        border-radius: 3px;
    }
    
    @media (max-width: 768px) {
        .custom-cursor {
            display: none;
        }
    }
`;

// Inject additional styles
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);

// Performance optimization
window.addEventListener('load', function() {
    // Remove unused CSS
    const unusedElements = document.querySelectorAll('.d-none, [style*="display: none"]');
    unusedElements.forEach(el => {
        if (!el.classList.contains('carousel-item')) {
            el.remove();
        }
    });
});

// Error handling
window.addEventListener('error', function(e) {
    console.warn('Non-critical error caught:', e.error);
});

// Touch device optimizations
if ('ontouchstart' in window) {
    document.body.classList.add('touch-device');
    
    // Disable hover effects on touch devices
    const style = document.createElement('style');
    style.textContent = `
        .touch-device .course-card:hover,
        .touch-device .gallery-item:hover,
        .touch-device .info-card:hover {
            transform: none !important;
        }
    `;
    document.head.appendChild(style);
}

// Initialize search if elements exist
document.addEventListener('DOMContentLoaded', initSearch);

// Mobile Sidebar Menu Functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const mobileCloseBtn = document.getElementById('mobileCloseBtn');
    const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
    const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
    
    // Function to open mobile sidebar
    function openMobileSidebar() {
        mobileSidebar.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
    
    // Function to close mobile sidebar
    function closeMobileSidebar() {
        mobileSidebar.classList.remove('active');
        document.body.style.overflow = ''; // Restore background scrolling
        
        // Close all open dropdowns
        const activeDropdowns = document.querySelectorAll('.mobile-dropdown.active');
        activeDropdowns.forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    }
    
    // Event listeners
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (mobileSidebar.classList.contains('active')) {
                closeMobileSidebar();
            } else {
                openMobileSidebar();
            }
        });
    }
    
    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            closeMobileSidebar();
        });
    }
    
    if (mobileSidebarOverlay) {
        mobileSidebarOverlay.addEventListener('click', function() {
            closeMobileSidebar();
        });
    }
    
    // Handle dropdown toggles in mobile menu
    mobileDropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const targetSubmenu = document.getElementById(targetId);
            const parentDropdown = this.closest('.mobile-dropdown');
            
            if (parentDropdown && targetSubmenu) {
                const isActive = parentDropdown.classList.contains('active');
                
                // Close all other dropdowns
                const allDropdowns = document.querySelectorAll('.mobile-dropdown');
                allDropdowns.forEach(dropdown => {
                    if (dropdown !== parentDropdown) {
                        dropdown.classList.remove('active');
                    }
                });
                
                // Toggle current dropdown
                if (isActive) {
                    parentDropdown.classList.remove('active');
                } else {
                    parentDropdown.classList.add('active');
                }
            }
        });
    });
    
    // Close mobile sidebar when clicking on regular nav links
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link:not(.mobile-dropdown-toggle), .mobile-submenu a');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Add a small delay to allow navigation to complete
            setTimeout(() => {
                closeMobileSidebar();
            }, 100);
        });
    });
    
    // Close mobile sidebar on window resize if desktop size
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            closeMobileSidebar();
        }
    });
    
    // Handle escape key to close mobile sidebar
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileSidebar.classList.contains('active')) {
            closeMobileSidebar();
        }
    });
});

console.log('Magadh Institute of Pharmacy website loaded successfully! 🎓');