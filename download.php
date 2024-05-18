<?php
// Check if the file parameter is set
if(isset($_GET['file'])) {
    // Directory where the files are stored
    $directory = "uploads/";
    
    // Get the file name from the query parameter
    $fileName = basename($_GET['file']);
    
    // Path to the file
    $filePath = $directory . $fileName;

    // Check if the file exists
    if(file_exists($filePath)) {
        // Set headers for force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        ob_clean();
        flush();
        readfile($filePath);
        exit;
    } else {
        // If the file doesn't exist, display an error message
        echo "File not found!";
    }
} else {
    // If the file parameter is not set, display an error message
    echo "Invalid request!";
}
?>
