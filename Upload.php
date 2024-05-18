<?php

// Check if the user is logged in as admin
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "publication_portal";

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if a file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf");
        if (!in_array($file_type, $allowed_types)) {
            $message= "Sorry, only JPG, JPEG, PNG, GIF, and PDF files are allowed.";
        } else {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                // File upload success, now store information in the database
                $filename = $_FILES["file"]["name"];
                $documentYear = $_POST["DocumentYear"];
                $documentTitle = $_POST["DocumentTitle"];
                $domainName = $_POST["DomainName"];
                $publicationName = $_POST["PublicationName"];
                $typeName = $_POST["TypeName"];

                // Fetching foreign key IDs
                $domainID = $conn->query("SELECT DomainID FROM domain WHERE DomainName='$domainName'")->fetch_assoc()['DomainID'];
                $publicationID = $conn->query("SELECT PublicationID FROM publication WHERE PublicationName='$publicationName'")->fetch_assoc()['PublicationID'];
                $typeID = $conn->query("SELECT TypeID FROM type WHERE TypeName='$typeName'")->fetch_assoc()['TypeID'];

                // Insert the document information into the database
                $sql = "INSERT INTO documents (documentfile, DocumentYear, DocumentTitle, DomainID, PublicationID, TypeID)
                        VALUES ('$filename', $documentYear, '$documentTitle', $domainID, $publicationID, $typeID)";

                if ($conn->query($sql) === TRUE) {
                    $message = "The file " . basename($_FILES["file"]["name"]) . " has been uploaded and the information has been stored in the database.";
                } else {
                    $message = "Sorry, there was an error uploading your file and storing information in the database: " . $conn->error;
                }
            } else {
               $message= "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Upload Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
             min-height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .upload-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            align-items: center;
            justify-content: center;
            width:60%;
            margin-left: 10%;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .sidebar {
        flex: 0 0 20%;
        background-color: #007bff;
        color: #fff;
        padding: 20px;
        margin-right: 1%;
        float: left;
        clear: left;
        padding-bottom: 753px;
    }
    .sidebar .class{
        position: fixed;
    }
    </style>
</head>
<body>
<div class="sidebar">
        <div class="mb-4 class">
            <h3 class="my-4 nav-item">Publication<i>HUB</i></h3>
            <ul class="nav flex-column" style="margin-top:60% ; font-size: 20px;">
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-house-door"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-search"></i> Find Articles</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-person-lines-fill"></i> Profile</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-bookmarks"></i> Bookmark</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-gear"></i> Settings</a></li>
            </ul>
        </div>
        
        
    </div>
    <div class="upload-container">
        <h2 class="text-center">Upload Document</h2>
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo strpos($message, 'Sorry') !== false ? 'danger' : 'success'; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Select file to upload:</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="DocumentYear" class="form-label">Document Year:</label>
                <input type="number" name="DocumentYear" id="DocumentYear" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="DocumentTitle" class="form-label">Document Title:</label>
                <input type="text" name="DocumentTitle" id="DocumentTitle" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="DomainName" class="form-label">Domain Name:</label>
                <input type="text" name="DomainName" id="DomainName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="PublicationName" class="form-label">Publication Name:</label>
                <input type="text" name="PublicationName" id="PublicationName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="TypeName" class="form-label">Type Name:</label>
                <input type="text" name="TypeName" id="TypeName" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Upload Document</button>
         
            </div>
        </form>
    </div>
</body>
</html>