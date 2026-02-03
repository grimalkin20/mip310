<?php
// API Test File
header('Content-Type: application/json');

echo json_encode([
    'success' => true,
    'message' => 'API is working correctly',
    'data' => [
        'version' => '1.0.0',
        'timestamp' => date('Y-m-d H:i:s'),
        'endpoints' => [
            'auth/login' => 'POST - Login and get API token',
            'auth/logout' => 'POST - Logout and invalidate token',
            'dashboard' => 'GET - Get dashboard statistics',
            'sliders' => 'GET, POST, PUT, DELETE - Manage sliders',
            'gallery' => 'GET, POST - Manage gallery images',
            'announcements' => 'GET, POST - Manage announcements',
            'materials' => 'GET, POST - Manage study materials',
            'inquiries' => 'GET, PUT - Manage inquiries',
            'contacts' => 'GET, PUT - Manage contacts',
            'feedback' => 'GET, POST - Manage feedback',
            'admissions' => 'GET, POST - Manage admission forms'
        ]
    ],
    'timestamp' => date('Y-m-d H:i:s')
]);
?> 