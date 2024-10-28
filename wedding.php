<?php
// Handle image upload
if (isset($_POST['submit'])) {
    $target_dir = "uploads/"; // Directory where images will be uploaded

    // Check if the uploads directory exists; if not, create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory with write permissions
    }

    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (set to 5MB max)
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars($image_name). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        header {
            background-color: #333;
            padding: 20px;
            text-align: center;
            color: white;
        }

        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1.2rem;
        }

        .container {
            padding: 40px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery img:hover {
            transform: scale(1.05);
        }

        .description {
            text-align: center;
            margin: 50px 0;
        }

        .description h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #6c757d;
        }

        .description p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        footer p {
            font-size: 1rem;
        }

        .upload-form {
            text-align: center;
            margin-bottom: 50px;
        }

        .upload-form input[type="file"] {
            margin-bottom: 10px;
        }

        .upload-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-form input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <header>
        <h1>Wedding Portfolio</h1>
        <p>Capturing timeless moments of love and celebration.</p>
    </header>

    <div class="container">
        <div class="description">
            <h2>Our Wedding Collections</h2>
            <p>Each wedding is unique, and we believe in capturing every precious moment beautifully. Browse our collection of weddings we’ve had the pleasure of documenting.</p>
        </div>

        <!-- Image upload form -->
        <div class="upload-form">
            <h2>Upload New Wedding Image</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="image" accept="image/*" required>
                <br>
                <input type="submit" name="submit" value="Upload Image">
            </form>
        </div>

        <div class="gallery">
            <!-- Display existing gallery images -->
            <img src="images/wedding01.jpg" alt="Wedding Image 1">
            <img src="images/wedding02.jpg" alt="Wedding Image 2">
            <img src="images/wedding03.jpg" alt="Wedding Image 3">
            <img src="images/wedding04.jpg" alt="Wedding Image 4">
            <img src="images/wedding05.jpg" alt="Wedding Image 5">

            <!-- Dynamically display uploaded images from the 'uploads' folder -->
            <?php
            $dir = "uploads/";
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        if ($file != "." && $file != "..") {
                            echo '<img src="'.$dir.$file.'" alt="Uploaded Image">';
                        }
                    }
                    closedir($dh);
                }
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 PhotoManager Pro. All Rights Reserved.</p>
    </footer>

</body>
</html>
