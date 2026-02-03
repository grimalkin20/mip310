# Admin Panel API Documentation

This document provides comprehensive documentation for the Admin Panel REST API, designed for mobile app integration and third-party applications.

## Base URL
```
http://localhost/admin-panel/api/
```

## Authentication

The API uses Bearer token authentication. Include the API key in the Authorization header:

```
Authorization: Bearer YOUR_API_KEY
```

## Endpoints

### Authentication

#### POST /auth/login
Login and get API token.

**Request Body:**
```json
{
    "username": "admin",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "username": "admin",
            "full_name": "Administrator",
            "email": "admin@example.com",
            "user_type": "super_user",
            "status": "active"
        },
        "token": "your_api_key_here"
    },
    "timestamp": "2024-12-20 10:30:00"
}
```

#### POST /auth/logout
Logout and invalidate API token.

**Headers:**
```
Authorization: Bearer YOUR_API_KEY
```

**Response:**
```json
{
    "success": true,
    "message": "Logout successful",
    "data": null,
    "timestamp": "2024-12-20 10:30:00"
}
```

### Dashboard

#### GET /dashboard
Get dashboard statistics and recent activities.

**Headers:**
```
Authorization: Bearer YOUR_API_KEY
```

**Response:**
```json
{
    "success": true,
    "message": "Dashboard data retrieved successfully",
    "data": {
        "statistics": {
            "users": 15,
            "inquiries": 8,
            "contacts": 12,
            "admissions": 5
        },
        "recent_activities": [
            {
                "id": 1,
                "user_id": 1,
                "action": "Login",
                "details": "User logged in",
                "created_at": "2024-12-20 10:30:00",
                "full_name": "Administrator"
            }
        ],
        "recent_inquiries": [
            {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com",
                "subject": "General Inquiry",
                "message": "I have a question...",
                "status": "unread",
                "created_at": "2024-12-20 10:30:00"
            }
        ],
        "recent_admissions": [
            {
                "id": 1,
                "student_name": "Jane Smith",
                "parent_name": "John Smith",
                "email": "jane@example.com",
                "mobile": "1234567890",
                "class": "10th",
                "section": "A",
                "subject": "Science",
                "status": "pending",
                "created_at": "2024-12-20 10:30:00"
            }
        ]
    },
    "timestamp": "2024-12-20 10:30:00"
}
```

### Sliders

#### GET /sliders
Get all sliders.

**Headers:**
```
Authorization: Bearer YOUR_API_KEY
```

**Response:**
```json
{
    "success": true,
    "message": "Sliders retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Welcome Banner",
            "image": "slider_1.jpg",
            "status": "active",
            "sort_order": 1,
            "created_at": "2024-12-20 10:30:00",
            "updated_at": "2024-12-20 10:30:00"
        }
    ],
    "timestamp": "2024-12-20 10:30:00"
}
```

#### GET /sliders/{id}
Get specific slider.

**Headers:**
```
Authorization: Bearer YOUR_API_KEY
```

**Response:**
```json
{
    "success": true,
    "message": "Slider retrieved successfully",
    "data": {
        "id": 1,
        "name": "Welcome Banner",
        "image": "slider_1.jpg",
        "status": "active",
        "sort_order": 1,
        "created_at": "2024-12-20 10:30:00",
        "updated_at": "2024-12-20 10:30:00"
    },
    "timestamp": "2024-12-20 10:30:00"
}
```

#### POST /sliders
Create new slider.

**Headers:**
```
Authorization: Bearer YOUR_API_KEY
Content-Type: application/json
```

**Request Body:**
```json
{
    "name": "New Slider",
    "image": "new_slider.jpg",
    "status": "active",
    "sort_order": 2
}
```

**Response:**
```json
{
    "success": true,
    "message": "Slider created successfully",
    "data": {
        "id": 2
    },
    "timestamp": "2024-12-20 10:30:00"
}
```

#### PUT /sliders/{id}
Update slider.

**Headers:**
```
Authorization: Bearer YOUR_API_KEY
Content-Type: application/json
```

**Request Body:**
```json
{
    "name": "Updated Slider",
    "status": "inactive"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Slider updated successfully",
    "data": null,
    "timestamp": "2024-12-20 10:30:00"
}
```

#### DELETE /sliders/{id}
Delete slider (moves to recycle bin).

**Headers:**
```
Authorization: Bearer YOUR_API_KEY
```

**Response:**
```json
{
    "success": true,
    "message": "Slider deleted successfully",
    "data": null,
    "timestamp": "2024-12-20 10:30:00"
}
```

### Gallery

#### GET /gallery
Get all gallery images with categories.

#### GET /gallery/categories
Get all gallery categories.

#### POST /gallery
Upload new gallery image.

### Announcements

#### GET /announcements
Get all announcements.

#### POST /announcements
Create new announcement.

### Materials

#### GET /materials
Get all study materials and homework.

#### POST /materials
Upload new material.

### Inquiries

#### GET /inquiries
Get all inquiries.

#### PUT /inquiries/{id}/status
Update inquiry status.

### Contacts

#### GET /contacts
Get all contact submissions.

#### PUT /contacts/{id}/status
Update contact status.

### Feedback

#### GET /feedback
Get all feedback (Super User only).

#### POST /feedback
Submit new feedback (Regular users only).

### Admissions

#### GET /admissions
Get all admission forms.

#### POST /admissions
Submit new admission form.

## Error Responses

### 400 Bad Request
```json
{
    "success": false,
    "message": "Validation error message",
    "data": null,
    "timestamp": "2024-12-20 10:30:00"
}
```

### 401 Unauthorized
```json
{
    "success": false,
    "message": "API key required",
    "data": null,
    "timestamp": "2024-12-20 10:30:00"
}
```

### 404 Not Found
```json
{
    "success": false,
    "message": "Resource not found",
    "data": null,
    "timestamp": "2024-12-20 10:30:00"
}
```

### 500 Internal Server Error
```json
{
    "success": false,
    "message": "Internal server error",
    "data": null,
    "timestamp": "2024-12-20 10:30:00"
}
```

## Rate Limiting

- 100 requests per minute per API key
- 1000 requests per hour per API key

## File Upload

For file uploads, use multipart/form-data:

```
POST /sliders
Content-Type: multipart/form-data
Authorization: Bearer YOUR_API_KEY

Form Data:
- name: "Slider Name"
- image: [file]
- status: "active"
```

## Mobile App Integration

### Example: React Native

```javascript
const API_BASE = 'http://localhost/admin-panel/api';

class AdminPanelAPI {
    constructor(apiKey) {
        this.apiKey = apiKey;
    }

    async request(endpoint, options = {}) {
        const response = await fetch(`${API_BASE}${endpoint}`, {
            ...options,
            headers: {
                'Authorization': `Bearer ${this.apiKey}`,
                'Content-Type': 'application/json',
                ...options.headers
            }
        });

        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.message);
        }

        return data;
    }

    async login(username, password) {
        const response = await this.request('/auth/login', {
            method: 'POST',
            body: JSON.stringify({ username, password })
        });
        
        this.apiKey = response.data.token;
        return response.data;
    }

    async getDashboard() {
        return await this.request('/dashboard');
    }

    async getSliders() {
        return await this.request('/sliders');
    }
}
```

### Example: Flutter

```dart
class AdminPanelAPI {
  static const String baseUrl = 'http://localhost/admin-panel/api';
  String? apiKey;

  Future<Map<String, dynamic>> request(String endpoint, {
    String method = 'GET',
    Map<String, dynamic>? body,
  }) async {
    final response = await http.post(
      Uri.parse('$baseUrl$endpoint'),
      headers: {
        'Authorization': 'Bearer $apiKey',
        'Content-Type': 'application/json',
      },
      body: body != null ? jsonEncode(body) : null,
    );

    final data = jsonDecode(response.body);
    
    if (!data['success']) {
      throw Exception(data['message']);
    }

    return data;
  }

  Future<Map<String, dynamic>> login(String username, String password) async {
    final response = await request('/auth/login', 
      method: 'POST',
      body: {
        'username': username,
        'password': password,
      }
    );
    
    apiKey = response['data']['token'];
    return response['data'];
  }

  Future<Map<String, dynamic>> getDashboard() async {
    return await request('/dashboard');
  }
}
```

## Security Considerations

1. **API Key Security**: Store API keys securely, never expose them in client-side code
2. **HTTPS**: Always use HTTPS in production
3. **Rate Limiting**: Implement rate limiting to prevent abuse
4. **Input Validation**: Always validate and sanitize input data
5. **Error Handling**: Don't expose sensitive information in error messages

## Testing

You can test the API using tools like:
- Postman
- cURL
- Insomnia
- Thunder Client (VS Code extension)

### Example cURL commands:

```bash
# Login
curl -X POST http://localhost/admin-panel/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"password"}'

# Get dashboard (replace YOUR_API_KEY with actual token)
curl -X GET http://localhost/admin-panel/api/dashboard \
  -H "Authorization: Bearer YOUR_API_KEY"

# Get sliders
curl -X GET http://localhost/admin-panel/api/sliders \
  -H "Authorization: Bearer YOUR_API_KEY"
```

## Support

For API support or feature requests, please contact the development team. 