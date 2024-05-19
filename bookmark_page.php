<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Include database connection
include_once 'connection.php';

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Query to fetch bookmarks of the logged-in user
$query = "SELECT * FROM bookmark WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if query execution was successful
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmarks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <style>
   .sidebar {
        flex: 0 0 20%;
        background-color: #007bff;
        color: #fff;
        padding: 20px;
        margin-right: 1%;
        float: left;
        clear: left;
        padding-bottom: 753px;
        width:20%;
    }
    .sidebar .class{
        position: fixed;
    }

       .container {
    margin-top: 20px;
    border-radius: 15px; /* Increased border radius */
    box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Adding shadow */
    padding: 40px;
    width: 82%;
    margin: 0 auto; /* Center align horizontally */
    display: flex;
    flex-direction: column; /* Align items vertically */
    align-items: center; /* Align items horizontally */
    justify-content: center;
    text-align: center;
}
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .download-btn {
            background-color: #007bff; /* Blue download button */
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
       
        .profile-img {
        position: absolute;
        top: 2%;
        right: 1%;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #fff;
        background-image: url('Capture.JPG'); 
        background-size: cover;
    }

    h2{
        text-align: center;
        margin-bottom: 40px;
        margin-top: 20px;
        align-items: center;
        justify-content: center;
    }
      
    </style>
</head>
<body>
 <div>
 <div class="sidebar">
        <div class="mb-4 class">
        <img  src="logo1.png" alt="Profile Image" class="profile-img" style="width:60px; height:60px; float:left; margin-right:70%;">
          <h3 class="my-4 nav-item" style="padding-left:32%">Publication<i>HUB</i></h3>
            <ul class="nav flex-column" style="margin-top:60% ; font-size: 20px;">
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-house-door"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-search"></i> Find Articles</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-person-lines-fill"></i> Profile</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-bookmarks"></i> Bookmark</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-gear"></i> Settings</a></li>
            </ul>
        </div>
    </div>
 </div>
<div class="container">
    
    <div class="row">
        
            <h2 class="text-center" align="center">Bookmarks</h2>
            <div  class="row">
                <?php
                // Check if there are any bookmarks
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $document_id = $row['document_id'];
                        // Query to fetch document details
                        $doc_query = "SELECT * FROM documents WHERE documentID = $document_id";
                        $doc_result = mysqli_query($conn, $doc_query); // Changed $connection to $conn here
                        if ($doc_result && mysqli_num_rows($doc_result) > 0) {
                            $doc_row = mysqli_fetch_assoc($doc_result);
                            $document_title = $doc_row['DocumentTitle'];
                            $document_year = $doc_row['DocumentYear'];
                            $document_file = $doc_row['documentfile'];
                ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            
                            <h5 class="card-title"><?php echo $document_title; ?></h5>
                            <p class="card-text">Year: <?php echo $document_year; ?></p>
                            <button class="btn download-btn" onclick="downloadDocument('<?php echo $document_file; ?>')">Download</button>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                } else {
                    echo "<p class='text-center'>No bookmarks found.</p>";
                }
                ?>
            </div>
        </div>
       
    </div>


<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Your custom JavaScript for download functionality -->
<script>
    function downloadDocument(documentFile) {
        // Redirect to the PHP script that serves the file with appropriate headers
        window.location.href = "download.php?file=" + encodeURIComponent(documentFile);
    }
</script>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
