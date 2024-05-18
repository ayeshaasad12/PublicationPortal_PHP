<?php

session_start();

// Include database connection
include_once 'connection.php';

// Check if user is logged in and redirect if not
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data from database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Database query failed.");
}

$user = mysqli_fetch_assoc($result);

// Fetch publications from the database based on filters and search query
$filterType = isset($_GET['type']) ? $_GET['type'] : '';
$filterDomain = isset($_GET['domain']) ? $_GET['domain'] : '';
$filterPublication = isset($_GET['publication']) ? $_GET['publication'] : '';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Construct the SQL query based on filters and search query
$query = "SELECT documents.*, domain.DomainName, publication.PublicationName, type.TypeName 
          FROM documents
          LEFT JOIN domain ON documents.DomainID = domain.DomainID
          LEFT JOIN publication ON documents.PublicationID = publication.PublicationID
          LEFT JOIN type ON documents.TypeID = type.TypeID
          WHERE 1=1";

// Array to store filter parameters
$params = [];

if (!empty($filterType)) {
    $query .= " AND type.TypeName = ?";
    $params[] = $filterType;
}

if (!empty($filterDomain)) {
    $query .= " AND domain.DomainName = ?";
    $params[] = $filterDomain;
}

if (!empty($filterPublication)) {
    $query .= " AND publication.PublicationName = ?";
    $params[] = $filterPublication;
}

if (!empty($searchQuery)) {
    $query .= " AND (documents.DocumentTitle LIKE ? OR domain.DomainName LIKE ? OR type.TypeName LIKE ? OR publication.PublicationName LIKE ?)";
    $searchParam = "%$searchQuery%";
    $params = array_merge($params, array_fill(0, 4, $searchParam));
}

$stmt = mysqli_prepare($conn, $query);

// Bind parameters dynamically
if (!empty($params)) {
    $types = str_repeat('s', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Database query failed.");
}

$publications = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close prepared statement
mysqli_stmt_close($stmt);

// Close database connection
mysqli_close($conn);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publications Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css">
<style>
        #typeFilterSection {
            margin-bottom: 20px;
        }

        #publicationList {
            margin-top: 20px;
        }

        .main-content {
            display: flex;
            flex-direction: column;
        }

        .sidebar {
            /* Sidebar styles */
        }

        .card {
            width: calc(100% - 15%);
            margin-bottom: 20px;
            /* Adjust as needed */
        }

        .filter-sections {
           
            align-items: center;
            margin-top: 10px;
            float:right;
        }

        .filter-sections select,
        .filter-sections input[type="text"] {
            flex: 1;
            margin-right: 10px;
        }

</style>
</head>
<body>

<div class="container">
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-section">
            <?php if (isset($user['profile_image']) && !empty($user['profile_image'])): ?>
                <img src="<?php echo $user['profile_image']; ?>" alt="Profile Image" class="profile-img">
            <?php endif; ?>
            <a href="logout.php"><button class="logout-btn">Logout</button></a>
        </div>

        <form id="filterForm" method="GET" action="index.php">
            <div class="filter-section" id="typeFilterSection">
                <div class="filter-through-type">
                    <label><input type="radio" name="type" value="" <?php if ($filterType === '') echo 'checked'; ?>>All Types</label>
                    <label><input type="radio" name="type" value="Thesis" <?php if ($filterType === 'Thesis') echo 'checked'; ?>>Thesis</label>
                    <label><input type="radio" name="type" value="Research Paper" <?php if ($filterType === 'Research Paper') echo 'checked'; ?>>Research Paper</label>
                    <label><input type="radio" name="type" value="Article" <?php if ($filterType === 'Article') echo 'checked'; ?>>Article</label>
                    <div class="filter-sections">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
                </div>
          
            </div>

            <div class="main_div">
                <input style="width: 100%;" type="text" name="search" id="searchInput" class="form-control" placeholder="Search..." value="<?php echo $searchQuery; ?>">
                <div class="filter-section">
                    <select name="domain" id="domainFilter" class="custom-select">
                        <option value="" <?php if ($filterDomain === '') echo 'selected'; ?>>All Domains</option>
                        <option value="Computer Science" <?php if ($filterDomain === 'Computer Science') echo 'selected'; ?>>Computer Science</option>
                        <option value="AI" <?php if ($filterDomain === 'AI') echo 'selected'; ?>>AI</option>
                        <option value="pharmacy" <?php if ($filterDomain === 'pharmacy') echo 'selected'; ?>>Pharmacy</option>
                    </select>
                    <select name="publication" id="publicationFilter" class="custom-select">
                        <option value="" <?php if ($filterPublication === '') echo 'selected'; ?>>All Publications</option>
                        <option value="Journals" <?php if ($filterPublication === 'Journals') echo 'selected'; ?>>Journals</option>
                        <option value="Conference" <?php if ($filterPublication === 'Conference') echo 'selected'; ?>>Conference</option>
                    </select>
                  
                </div>
        
            </div>
        </form>

        <!-- List of Publications -->
        <div id="publicationList">
            <?php foreach ($publications as $publication): ?>
                <div class="card">
                    <div class="card-header"><div class="profile-img"></div><b><?php echo $publication['DocumentTitle']; ?></b></div>
                    <div class="card-body">
                        <p><b>Domain:</b> <?php echo $publication['DomainName']; ?></p>
                        <p><b>Type:</b> <?php echo $publication['TypeName']; ?></p>
                        <p><b>Publication:</b> <?php echo $publication['PublicationName']; ?></p>
                        <p><b>Year:</b> <?php echo $publication['DocumentYear']; ?></p>
                        <button class="btn download-btn" onclick="downloadDocument('<?php echo $publication['documentfile']; ?>')">Download</button>
                        <button class="btn download-btn">Add Bookmark</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="pagination"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="script.js"></script>

<script>
    function downloadDocument(documentFile) {
        // Redirect to the PHP script that serves the file with appropriate headers
        window.location.href = "download.php?file=" + encodeURIComponent(documentFile);
    }
</script>
</body>
</html>

