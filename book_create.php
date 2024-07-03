<?php
session_start();
include 'database.php'; // Database connection
include('message.php');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the products table exists, and create it if it does not
$checkTableQuery = "SHOW TABLES LIKE 'books'";
$result = $conn->query($checkTableQuery);

if ($result->num_rows == 0) {
    $createTableQuery = "CREATE TABLE books (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        author VARCHAR(200) NOT NULL,
        publication_year INT(4) NOT NULL,
        book_cover VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    if (!$conn->query($createTableQuery)) {
        die("Error creating table: " . $conn->error);
    }
}

// Initialise variables and error variables.
$title = $author = $publication_year = $bookCover = "";
$titleErr = $authorErr = $publication_yearErr = $bookCoverErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $author = trim($_POST["author"]);
    $publication_year = trim($_POST["publication_year"]);
    $bookCover = $_FILES["book_cover"]["name"];

    if (empty($title)) {
        $titleErr = "Title is required";
    }

    if (empty($author)) {
        $authorErr = "Author name is required";
    } 

    if (empty($publication_year)) {
        $publication_yearErr = "Publication year is required";
    } else {
        if (!is_numeric($publication_year) || strlen($publication_year) != 4) {
            $publication_yearErr = "Publication year must be a 4-digit number";
        } else {
            $publication_year = (int)$publication_year;
            if ($publication_year < 1600 || $publication_year > 2024) {
                $publication_yearErr = "Publication year must be between 1600 and 2024";
            }
        }
    }

    if (empty($bookCover)) {
        $bookCoverErr = "Book cover image is required";
    } else {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["book_cover"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["book_cover"]["tmp_name"]);
        if ($check === false) {
            $bookCoverErr = "File is not an image.";
        } else {
            // Check file size
            if ($_FILES["book_cover"]["size"] > 500000) {
                $bookCoverErr = "Sorry, your file is too large.";
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $bookCoverErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }

            // Check if $bookCoverErr is empty
            if (empty($bookCoverErr)) {
                if (!move_uploaded_file($_FILES["book_cover"]["tmp_name"], $target_file)) {
                    $bookCoverErr = "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    // Insert to database if there is no error
    if (empty($titleErr) && empty($authorErr) && empty($publication_yearErr) && empty($bookCoverErr)) {
        $sql = "INSERT INTO books (title, author, publication_year, book_cover)
                VALUES ('$title', '$author', '$publication_year', '$bookCover')";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Book Created Successfully";
            header("location: book_list.php");
            exit();
        } else {
            $_SESSION['message'] = "Book Not Created";
            echo "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-image: url('images/library-filled-with-books.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .text-danger {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Create Book</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
                <small class="text-danger"><?php echo $titleErr; ?></small>
            </div>
            <div class="form-group">
                <label class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>">
                <small class="text-danger"><?php echo $authorErr; ?></small>
            </div>
            <div class="form-group">
                <label class="form-label">Publication Year</label>
                <input type="text" class="form-control" id="publication_year" name="publication_year" value="<?php echo htmlspecialchars($publication_year); ?>">
                <small class="text-danger"><?php echo $publication_yearErr; ?></small>
            </div>
            <div class="form-group">
                <label class="form-label">Book Cover Image</label>
                <input type="file" class="form-control" id="book_cover" name="book_cover">
                <small class="text-danger"><?php echo $bookCoverErr; ?></small>
            </div>
            <div class="d-flex justify-content-between">
                <a href="book_list.php" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>

