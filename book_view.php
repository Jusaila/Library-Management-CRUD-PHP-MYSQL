<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database.php';

// Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch book details from the database based on the ID
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: burlywood;
        }
        .container {
            max-width: 800px;
            margin: 100px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn {
            margin-right: 10px;
        }
        .book-cover {
            max-width: 100%;
            height: auto;
        }
        p{
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">View Book</h2>
        <div class="row">
            <div class="col-md-6">
                <?php if (!empty($book['book_cover'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($book['book_cover']); ?>" alt="Book Cover" class="book-cover">
                <?php else: ?>
                    <p>No Image Available</p>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <p style="font-size: 30px;"><?php echo htmlspecialchars($book['title']); ?></p>
                </div>
                <div class="form-group">
                    <label class="form-label">Author</label>
                    <p><?php echo htmlspecialchars($book['author']); ?></p>
                </div>
                <div class="form-group">
                    <label class="form-label">Publication Year</label>
                    <p><?php echo htmlspecialchars($book['publication_year']); ?></p>
                </div>
                <div class="mt-5">
                    <a href="book_list.php" class="btn btn-secondary text-left">Back to List</a>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
