// Fetch API logic for Homepage popup modal image (#imagePopup)

document.addEventListener('DOMContentLoaded', function () {
    console.log('Fetching popup modal image...');

    const popupImg = document.querySelector('#imagePopup .popup-image img');
    if (!popupImg) {
        console.warn('Popup image element not found (#imagePopup .popup-image img)');
        return;
    }

    fetch('/mip310/control-dashboard/api/popup-model-end.php')
        .then(response => {
            console.log('Pop-Up API Response status:', response.status);
            if (!response.ok) {
                throw new Error('Pop-Up API error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Popup modal data received:', data);

            if (data.success && data.data && data.data.length > 0) {
                // Use first (latest) image for the popup modal
                const image = data.data[0];
                popupImg.src = image.image_url;
                popupImg.alt = image.name || 'Popup';
                console.log('Popup modal image set:', image.image_url);
            } else {
                console.warn('No popup images found, keeping default image:', data);
            }
        })
        .catch(error => {
            console.error('Error loading popup modal image:', error);
            // Keep default/static image on error
        });
});


// ==========================================

// Fetch sliders from API
document.addEventListener('DOMContentLoaded', function () {
    console.log('Page loaded, fetching data...');

    // Fetch Sliders
    fetch('/mip310/control-dashboard/api/sliders.php')
        .then(response => {
            console.log('Sliders API Response status:', response.status);
            if (!response.ok) {
                throw new Error('Sliders - Network response was not ok: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Slider data received:', data);
            if (data.success && data.data && data.data.length > 0) {
                const carouselContent = document.getElementById('carouselContent');
                if (!carouselContent) {
                    console.error('Carousel container not found');
                    return;
                }
                carouselContent.innerHTML = '';

                data.data.forEach((slider, index) => {
                    const isActive = index === 0 ? 'active' : '';
                    const slideHTML = `
                            <div class="carousel-item ${isActive}">
                                <img src="${slider.image_url}" class="d-block w-100 hero-slide-img" alt="Slide ${index + 1}" style="height: 80vh; object-fit: cover;">
                            </div>
                        `;
                    console.log('Adding slide:', index, 'Image URL:', slider.image_url);
                    carouselContent.innerHTML += slideHTML;
                });

                const heroCarousel = document.getElementById('heroCarousel');
                const carousel = new bootstrap.Carousel(heroCarousel, {
                    interval: 5000,
                    wrap: true
                });
                console.log('Sliders loaded and carousel initialized');
            } else {
                console.warn('No slider data:', data);
            }
        })
        .catch(error => console.error('Error loading sliders:', error));



    // ==========================

    // Fetch Announcements/News
    fetch('/mip310/control-dashboard/api/announcements.php')
        .then(response => {
            if (!response.ok) throw new Error('News API error: ' + response.status);
            return response.json();
        })
        .then(data => {
            console.log('Announcements received:', data);
            if (data.success && data.data && data.data.length > 0) {
                const newsCarousel = document.getElementById('newsCarousel');
                newsCarousel.innerHTML = '';

                data.data.forEach(item => {
                    const newsHTML = `
                        <div class="news-item">
                            <div class="news-date">
                                <span class="day">${item.day}</span>
                                <span class="month">${item.month}</span>
                            </div>
                            <div class="news-content">
                                <h4>${item.title}</h4>
                                <p>${item.content}... <a href="information.html">Read More</a></p>
                            </div>
                        </div>
                    `;
                    newsCarousel.innerHTML += newsHTML;
                });
                /* Duplicate only when content overflows, so short lists don't show twice */
                const newsWrap = newsCarousel.closest('.marquee-y-wrap');
                const newsInner = newsCarousel.parentElement;
                if (newsWrap && newsInner) {
                    const wrapHeight = newsWrap.clientHeight;
                    const contentHeight = newsCarousel.scrollHeight;
                    if (contentHeight > wrapHeight) {
                        const newsClone = newsCarousel.cloneNode(true);
                        newsClone.id = '';
                        newsClone.setAttribute('aria-hidden', 'true');
                        newsInner.appendChild(newsClone);
                        newsWrap.setAttribute('data-marquee-active', 'true');
                    }
                }
                console.log('Announcements loaded successfully');
            }
        })
        .catch(error => console.error('Error loading announcements:', error));

    // =========================

    // Fetch Notices
    fetch('/mip310/control-dashboard/api/notices.php')
        .then(response => {
            if (!response.ok) throw new Error('Notices API error: ' + response.status);
            return response.json();
        })
        .then(data => {
            console.log('Notices received:', data);
            if (data.success && data.data && data.data.length > 0) {
                const noticeBoard = document.getElementById('noticeBoard');
                noticeBoard.innerHTML = '';

                data.data.forEach(item => {
                    const noticeHTML = `
                        <div class="notice-item">
                            <i class="fas fa-bullhorn"></i>
                            <p>${item.title} <a href="information.html">Read More</a></p>
                            <small>${item.day}&nbsp;${item.month}</small>
                        </div>
                    `;
                    noticeBoard.innerHTML += noticeHTML;
                });
                /* Duplicate only when content overflows, so short lists don't show twice */
                const noticeWrap = noticeBoard.closest('.marquee-y-wrap');
                const noticeInner = noticeBoard.parentElement;
                if (noticeWrap && noticeInner) {
                    const wrapHeight = noticeWrap.clientHeight;
                    const contentHeight = noticeBoard.scrollHeight;
                    if (contentHeight > wrapHeight) {
                        const noticeClone = noticeBoard.cloneNode(true);
                        noticeClone.id = '';
                        noticeClone.setAttribute('aria-hidden', 'true');
                        noticeInner.appendChild(noticeClone);
                        noticeWrap.setAttribute('data-marquee-active', 'true');
                    }
                }
                console.log('Notices loaded successfully');
            }
        })
        .catch(error => console.error('Error loading notices:', error));
});




// ==========================================

// Inquiry form submission logic (if applicable)

document.querySelector('.consultation-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = {
        name: formData.get('name') || document.querySelector('input[placeholder="Your Name"]').value,
        email: formData.get('email') || document.querySelector('input[placeholder="Email Address"]').value,
        phone: formData.get('phone') || document.querySelector('input[placeholder="Phone Number"]').value,
        course: formData.get('course') || document.querySelector('select').value,
        message: formData.get('message') || document.querySelector('textarea').value
    };

    fetch('control-dashboard/api/save-inquiry.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Thank you! Your inquiry has been submitted successfully.');
                document.querySelector('.consultation-form').reset();
            } else {
                alert('Error: ' + result.message);
            }
        })
        .catch(error => console.error('Error:', error));
});


// ==========================================

// Fetch gallery images from API
document.addEventListener('DOMContentLoaded', function () {
    console.log('Fetching gallery images...');

    // Fetch Gallery Images
    fetch('/mip310/control-dashboard/api/gallery.php')
        .then(response => {
            console.log('Gallery API Response status:', response.status);
            if (!response.ok) {
                throw new Error('Gallery API error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Gallery data received:', data);
            const galleryGrid = document.querySelector('.gallery-grid');

            // Clear loading spinner
            galleryGrid.innerHTML = '';

            if (data.success && data.data && data.data.length > 0) {
                // Add images from database
                data.data.forEach((image, index) => {
                    const delay = (index % 6) * 100 + 100; // Stagger animations
                    const imageHTML = `
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="${delay}">
                        <div class="gallery-item" data-bs-toggle="modal" data-img="${image.image_url}" data-title="${image.name}" data-caption="${image.description || ''}">
                            <img src="${image.image_url}" alt="${image.name}" class="img-fluid">
                            <div class="gallery-overlay">
                                <h4>${image.name}</h4>
                                <p>${image.description || 'View Image'}</p>
                            </div>
                        </div>
                    </div>
                `;
                    galleryGrid.innerHTML += imageHTML;
                });

                // Re-initialize lightbox modal logic for dynamically loaded images
                initializeLightbox();

                console.log('Gallery images loaded successfully');
            } else {
                // No images found in database
                galleryGrid.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-images fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Gallery Images Available</h4>
                        <p class="text-muted">Images will be displayed here once they are added to the gallery.</p>
                    </div>
                `;
                console.warn('No gallery images found:', data);
            }
        })
        .catch(error => {
            console.error('Error loading gallery images:', error);
            const galleryGrid = document.querySelector('.gallery-grid');
            galleryGrid.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                    <h4 class="text-danger">Error Loading Gallery</h4>
                    <p class="text-muted">Unable to load gallery images. Please try again later.</p>
                </div>
            `;
        });
});

