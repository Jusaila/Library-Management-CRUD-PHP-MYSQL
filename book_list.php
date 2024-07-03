<?php
session_start();

include 'database.php'; // database connection

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Fetch data from the database

$sql = "SELECT id, title, author, publication_year, book_cover FROM books";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('images/library-filled-with-books.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            margin-top: 20px;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-group {
            display: flex;
            gap: 2px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-success, .btn-warning, .btn-danger {
            margin: 0;
        }
        .btn:hover {
            opacity: 0.85;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div>
       <center><h1 style="color: white;padding:20px;">Welcome To library </h1></center>
    </div>
    <div class="container mt-4">
        <?php include('message.php'); ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Book List</h2>
            <a href="book_create.php" class="btn btn-primary">Add New Book</a>
        </div>
        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publication Year</th>
                    <th>Cover-Photo</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td><?php echo htmlspecialchars($row['publication_year']); ?></td>
                        <td>
                                <?php if (!empty($row['book_cover'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($row['book_cover']); ?>" alt="Book Cover" width="100" height="100">
                                <?php else: ?>
                                    No Image Available
                                <?php endif; ?>
                            </td>
                        <td>
                        <a href="book_view.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-md">View</a>
                        <a href="book_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-md">Edit</a>
                        <form action="book_delete.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');" style="margin: 0;">
                            <button type="submit" name="id" value="<?php echo $row['id'];?>" class="btn btn-danger btn-md">Delete</button>
                        </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



</body>

</html>
