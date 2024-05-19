<?php
session_start();
include_once 'connection.php';

// Check if the file parameter is set
if (isset($_GET['file'])) {
    // Directory where the files are stored
    $directory = "uploads/";
    
    // Get the file name from the query parameter
    $fileName = basename($_GET['file']);
    
    // Path to the file
    $filePath = $directory . $fileName;
    
    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "You must be logged in to bookmark documents.";
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Query to get the documentID from documentfile
    $query = "SELECT documentID FROM documents WHERE documentfile = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $fileName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $document_id = $row['documentID'];

        // Insert the document_id and user_id into bookmarks table
        $insertQuery = "INSERT INTO bookmark (user_id, document_id) VALUES (?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "ii", $user_id, $document_id);

        if (mysqli_stmt_execute($insertStmt)) {
            echo "Document bookmarked successfully.";
        } else {
            echo "Failed to bookmark document.";
        }

        mysqli_stmt_close($insertStmt);
    } else {
        echo "Document not found.";
    }

    mysqli_stmt_close($stmt);

//     // Check if the file exists
//     if (file_exists($filePath)) {
//         // Set headers for force download
//         header('Content-Description: File Transfer');
//         header('Content-Type: application/octet-stream');
//         header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
//         header('Expires: 0');
//         header('Cache-Control: must-revalidate');
//         header('Pragma: public');
//         header('Content-Length: ' . filesize($filePath));
//         ob_clean();
//         flush();
//         readfile($filePath);
//         exit;
//     } else {
//         // If the file doesn't exist, display an error message
//         echo "File not found!";
//     }
// } else {
    // If the file parameter is not set, display an error message
 
}

mysqli_close($conn);
?>
