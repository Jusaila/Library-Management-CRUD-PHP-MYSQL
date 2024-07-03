<?php
session_start();
include 'database.php'; // Database connection
include('message.php');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database.php';

// Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch product details from the database based on the ID
    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    if (!$book) {
        echo "Book not found.";
        exit;
    }
} else {
    echo "Invalid Book ID.";
    exit;
}

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $author = trim($_POST["author"]);
    $publication_year = trim($_POST["publication_year"]);

    // Update to database
    $sql = "UPDATE books SET title = ?, author = ?, publication_year = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $title, $author, $publication_year, $id);

    if ($stmt->execute() === TRUE) {
        $_SESSION['message'] = "Book Updated Successfully";
        header("Location: book_list.php");
        exit();
    } else {
        $_SESSION['message'] = "Book Not Updated";
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit-Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-image: url('images/library-filled-with-books.jpg'); /* Replace with your image file path */
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Book</h2>
        <form method="POST" action="book_edit.php?id=<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Publication Year</label>
                <input type="text" class="form-control" id="publication_year" name="publication_year" value="<?php echo htmlspecialchars($book['publication_year']); ?>">
            </div>
            <br>
            <div class="d-flex justify-content-between">
                <a href="book_list.php" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update Book</button>
            </div>
          
        </form>
    </div>
</body>
</html>
