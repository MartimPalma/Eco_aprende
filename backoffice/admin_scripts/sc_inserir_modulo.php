<?php
include_once "../../connections/connection.php";
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);
$titulo = $_POST['titulo'];
$codigo = $_POST['codigo'];
$intro = $_POST['intro'];
$sabias_que = $_POST['sabias_que'];

$target_dir = "../../../eco_aprende/imgs/";
$target_file = $target_dir . basename($_FILES["capa"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is an actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["capa"]["tmp_name"]);
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
if ($_FILES["capa"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if file was successfully uploaded
if (move_uploaded_file($_FILES["capa"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["capa"]["name"])) . " has been uploaded.";

    // Resize image
    $resized_filename = "resized_" . basename($_FILES["capa"]["name"]);
    $resized_file = $target_dir . $resized_filename;;
    resize_image($target_file, $resized_file, 453, 255);
} else {
    echo "Sorry, there was an error uploading your file.";
}

// Function to resize image to a fixed size using GD library
function resize_image($source_file, $target_file, $width, $height) {
    list($source_width, $source_height, $source_type) = getimagesize($source_file);

    $source_image = create_source_image($source_file, $source_type);
    $resized_image = imagecreatetruecolor($width, $height);

    // Preserve transparency for PNG and GIF
    if ($source_type == IMAGETYPE_PNG || $source_type == IMAGETYPE_GIF) {
        imagecolortransparent($resized_image, imagecolorallocatealpha($resized_image, 0, 0, 0, 127));
        imagealphablending($resized_image, false);
        imagesavealpha($resized_image, true);
    }

    imagecopyresampled($resized_image, $source_image, 0, 0, 0, 0, $width, $height, $source_width, $source_height);

    // Save resized image
    save_resized_image($resized_image, $source_type, $target_file);

    imagedestroy($source_image);
    imagedestroy($resized_image);
}

function create_source_image($source_file, $source_type) {
    if ($source_type == IMAGETYPE_JPEG) {
        return imagecreatefromjpeg($source_file);
    } elseif ($source_type == IMAGETYPE_PNG) {
        return imagecreatefrompng($source_file);
    } elseif ($source_type == IMAGETYPE_GIF) {
        return imagecreatefromgif($source_file);
    } else {
        return false;
    }
}

function save_resized_image($resized_image, $source_type, $target_file) {
    if ($source_type == IMAGETYPE_JPEG) {
        imagejpeg($resized_image, $target_file, 90); // 90 is the quality percentage
    } elseif ($source_type == IMAGETYPE_PNG) {
        imagepng($resized_image, $target_file, 9); // 9 is the compression level (0 - no compression, 9 - maximum compression)
    } elseif ($source_type == IMAGETYPE_GIF) {
        imagegif($resized_image, $target_file);
    }
}

// Insert into 'infos' table
$stmt3 = mysqli_stmt_init($link);
if (mysqli_stmt_prepare($stmt3, "INSERT INTO infos (sabias_que, intro, video) VALUES (?,?, 2)")) {
    mysqli_stmt_bind_param($stmt3, 'ss', $sabias_que, $intro);
    if (!mysqli_stmt_execute($stmt3)) {
        echo "Error executing infos insert: " . mysqli_stmt_error($stmt3);
    }
    mysqli_stmt_close($stmt3);
} else {
    echo "Error preparing infos insert: " . mysqli_error($link);
}

$id2 = mysqli_insert_id($link);
$target_file = $resized_file;
$trimmedString = substr($target_file, 26);
// Insert into 'modulos' table
if (mysqli_stmt_prepare($stmt, "INSERT INTO modulos (ref_infos, titulo, capa,  codigo) VALUES (?, ?, ?, ?)")) {
    mysqli_stmt_bind_param($stmt, 'isss', $id2, $titulo, $trimmedString, $codigo);
    if (!mysqli_stmt_execute($stmt)) {
        echo "Error executing modulos insert: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing modulos insert: " . mysqli_error($link);
}

mysqli_close($link);
?>
