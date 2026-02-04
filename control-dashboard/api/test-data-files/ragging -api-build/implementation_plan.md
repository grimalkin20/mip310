# Ragging Report System Implementation Plan

Complete system for receiving, storing, and managing ragging/harassment reports with super admin-only access.

## User Review Required

> [!IMPORTANT]
> **Super Admin Access**: Only users with `role = 'super_admin'` will be able to view ragging reports. Regular admins will not have access to this sensitive data.

> [!WARNING]
> **File Upload Security**: Attachments will be stored in a restricted directory with file type validation. Maximum file size: 5MB.

---

## Proposed Changes

### Database Schema

#### [NEW] ragging_reports Table

```sql
CREATE TABLE `ragging_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_type` varchar(50) NOT NULL DEFAULT 'anti-ragging',
  `recipient` varchar(100) NOT NULL,
  `recipient_phone` varchar(20) DEFAULT NULL,
  `recipient_email` varchar(255) DEFAULT NULL,
  `reporter_name` varchar(255) DEFAULT NULL,
  `reporter_phone` varchar(20) DEFAULT NULL,
  `reporter_email` varchar(255) DEFAULT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `send_sms` tinyint(1) DEFAULT 0,
  `status` enum('pending','reviewed','resolved','closed') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Fields Explanation:**
- `report_type`: Type of report (anti-ragging, harassment, etc.)
- `recipient`: Selected committee member identifier
- `recipient_phone/email`: Auto-populated from selection
- `reporter_*`: Reporter's contact info (NULL if anonymous)
- `is_anonymous`: Flag for anonymous submissions
- `message`: Detailed incident description
- `attachment`: Filename of uploaded evidence
- `send_sms`: Whether SMS notification was requested
- `status`: Report processing status
- `admin_notes`: Internal notes by admin
- `ip_address/user_agent`: For tracking and security

---

### API Endpoint

#### [NEW] [control-dashboard/api/submit-ragging-report.php](file:///c:/wamp64/www/mip310/control-dashboard/api/submit-ragging-report.php)

**Purpose**: Receive and process ragging report submissions

**Features**:
- Validate all required fields
- Handle file uploads (images, PDFs, documents)
- Store files in `control-dashboard/uploads/ragging-reports/`
- Sanitize inputs to prevent SQL injection
- Capture IP address and user agent
- Return JSON response with success/error status

**Request Method**: POST (multipart/form-data)

**Expected Fields**:
- `report_type`, `recipient`, `recipient_phone`, `recipient_email`
- `reporter_name`, `reporter_phone`, `reporter_email` (optional if anonymous)
- `anonymous` (checkbox value)
- `message` (required, min 10 chars)
- `attachment` (file, optional)
- `send_sms` (checkbox value)

---

### Frontend Integration

#### [MODIFY] [information.html](file:///c:/wamp64/www/mip310/information.html#L669-L760)

**Changes**:
- Update form `action` to point to API endpoint
- Add JavaScript to handle form submission via AJAX
- Display success/error messages dynamically
- Clear form on successful submission
- Add loading state during submission

---

### Admin Panel

#### [NEW] [control-dashboard/ragging-reports/index.php](file:///c:/wamp64/www/mip310/control-dashboard/ragging-reports/index.php)

**Purpose**: Display all ragging reports (super admin only)

**Features**:
- Check user role: only `super_admin` can access
- Display reports in a sortable table
- Show: ID, Date, Reporter (or "Anonymous"), Recipient, Status, Actions
- Filter by status (pending, reviewed, resolved, closed)
- Search by reporter name, message content
- Pagination for large datasets

---

#### [NEW] [control-dashboard/ragging-reports/view.php](file:///c:/wamp64/www/mip310/control-dashboard/ragging-reports/view.php)

**Purpose**: View detailed report information

**Features**:
- Display all report details
- Show attachment with download link
- Display IP address and user agent
- Show admin notes
- Update status dropdown
- Add/edit admin notes
- Mark as reviewed/resolved/closed

---

#### [MODIFY] [control-dashboard/includes/sidebar.php](file:///c:/wamp64/www/mip310/control-dashboard/includes/sidebar.php)

**Changes**:
- Add "Ragging Reports" menu item
- Show only for super admin users
- Add badge showing count of pending reports
- Icon: `fa-shield-alt` or `fa-exclamation-triangle`

---

## Verification Plan

### Automated Tests

1. **Database Test**:
   ```bash
   # Run SQL to create table
   # Insert test record
   # Verify data integrity
   ```

2. **API Test**:
   - Submit form with all fields
   - Submit anonymous report
   - Submit with file attachment
   - Test validation errors
   - Verify database insertion

3. **File Upload Test**:
   - Upload valid file types (jpg, png, pdf, doc)
   - Test file size limit (5MB)
   - Verify file storage location
   - Test invalid file types

### Manual Verification

1. **Frontend Form**:
   - Fill and submit form from `information.html`
   - Verify success message appears
   - Check form clears after submission
   - Test anonymous submission

2. **Admin Panel Access**:
   - Login as super admin → should see "Ragging Reports" menu
   - Login as regular admin → should NOT see menu
   - Verify access control on direct URL access

3. **Report Management**:
   - View report list
   - Open report details
   - Update status
   - Add admin notes
   - Download attachment

4. **Security**:
   - Test SQL injection attempts
   - Verify file upload restrictions
   - Check role-based access control
   - Verify anonymous submissions hide reporter info
