<?php
$target_dir = "../../../eco_aprende/imgs/";
$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Database credentials
$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Check if image file is an actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["avatar"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.";

        // Include connection file
        include_once "../../connections/connection.php";

        // Establish database connection
        $link = new_db_connection();
        if (!$link) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare an insert statement
        $stmt = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt, "INSERT INTO avatares (imagem, ref_perfis) VALUES (?, 2)")) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $target_file);

            // Set parameters and execute
            $target_file = basename($_FILES["avatar"]["name"]);
            if (mysqli_stmt_execute($stmt)) {
                echo "The file name has been inserted into the database.";
            } else {
                echo "Execute Error: " . mysqli_stmt_error($stmt);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Statement Preparation Error: " . mysqli_stmt_error($stmt);
        }

        // Close connection
        mysqli_close($link);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
