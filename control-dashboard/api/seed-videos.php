<?php
header('Content-Type: application/json');
include '../config/database.php';

try {
    // Check if media_links table exists, if not create it
    $checkTable = "SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'media_links'";
    $tableExists = $conn->query($checkTable)->num_rows > 0;
    
    if (!$tableExists) {
        $createTableSQL = "CREATE TABLE media_links (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT DEFAULT 1,
            name VARCHAR(255) NOT NULL,
            link_url VARCHAR(500),
            description TEXT,
            status VARCHAR(50) DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if (!$conn->query($createTableSQL)) {
            throw new Exception("Failed to create media_links table: " . $conn->error);
        }
    }
    
    // Insert sample video data
    $videos = array(
        array(
            'name' => 'Campus Tour - Magadh Institute of Pharmacy',
            'link_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'description' => 'Take a virtual tour of our beautiful campus, state-of-the-art laboratories, and modern facilities.'
        ),
        array(
            'name' => 'B.Pharm Program Overview',
            'link_url' => 'https://youtu.be/pFrE14wpGWY',
            'description' => 'Learn about our comprehensive Bachelor of Pharmacy program designed for excellence.'
        ),
        array(
            'name' => 'Student Life at MIP',
            'link_url' => 'https://www.youtube.com/watch?v=Z9G-VLHrMiE',
            'description' => 'Experience the vibrant student life, events, and activities at Magadh Institute of Pharmacy.'
        ),
        array(
            'name' => 'Faculty & Research Excellence',
            'link_url' => 'https://youtu.be/U7sQi5xwkWs',
            'description' => 'Meet our expert faculty members and discover our cutting-edge pharmaceutical research initiatives.'
        ),
        array(
            'name' => 'Placement & Career Success',
            'link_url' => 'https://www.youtube.com/watch?v=8YDGQU4f6OQ',
            'description' => 'See how our students achieve remarkable placements with top pharmaceutical companies.'
        ),
        array(
            'name' => 'Admission & Application Process',
            'link_url' => 'https://youtu.be/qGY0FKwqfK8',
            'description' => 'Complete guide to admission requirements and application process for all pharmacy programs.'
        )
    );
    
    $insertCount = 0;
    
    foreach ($videos as $video) {
        // Check if video already exists to avoid duplicates
        $checkSQL = "SELECT id FROM media_links WHERE name = ? LIMIT 1";
        $stmt = $conn->prepare($checkSQL);
        $stmt->bind_param("s", $video['name']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            // Insert new video
            $insertSQL = "INSERT INTO media_links (category_id, name, link_url, description, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSQL);
            $category_id = 1;
            $status = 'active';
            
            $stmt->bind_param("issss", $category_id, $video['name'], $video['link_url'], $video['description'], $status);
            
            if ($stmt->execute()) {
                $insertCount++;
            }
        }
    }
    
    echo json_encode(array(
        'success' => true,
        'message' => $insertCount . ' video(s) inserted successfully',
        'inserted' => $insertCount,
        'total_videos' => count($videos)
    ));
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array(
        'success' => false,
        'message' => $e->getMessage()
    ));
}

$conn->close();
?>
