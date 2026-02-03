<?php
/**
 * Recreate Admission Forms Table
 * This script will drop and recreate the admission_forms table with the correct structure
 */

// Include database connection
require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Recreate Admission Forms Table - Admin Panel</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
        <h2>Recreate Admission Forms Table</h2>";

if (isset($_POST['recreate'])) {
    try {
        // Drop existing table if it exists
        $conn->query("DROP TABLE IF EXISTS admission_forms");
        echo "<div class='alert alert-info'>Existing table dropped.</div>";
        
        // Create table with correct structure
        $create_table_sql = "
        CREATE TABLE admission_forms (
            id INT AUTO_INCREMENT PRIMARY KEY,
            form_id INT,
            student_name VARCHAR(100) NOT NULL,
            parent_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            mobile VARCHAR(20) NOT NULL,
            class VARCHAR(50) NOT NULL,
            section VARCHAR(50) NOT NULL,
            subject VARCHAR(100) NOT NULL,
            message TEXT,
            status ENUM('pending', 'processed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($create_table_sql)) {
            echo "<div class='alert alert-success'>
                    <strong>Success!</strong> admission_forms table created with correct structure.
                  </div>";
            
            // Show the new table structure
            echo "<div class='card'>
                    <div class='card-header'>
                        <h5>New Table Structure</h5>
                    </div>
                    <div class='card-body'>
                        <div class='table-responsive'>
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Column</th>
                                        <th>Type</th>
                                        <th>Null</th>
                                        <th>Key</th>
                                        <th>Default</th>
                                        <th>Extra</th>
                                    </tr>
                                </thead>
                                <tbody>";
            
            $structure = $conn->query("DESCRIBE admission_forms");
            while ($column = $structure->fetch_assoc()) {
                echo "<tr>
                        <td><strong>" . $column['Field'] . "</strong></td>
                        <td>" . $column['Type'] . "</td>
                        <td>" . $column['Null'] . "</td>
                        <td>" . $column['Key'] . "</td>
                        <td>" . $column['Default'] . "</td>
                        <td>" . $column['Extra'] . "</td>
                      </tr>";
            }
            
            echo "</tbody></table></div></div></div>";
            
            // Test insert
            $test_sql = "INSERT INTO admission_forms (student_name, parent_name, email, mobile, class, section, subject, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($test_sql);
            $stmt->bind_param("sssssssss", 
                'Test Student', 
                'Test Parent', 
                'test@email.com', 
                '9876543210', 
                '09', 
                'A', 
                'Mathematics', 
                'Test message', 
                'pending'
            );
            
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>
                        <strong>Test insert successful!</strong> The table is working correctly.
                      </div>";
                
                // Clean up test data
                $conn->query("DELETE FROM admission_forms WHERE student_name = 'Test Student'");
                echo "<div class='alert alert-info'>Test data cleaned up.</div>";
            } else {
                echo "<div class='alert alert-danger'>
                        <strong>Test insert failed!</strong> " . $stmt->error . "
                      </div>";
            }
            
        } else {
            echo "<div class='alert alert-danger'>
                    <strong>Error creating table:</strong> " . $conn->error . "
                  </div>";
        }
        
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>
                <strong>Error:</strong> " . $e->getMessage() . "
              </div>";
    }
} else {
    // Show current table structure
    echo "<div class='card mb-4'>
            <div class='card-header'>
                <h5>Current Table Status</h5>
            </div>
            <div class='card-body'>";
    
    $result = $conn->query("SHOW TABLES LIKE 'admission_forms'");
    
    if ($result->num_rows == 0) {
        echo "<div class='alert alert-warning'>
                <strong>Table not found!</strong> The admission_forms table does not exist.
              </div>";
    } else {
        echo "<div class='alert alert-info'>
                <strong>Table exists!</strong> Current structure:
              </div>";
        
        echo "<div class='table-responsive'>
                <table class='table table-sm'>
                    <thead>
                        <tr>
                            <th>Column</th>
                            <th>Type</th>
                            <th>Null</th>
                            <th>Key</th>
                            <th>Default</th>
                        </tr>
                    </thead>
                    <tbody>";
        
        $structure = $conn->query("DESCRIBE admission_forms");
        while ($column = $structure->fetch_assoc()) {
            echo "<tr>
                    <td><strong>" . $column['Field'] . "</strong></td>
                    <td>" . $column['Type'] . "</td>
                    <td>" . $column['Null'] . "</td>
                    <td>" . $column['Key'] . "</td>
                    <td>" . $column['Default'] . "</td>
                  </tr>";
        }
        
        echo "</tbody></table></div>";
    }
    
    echo "</div></div>";
    
    // Show form
    echo "<div class='card'>
            <div class='card-header'>
                <h5>Recreate Table</h5>
            </div>
            <div class='card-body'>
                <p class='text-muted'>
                    This will drop the existing admission_forms table and recreate it with the correct structure.
                    <strong>Warning:</strong> This will delete all existing data in the table.
                </p>
                
                <form method='post'>
                    <button type='submit' name='recreate' class='btn btn-warning' 
                            onclick='return confirm(\"Are you sure you want to recreate the table? This will delete all existing data.\")'>
                        <i class='fas fa-exclamation-triangle me-2'></i>Recreate Table
                    </button>
                    
                    <a href='check_table_structure.php' class='btn btn-outline-secondary ms-2'>
                        <i class='fas fa-eye me-2'></i>Check Structure
                    </a>
                    
                    <a href='insert_dummy_admission_data.php' class='btn btn-outline-primary ms-2'>
                        <i class='fas fa-database me-2'></i>Insert Dummy Data
                    </a>
                </form>
            </div>
          </div>";
}

echo "</div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>";
?> 