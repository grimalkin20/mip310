<?php
// Authentication Endpoints

switch ($method) {
    case 'POST':
        if ($id === 'login') {
            // Login endpoint
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['username']) || !isset($input['password'])) {
                apiResponse(null, 'Username and password required', 400, true);
            }
            
            $username = trim($input['username']);
            $password = $input['password'];
            
            $sql = "SELECT * FROM users WHERE username = ? AND status = 'active'";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    // Generate API key if not exists
                    if (empty($user['api_key'])) {
                        $apiKey = bin2hex(random_bytes(32));
                        $update_sql = "UPDATE users SET api_key = ? WHERE id = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->bind_param("si", $apiKey, $user['id']);
                        $update_stmt->execute();
                        $user['api_key'] = $apiKey;
                    }
                    
                    // Update last login
                    $update_sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("i", $user['id']);
                    $update_stmt->execute();
                    
                    // Remove sensitive data
                    unset($user['password']);
                    
                    apiResponse([
                        'user' => $user,
                        'token' => $user['api_key']
                    ], 'Login successful');
                } else {
                    apiResponse(null, 'Invalid credentials', 401, true);
                }
            } else {
                apiResponse(null, 'User not found or inactive', 401, true);
            }
        } elseif ($id === 'logout') {
            // Logout endpoint
            $user = authenticateAPI();
            
            // Clear API key
            $sql = "UPDATE users SET api_key = NULL WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user['id']);
            $stmt->execute();
            
            apiResponse(null, 'Logout successful');
        } else {
            apiResponse(null, 'Invalid authentication endpoint', 404, true);
        }
        break;
        
    default:
        apiResponse(null, 'Method not allowed', 405, true);
}
?> 