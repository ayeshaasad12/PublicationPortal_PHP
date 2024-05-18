<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Manage Documents</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff; /* Changed green to blue */
            color: white;
        }
        .edit-btn, .delete-btn {
            padding: 6px 12px;
            margin-right: 5px;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff; /* Changed green to blue */
        }
        .delete-btn {
            background-color: #dc3545;
        }
        input[type="text"],
        textarea,
        input[type="submit"] {
            width: calc(100% - 20px); /* Adjusted width */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff; /* Changed green to blue */
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3; /* Lighter shade of blue */
        }
        .action-buttons {
            margin-top: 10px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();

                $('table tbody tr').each(function() {
                    var documentTitle = $(this).find('td:nth-child(2)').text().toLowerCase();

                    if (documentTitle.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Manage Documents</h2>

        <input type="text" id="searchInput" placeholder="Search by document title...">

        <?php
        // Database configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "publication_portal";

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if edit or delete actions are triggered
        if (isset($_GET['action']) && isset($_GET['documentID'])) {
            $action = $_GET['action'];
            $id = $_GET['documentID'];

            if ($action === 'edit') {
                // Display edit form
                $sql = "SELECT * FROM documents WHERE documentID = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $documentTitle = $row['DocumentTitle'];
                    $documentYear = $row['DocumentYear'];
                    $domainID = $row['DomainID'];
                    $publicationID = $row['PublicationID'];
                    $typeID = $row['TypeID'];

                    // Fetch domain, publication, and type names from respective tables
                    $domainQuery = "SELECT DomainName FROM domain WHERE DomainID = $domainID";
                    $domainResult = $conn->query($domainQuery);
                    $domainName = ($domainResult->num_rows > 0) ? $domainResult->fetch_assoc()['DomainName'] : '';

                    $publicationQuery = "SELECT PublicationName FROM publication WHERE PublicationID = $publicationID";
                    $publicationResult = $conn->query($publicationQuery);
                    $publicationName = ($publicationResult->num_rows > 0) ? $publicationResult->fetch_assoc()['PublicationName'] : '';

                    $typeQuery = "SELECT TypeName FROM type WHERE TypeID = $typeID";
                    $typeResult = $conn->query($typeQuery);
                    $typeName = ($typeResult->num_rows > 0) ? $typeResult->fetch_assoc()['TypeName'] : '';

                    echo "<form method='post' action=''>
                            <input type='hidden' name='id' value='$id'>
                            <label for='documentTitle'>Document Title:</label>
                            <input type='text' id='documentTitle' name='documentTitle' value='$documentTitle' required>

                            <label for='documentYear' >Document Year:</label>
                            <input type='number' id='documentYear' name='documentYear' value='$documentYear' required> <br><br>

                            <label for='domainName'>Domain:</label>
                            <input type='text' id='domainName' name='domainName' value='$domainName' required>

                            <label for='publicationName'>Publication:</label>
                            <input type='text' id='publicationName' name='publicationName' value='$publicationName' required>

                            <label for='typeName'>Type:</label>
                            <input type='text' id='typeName' name='typeName' value='$typeName' required>

                            <input type='submit' name='update' value='Update Document'>
                            <input type='button' value='Choose Another File' onclick='location.href=\"upload.php\"'>
                        </form>";
                } else {
                    echo "<p>Document not found.</p>";
                }
            } elseif ($action === 'delete') {
                // Delete document from the database
                $sql = "DELETE FROM documents WHERE documentID = $id";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Document deleted successfully!</p>";
                } else {
                    echo "Error deleting document: " . $conn->error;
                }
            }
        }

        // Check if update form is submitted
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $documentTitle = $_POST['documentTitle'];
            $documentYear = $_POST['documentYear'];
            $domainName = $_POST['domainName'];
            $publicationName = $_POST['publicationName'];
            $typeName = $_POST['typeName'];

                        // Get DomainID
            $domainQuery = "SELECT DomainID FROM domain WHERE DomainName = '$domainName'";
            $domainResult = $conn->query($domainQuery);
            $domainID = ($domainResult->num_rows > 0) ? $domainResult->fetch_assoc()['DomainID'] : '';

            // Get PublicationID
            $publicationQuery = "SELECT PublicationID FROM publication WHERE PublicationName = '$publicationName'";
            $publicationResult = $conn->query($publicationQuery);
            $publicationID = ($publicationResult->num_rows > 0) ? $publicationResult->fetch_assoc()['PublicationID'] : '';

            // Get TypeID
            $typeQuery = "SELECT TypeID FROM type WHERE TypeName = '$typeName'";
            $typeResult = $conn->query($typeQuery);
            $typeID = ($typeResult->num_rows > 0) ? $typeResult->fetch_assoc()['TypeID'] : '';

            // Update document in the database
            $sql = "UPDATE documents SET DocumentTitle = '$documentTitle', DocumentYear = '$documentYear', DomainID = '$domainID', PublicationID = '$publicationID', TypeID = '$typeID' WHERE documentID = $id";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Document updated successfully!</p>";
            } else {
                echo "Error updating document: " . $conn->error;
            }
        }

        // Display all documents in a table
        $sql = "SELECT * FROM documents";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            echo "<table>";
            echo "<tr>
                    <th>Document ID</th>
                    <th>Document Title</th>
                    <th>Document Year</th>
                    <th>Domain</th>
                    <th>Publication</th>
                    <th>Type</th>
                    <th>Action</th>
                  </tr>";

            while ($row = $result->fetch_assoc()) {
                $documentID = $row['documentID'];
                $documentTitle = $row['DocumentTitle'];
                $documentYear = $row['DocumentYear'];
                $domainID = $row['DomainID'];
                $publicationID = $row['PublicationID'];
                $typeID = $row['TypeID'];

                // Fetch domain, publication, and type names from respective tables
                $domainQuery = "SELECT DomainName FROM domain WHERE DomainID = $domainID";
                $domainResult = $conn->query($domainQuery);
                $domainName = ($domainResult->num_rows > 0) ? $domainResult->fetch_assoc()['DomainName'] : '';

                $publicationQuery = "SELECT PublicationName FROM publication WHERE PublicationID = $publicationID";
                $publicationResult = $conn->query($publicationQuery);
                $publicationName = ($publicationResult->num_rows > 0) ? $publicationResult->fetch_assoc()['PublicationName'] : '';

                $typeQuery = "SELECT TypeName FROM type WHERE TypeID = $typeID";
                $typeResult = $conn->query($typeQuery);
                $typeName = ($typeResult->num_rows > 0) ? $typeResult->fetch_assoc()['TypeName'] : '';

                echo "<tr>";
                echo "<td>$documentID</td>";
                echo "<td>$documentTitle</td>";
                echo "<td>$documentYear</td>";
                echo "<td>$domainName</td>";
                echo "<td>$publicationName</td>";
                echo "<td>$typeName</td>";
                echo "<td class='action-buttons'>
                        <a href='?action=edit&documentID=$documentID' class='edit-btn'>Edit</a>
                        <a href='?action=delete&documentID=$documentID' class='delete-btn'>Delete</a>
                      </td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No documents found.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
        <a href="upload.php">Upload Document</a>
    </div>
</body>
</html>

