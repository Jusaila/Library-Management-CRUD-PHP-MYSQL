<?php
session_start();
include 'database.php'; // Database connection
include('message.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);

    // SQL to delete a record
    $sql = "DELETE FROM books WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Book Deleted Successfully";
            header("location: book_list.php");
            exit();
        } else {
            $_SESSION['message'] = "Book Not Deleted";
            echo "Error executing query.";
        }
        $stmt->close();
    } else {
        echo "Error preparing query.";
    }
    $conn->close();
} else {
    // Redirect to product list if the method is not POST
    header("location: book_list.php");
    exit();
}
