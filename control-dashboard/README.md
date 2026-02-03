# Admin Panel for Websites

A comprehensive admin panel built with PHP, HTML, CSS, JavaScript, and MySQL for managing website content, users, and data.

## Features

### 🔐 Authentication & Security
- Secure login system with password hashing
- User role management (Super User, Admin, User)
- Session management
- Activity logging
- Password change requests (Super User approval required)

### 🎨 Modern UI/UX
- Responsive design with Bootstrap 5
- Dark/Light theme toggle
- Collapsible sidebar navigation
- Modern card-based layout
- Interactive file upload with drag & drop
- Real-time form validation

### 📊 Dashboard
- Statistics overview (users, inquiries, contacts, admissions)
- Recent activities log
- Quick action buttons
- Recent data previews

### 👥 User Management (Super User Only)
- Add, edit, delete users
- Change user passwords
- User status management
- User activity tracking

### 📝 Content Management
- **Sliders**: Add and manage slider images
- **Mandatory Disclosures**: Upload and manage disclosure documents
- **Gallery**: Category-based image management
- **Media/Video**: Link management for videos
- **Study Materials**: File upload with category organization
- **Announcements**: News and notice management

### 📋 Data Management
- **Inquiries**: Manage public inquiries
- **Contacts**: Handle contact form submissions
- **Feedback**: User feedback system
- **Admission Forms**: Complete admission form management

### 🗑️ Recycle Bin System
- 10-day retention period for deleted items
- Restore functionality
- Automatic permanent deletion after retention period

### 📁 File Management
- Secure file upload system
- File type validation
- Size restrictions (5MB max)
- Automatic file organization
- Image preview functionality

## Installation

### Prerequisites
- WAMP Server (Windows) or similar local server
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser

### Setup Instructions

1. **Clone/Download the Project**
   ```bash
   # Place the project in your WAMP www directory
   # Example: C:\wamp64\www\admin-panel\
   ```

2. **Database Setup**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `admin_panel`
   - Import the SQL file: `setup/database.sql`

3. **Configuration**
   - Edit `config/database.php` if needed
   - Default settings are for WAMP Server:
     - Host: localhost
     - Username: root
     - Password: (empty)
     - Database: admin_panel

4. **File Permissions**
   - Ensure the `uploads/` directory is writable
   - Create subdirectories if they don't exist

5. **Access the Admin Panel**
   - Open your browser
   - Navigate to: `http://localhost/admin-panel/`
   - Default login credentials:
     - Username: `admin`
     - Password: `password`

## Directory Structure

```
admin-panel/
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── admin.js
├── config/
│   └── database.php
├── includes/
│   ├── functions.php
│   ├── header.php
│   └── sidebar.php
├── uploads/
│   ├── sliders/
│   ├── disclosures/
│   ├── gallery/
│   ├── materials/
│   └── admissions/
├── sliders/
├── disclosures/
├── gallery/
├── media/
├── materials/
├── announcements/
├── users/
├── inquiries/
├── contacts/
├── feedback/
├── admissions/
├── profile/
├── setup/
│   └── database.sql
├── index.php
├── dashboard.php
├── logout.php
└── README.md
```

## Features in Detail

### 1. Sliders Management
- **Add Slider Images**: Upload images with drag & drop
- **Manage Slider Images**: Edit, delete, activate/deactivate
- **Recycle Bin**: Restore deleted sliders within 10 days

### 2. Mandatory Disclosures
- **Add Disclosures**: Upload PDF, DOC, DOCX files
- **Manage Disclosures**: Edit and organize documents
- **File Organization**: Stored in `/uploads/disclosures/`

### 3. Gallery System
- **Categories**: Create and manage image categories
- **Add Images**: Upload images with category selection
- **Manage Images**: Edit, delete, activate/deactivate
- **Image Preview**: Thumbnail generation

### 4. Media/Video Management
- **Categories**: Organize video links by category
- **Add Links**: Add YouTube, Vimeo, or other video links
- **Manage Links**: Edit and organize video content

### 5. Study Materials/Homework
- **Type Management**: Study Material vs Homework
- **Class & Section**: Hierarchical organization
- **Subject Management**: Subject-specific file organization
- **File Upload**: Support for various document formats

### 6. Announcements/News/Notice
- **Category Management**: Announcement, News, Notice
- **Content Management**: Add and edit announcements
- **Status Control**: Active/inactive status

### 7. Admission Forms
- **Complete Form Management**: All admission form fields
- **Document Upload**: Multiple document types
- **Status Tracking**: Pending, approved, rejected
- **Email Integration**: Send approval/rejection emails

## User Roles

### Super User
- Full access to all features
- User management
- System settings
- Feedback management

### Admin
- Content management
- Data management
- Limited user features

### User
- Basic content management
- Feedback submission
- Profile management

## Security Features

- **Password Hashing**: Bcrypt encryption
- **SQL Injection Prevention**: Prepared statements
- **XSS Protection**: Input sanitization
- **CSRF Protection**: Form tokens
- **Session Security**: Secure session handling
- **File Upload Security**: Type and size validation

## File Upload System

### Supported Formats
- **Images**: JPG, JPEG, PNG, GIF
- **Documents**: PDF, DOC, DOCX, PPT, PPTX

### File Organization
```
uploads/
├── sliders/          # Slider images
├── disclosures/      # Mandatory disclosure files
├── gallery/          # Gallery images
├── materials/        # Study materials and homework
└── admissions/       # Admission form documents
```

### File Naming
- Unique filenames with timestamps
- Original names preserved in database
- Automatic file type detection

## Theme System

### Light Theme
- Clean, professional appearance
- High contrast for readability
- Blue accent colors

### Dark Theme
- Modern dark interface
- Reduced eye strain
- Consistent color scheme

### Theme Persistence
- Theme preference saved in localStorage
- Automatic theme restoration
- Smooth transitions

## Responsive Design

- **Desktop**: Full sidebar navigation
- **Tablet**: Collapsible sidebar
- **Mobile**: Hamburger menu
- **Touch-friendly**: Optimized for touch devices

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Performance Features

- **Optimized Images**: Automatic compression
- **Lazy Loading**: Image lazy loading
- **Caching**: Browser caching enabled
- **Minified Assets**: Compressed CSS/JS
- **Database Indexing**: Optimized queries

## Error Handling

- **User-friendly Messages**: Clear error descriptions
- **Logging**: Activity and error logging
- **Graceful Degradation**: Fallback functionality
- **Validation**: Client and server-side validation

## Maintenance

### Regular Tasks
- Monitor activity logs
- Clean up old files
- Update user passwords
- Backup database

### Backup Strategy
- Database backups (daily)
- File uploads backup (weekly)
- Configuration backup (monthly)

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `config/database.php`
   - Ensure MySQL service is running

2. **File Upload Errors**
   - Check file permissions on `uploads/` directory
   - Verify PHP upload settings in `php.ini`

3. **Login Issues**
   - Reset admin password in database
   - Check session configuration

4. **Theme Not Saving**
   - Clear browser cache
   - Check JavaScript console for errors

## Support

For technical support or feature requests, please contact the development team.

## License

This project is proprietary software. All rights reserved.

---

**Version**: 1.0.0  
**Last Updated**: December 2024  
**Compatibility**: PHP 7.4+, MySQL 5.7+, Modern Browsers 