<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Your custom CSS -->
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>
    <?php
    session_start();
    $conn = new mysqli('localhost', 'root', '', 'publication_portal');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $city = $_POST['city'];
            $country = $_POST['country'];
            $institute = $_POST['institute'];
            $phone_number = $_POST['phone_number'];
            
            // Handle the profile image upload
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                $targetDir = "uploads/";
                $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                
                // Check if file is an actual image
                $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
                if($check !== false) {
                    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                        $profile_image = $targetFile;
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        $profile_image = '';
                    }
                } else {
                    echo "File is not an image.";
                    $profile_image = '';
                }
            } else {
                $profile_image = $_POST['existing_profile_image'];
            }

            // Prepare update query
            $sql = "UPDATE users SET city='$city', country='$country', institute='$institute', 
                    phone_number='$phone_number', profile_image='$profile_image' WHERE id='$userId'";

            if ($conn->query($sql) === TRUE) {
                echo "Profile updated successfully";
            } else {
                echo "Error updating profile: " . $conn->error;
            }
        }

        // Fetch current user data for pre-filling the form
        $sql = "SELECT * FROM users WHERE id='$userId'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" class="form-control" name="city" value="<?php echo $user['city']; ?>">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" class="form-control" name="country" value="<?php echo $user['country']; ?>">
                </div>
                <div class="form-group">
                    <label>Institute</label>
                    <input type="text" class="form-control" name="institute" value="<?php echo $user['institute']; ?>">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" value="<?php echo $user['phone_number']; ?>">
                </div>
                <div class="form-group">
                    <label>Profile Image</label>
                    <input type="file" class="form-control-file" name="profile_image">
                    <!-- Store existing profile image path to use if no new image is uploaded -->
                    <input type="hidden" name="existing_profile_image" value="<?php echo $user['profile_image']; ?>">
                    <?php if ($user['profile_image']) { ?>
                        <img src="<?php echo $user['profile_image']; ?>" alt="Profile Image" style="max-width: 150px; margin-top: 10px;">
                    <?php } ?>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
            <?php
        } else {
            echo "User not found";
        }
    } else {
        echo "Please login to edit your profile";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
