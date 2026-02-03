<?php
// Dashboard Endpoints

$user = authenticateAPI();

switch ($method) {
    case 'GET':
        if (!$id) {
            // Get dashboard statistics
            $stats = [];
            
            // Total users
            $sql = "SELECT COUNT(*) as count FROM users WHERE status = 'active'";
            $result = $conn->query($sql);
            $stats['users'] = $result->fetch_assoc()['count'];
            
            // Total inquiries
            $sql = "SELECT COUNT(*) as count FROM inquiries WHERE status = 'unread'";
            $result = $conn->query($sql);
            $stats['inquiries'] = $result->fetch_assoc()['count'];
            
            // Total contacts
            $sql = "SELECT COUNT(*) as count FROM contacts WHERE status = 'unread'";
            $result = $conn->query($sql);
            $stats['contacts'] = $result->fetch_assoc()['count'];
            
            // Total admission forms
            $sql = "SELECT COUNT(*) as count FROM admission_forms WHERE status = 'pending'";
            $result = $conn->query($sql);
            $stats['admissions'] = $result->fetch_assoc()['count'];
            
            // Recent activities
            $sql = "SELECT al.*, u.full_name FROM activity_logs al 
                    LEFT JOIN users u ON al.user_id = u.id 
                    ORDER BY al.created_at DESC LIMIT 10";
            $recent_activities = $conn->query($sql);
            $activities = [];
            while ($row = $recent_activities->fetch_assoc()) {
                $activities[] = $row;
            }
            
            // Recent inquiries
            $sql = "SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 5";
            $recent_inquiries = $conn->query($sql);
            $inquiries = [];
            while ($row = $recent_inquiries->fetch_assoc()) {
                $inquiries[] = $row;
            }
            
            // Recent admission forms
            $sql = "SELECT * FROM admission_forms ORDER BY created_at DESC LIMIT 5";
            $recent_admissions = $conn->query($sql);
            $admissions = [];
            while ($row = $recent_admissions->fetch_assoc()) {
                $admissions[] = $row;
            }
            
            apiResponse([
                'statistics' => $stats,
                'recent_activities' => $activities,
                'recent_inquiries' => $inquiries,
                'recent_admissions' => $admissions
            ], 'Dashboard data retrieved successfully');
        } else {
            apiResponse(null, 'Invalid dashboard endpoint', 404, true);
        }
        break;
        
    default:
        apiResponse(null, 'Method not allowed', 405, true);
}
?> 