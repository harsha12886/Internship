<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts (title, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Post</title>
</head>
<body>
    <h2>Add New Blog Post</h2>
    <form method="POST" action="">
        Title:<br>
        <input type="text" name="title" required><br><br>
        Content:<br>
        <textarea name="content" rows="5" cols="40" required></textarea><br><br>
        <input type="submit" value="Post">
    </form>
    <br>
    <a href="index.php">← Back to Posts</a>
</body>
</html>