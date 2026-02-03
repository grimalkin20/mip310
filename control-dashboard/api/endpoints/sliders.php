<?php
// Sliders Endpoints

$user = authenticateAPI();

switch ($method) {
    case 'GET':
        if (!$id) {
            // Get all sliders
            $sql = "SELECT * FROM sliders ORDER BY sort_order ASC, created_at DESC";
            $result = $conn->query($sql);
            $sliders = [];
            while ($row = $result->fetch_assoc()) {
                $sliders[] = $row;
            }
            apiResponse($sliders, 'Sliders retrieved successfully');
        } else {
            // Get specific slider
            $sql = "SELECT * FROM sliders WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                apiResponse($result->fetch_assoc(), 'Slider retrieved successfully');
            } else {
                apiResponse(null, 'Slider not found', 404, true);
            }
        }
        break;
        
    case 'POST':
        if (!$id) {
            // Create new slider
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['name']) || !isset($input['image'])) {
                apiResponse(null, 'Name and image are required', 400, true);
            }
            
            $name = sanitizeInput($input['name']);
            $image = sanitizeInput($input['image']);
            $status = isset($input['status']) ? sanitizeInput($input['status']) : 'active';
            $sort_order = isset($input['sort_order']) ? (int)$input['sort_order'] : 0;
            
            $sql = "INSERT INTO sliders (name, image, status, sort_order) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $image, $status, $sort_order);
            
            if ($stmt->execute()) {
                $slider_id = $conn->insert_id;
                logActivity($user['id'], 'Add Slider', "Added slider: $name");
                apiResponse(['id' => $slider_id], 'Slider created successfully');
            } else {
                apiResponse(null, 'Failed to create slider', 500, true);
            }
        } else {
            apiResponse(null, 'Invalid endpoint', 404, true);
        }
        break;
        
    case 'PUT':
        if ($id) {
            // Update slider
            $input = json_decode(file_get_contents('php://input'), true);
            
            $name = isset($input['name']) ? sanitizeInput($input['name']) : '';
            $image = isset($input['image']) ? sanitizeInput($input['image']) : '';
            $status = isset($input['status']) ? sanitizeInput($input['status']) : '';
            $sort_order = isset($input['sort_order']) ? (int)$input['sort_order'] : 0;
            
            $update_fields = [];
            $params = [];
            $types = '';
            
            if (!empty($name)) {
                $update_fields[] = "name = ?";
                $params[] = $name;
                $types .= 's';
            }
            
            if (!empty($image)) {
                $update_fields[] = "image = ?";
                $params[] = $image;
                $types .= 's';
            }
            
            if (!empty($status)) {
                $update_fields[] = "status = ?";
                $params[] = $status;
                $types .= 's';
            }
            
            $update_fields[] = "sort_order = ?";
            $params[] = $sort_order;
            $types .= 'i';
            
            if (empty($update_fields)) {
                apiResponse(null, 'No fields to update', 400, true);
            }
            
            $params[] = $id;
            $types .= 'i';
            
            $sql = "UPDATE sliders SET " . implode(', ', $update_fields) . " WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            
            if ($stmt->execute()) {
                logActivity($user['id'], 'Update Slider', "Updated slider ID: $id");
                apiResponse(null, 'Slider updated successfully');
            } else {
                apiResponse(null, 'Failed to update slider', 500, true);
            }
        } else {
            apiResponse(null, 'Slider ID required', 400, true);
        }
        break;
        
    case 'DELETE':
        if ($id) {
            // Delete slider (move to recycle bin)
            $sql = "SELECT * FROM sliders WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $slider = $result->fetch_assoc();
                
                // Move to recycle bin
                $recycle_sql = "INSERT INTO sliders_recycle (slider_id, name, image, deleted_at) VALUES (?, ?, ?, NOW())";
                $recycle_stmt = $conn->prepare($recycle_sql);
                $recycle_stmt->bind_param("iss", $id, $slider['name'], $slider['image']);
                
                if ($recycle_stmt->execute()) {
                    // Delete from main table
                    $delete_sql = "DELETE FROM sliders WHERE id = ?";
                    $delete_stmt = $conn->prepare($delete_sql);
                    $delete_stmt->bind_param("i", $id);
                    
                    if ($delete_stmt->execute()) {
                        logActivity($user['id'], 'Delete Slider', "Deleted slider: {$slider['name']}");
                        apiResponse(null, 'Slider deleted successfully');
                    } else {
                        apiResponse(null, 'Failed to delete slider', 500, true);
                    }
                } else {
                    apiResponse(null, 'Failed to move slider to recycle bin', 500, true);
                }
            } else {
                apiResponse(null, 'Slider not found', 404, true);
            }
        } else {
            apiResponse(null, 'Slider ID required', 400, true);
        }
        break;
        
    default:
        apiResponse(null, 'Method not allowed', 405, true);
}
?> 