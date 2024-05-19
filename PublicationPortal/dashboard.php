<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Your custom CSS -->
</head>
<body>

<div class="container">
    <h2>Welcome to your Dashboard</h2>
    <?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        echo "Logged in as User #" . $_SESSION['user_id'];
        // Display additional user information here
        echo "<br><a href='edit_profile.php'>Edit Profile</a>";
        echo "<br><a href='logout.php'>Logout</a>";
    } else {
        header("Location: login.php");
    }
    ?>
</div>

</body>
</html>