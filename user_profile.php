<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'publication_portal');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = null;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id='$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        $error = "User not found";
    }
} else {
    $error = "Please login to view your profile";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Css -->
    <link rel="stylesheet" href="style.css">

    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <style>
        /* Import Font Dancing Script */
        @import url(https://fonts.googleapis.com/css?family=Dancing+Script);

        * {
            margin: 0;
        }

        body {
            background-color: white;
            font-family: Arial;
            overflow: hidden;
        }

     #center{
        text-align: center;
        justify-content: center;
        align-items: center;
        font-weight: bold;
     }

        .title {
            font-family: 'Dancing Script', cursive;
            padding-top: 15px;
            position: absolute;
            left: 45%;
        }

          .icon-count {
            background-color: #ff0000;
            color: #fff;
            float: right;
            font-size: 11px;
            left: -25px;
            padding: 2px;
            position: relative;
        }

        /* End */

        /* Sidenav */
        .sidebar {
        flex: 0 0 20%;
        background-color: #007bff;
        color: #fff;
        padding: 20px;
        margin-right: 1%;
        margin-top: 0px;
        float: left;
        clear: left;
        padding-bottom: 753px;
        width:18%;
    }
    .sidebar .class{
        position: fixed;
    }

        .profile {
            margin-bottom: 20px;
            margin-top: -12px;
            text-align: center;
        }

        .profile img {
            border-radius: 50%;
           height: 120px;
           width:120px;
        }

        .name {
            font-size: 20px;
            font-weight: bold;
            padding-top: 20px;
        }

        .job {
            font-size: 16px;
            font-weight: bold;
            padding-top: 10px;
        }

        .url, hr {
            text-align: center;
        }

        .url hr {
            margin-left: 20%;
            width: 60%;
        }

        .url a {
            color: #818181;
            display: block;
            font-size: 20px;
            margin: 10px 0;
            padding: 6px 8px;
            text-decoration: none;
        }

        .url a:hover, .url .active {
            background-color: #007bff;
            border-radius: 28px;
            color: white;
            margin-left: 14%;
            width: 65%;
        }

        /* End */

        /* Main */
        .main {
            margin-top: 2%;
            margin-left: 29%;
            font-size: 28px;
            padding: 0 10px;
            width: 58%;
        }

        .main h2 {
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .main .card {
            background-color: #fff;
            border-radius: 18px;
            box-shadow: 1px 1px 8px 0 grey;
            height: auto;
            margin-bottom: 20px;
            padding: 20px 0 20px 50px;
        }

        .main .card table {
            border: none;
            font-size: 16px;
            height: 270px;
            width: 80%;
        }

        .edit {
            position: absolute;
            color: #e7e7e8;
            right: 14%;
        }

       
    </style>
</head>
<body>
   

   

    <!-- Sidenav -->
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
    <!-- End -->

    <!-- Main -->
    <div class="main">
    <?php if (isset($user)): ?>
            <div class="profile">
                <img src="<?php echo $user['profile_image']; ?>" alt="Profile Image" >
                <div class="name"><?php echo $user['username']; ?></div>
                <div class="job"><?php echo $user['email']; ?></div>
            </div>

            <div class="sidenav-url">
                <div class="url">
                    <a href="update_profile.php" class="active">Edit Profile</a>
                    <hr align="center">
                </div>
            </div>
        <?php else: ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
       
        <div class="card">
            <div class="card-body"  id="center">
                
                <?php if (isset($user)): ?>
                    <table>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td><?php echo $user['username']; ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><?php echo $user['email']; ?></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td><?php echo $user['institute']; ?></td>
                            </tr>
                            <tr>
                                <td>Hobbies</td>
                                <td>:</td>
                                <td><?php echo $user['city']; ?></td>
                            </tr>
                            <tr>
                                <td>Job</td>
                                <td>:</td>
                                <td><?php echo $user['country']; ?></td>
                            </tr>
                            <tr>
                                <td>Skill</td>
                                <td>:</td>
                                <td><?php echo $user['phone_number']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- End -->
</body>
</html>
