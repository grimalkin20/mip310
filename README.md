# Magadh Institute of Pharmacy Website

A modern, responsive website for Magadh Institute of Pharmacy featuring beautiful animations, interactive elements, and a professional design.

## Features

### Design & Animation
- **Beautiful Color Scheme**: Custom color palette avoiding blue colors as requested
- **Scroll Animations**: AOS (Animate On Scroll) library integration
- **Interactive Elements**: Hover effects, transitions, and micro-animations
- **Responsive Design**: Fully responsive across all devices
- **Modern Typography**: High-quality fonts (Poppins & Playfair Display)

### Navigation & Layout
- **Sticky Navigation**: Fixed navigation bar with scroll effects
- **Smooth Scrolling**: Smooth transitions between sections
- **Back to Top Button**: Animated scroll-to-top functionality
- **Mobile-Friendly Menu**: Collapsible navigation for mobile devices

### Sections & Content
1. **Top Bar**: Contact information, social links, and welcome marquee
2. **Header**: Logo, university carousel, and action buttons
3. **Navigation Menu**: All requested menu items
4. **Hero Slider**: Interactive image slider with pharmacy-related content
5. **Quick Info**: Statistics with animated counters
6. **About Section**: Institution information with features
7. **Courses Section**: Interactive course cards (M.Pharma, B.Pharma, D.Pharma)
8. **News & Announcements**: Latest updates and notices
9. **Toppers Section**: Student achievement showcase
10. **Gallery**: Campus and facility images with lightbox effect
11. **Consultation Form**: Interactive contact form with validation
12. **Testimonials**: Student feedback carousel
13. **Footer**: Comprehensive footer with map integration

### Interactive Features
- **Course Card Hover Effects**: Detailed information on hover
- **Gallery Lightbox**: Click to view enlarged images
- **Form Validation**: Real-time form validation
- **Counter Animations**: Animated statistics on scroll
- **Typing Effects**: Dynamic text animations
- **Mouse Follower**: Custom cursor effects
- **Progress Bar**: Scroll progress indicator

### Technical Features
- **Bootstrap 5**: Latest Bootstrap framework
- **Font Awesome Icons**: Comprehensive icon library
- **Google Fonts**: Premium typography
- **CSS Animations**: Custom CSS animations and transitions
- **JavaScript Interactions**: Enhanced user interactions
- **Performance Optimized**: Optimized loading and rendering
- **SEO Friendly**: Semantic HTML structure

## File Structure

```
mip310/
├── index.html          # Main HTML file
├── css/
│   └── style.css       # Custom CSS styles
├── js/
│   └── script.js       # JavaScript functionality
├── images/             # Image assets directory
├── .github/
│   └── copilot-instructions.md
└── README.md           # This file
```

## Setup Instructions

1. **Clone or Download**: Get the project files
2. **Add Images**: Place your images in the `images/` directory:
   - `logo.png` - Main institute logo
   - `logo-white.png` - White version for footer
   - `university1.png`, `university2.png`, `university3.png` - University logos
   - `pharmacy-lab1.jpg`, `pharmacy-lab2.jpg`, `pharmacy-students.jpg` - Hero slider images
   - `about-college.jpg` - About section image
   - `gallery1.jpg` to `gallery6.jpg` - Gallery images
   - `topper1.jpg`, `topper2.jpg`, `topper3.jpg` - Student images
   - `student1.jpg`, `student2.jpg`, `student3.jpg` - Testimonial images

3. **Open in Browser**: Open `index.html` in a web browser
4. **Customize Content**: Update text, images, and contact information as needed

## Browser Compatibility

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Mobile browsers

## Dependencies

All dependencies are loaded via CDN:
- Bootstrap 5.3.2
- Font Awesome 6.4.0
- AOS (Animate On Scroll) 2.3.1
- Google Fonts (Poppins & Playfair Display)

## Customization

### Colors
The color scheme can be modified in the CSS root variables:
```css
:root {
    --primary-color: #8B4513;    /* Saddle Brown */
    --secondary-color: #DAA520;  /* Goldenrod */
    --accent-color: #DC143C;     /* Crimson */
    --dark-color: #2C1810;       /* Dark Brown */
    --light-color: #F5F5DC;      /* Beige */
}
```

### Content
- Update text content directly in `index.html`
- Modify contact information in the footer
- Replace placeholder images with actual photos
- Customize form action URLs for backend integration

### Animations
- Animation duration can be adjusted in AOS initialization
- Custom animations can be added in `script.js`
- CSS animations can be modified in `style.css`

## Performance Tips

1. Optimize images for web (compress and resize)
2. Use WebP format for better compression
3. Implement lazy loading for images
4. Minimize HTTP requests
5. Use CDN for faster loading

## Contact Information

For questions or support regarding this website:
- **Institute**: Magadh Institute of Pharmacy
- **Location**: University Road,  Bihar - 823001
- **Phone**: +91-9876543210
- **Email**: info@magadhpharmacy.edu.in

## License

This website template is created for Magadh Institute of Pharmacy. All rights reserved.

---

**Note**: Replace all placeholder images with actual photographs of your institution, facilities, students, and staff for the best visual impact.