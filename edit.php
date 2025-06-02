<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';
if (!isset($_GET['id'])) {
    echo "Invalid post ID.";
    exit();
}
$id = $_GET['id'];
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows != 1) {
    echo "Post not found.";
    exit();
}
$post = $result->fetch_assoc();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST['title'];
    $new_content = $_POST['content'];

    $update = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssi", $new_title, $new_content, $id);

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
    <title>Edit Post</title>
</head>
<body>
    <h2>Edit Post</h2>
    <form method="POST" action="">
        Title:<br>
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>
        Content:<br>
        <textarea name="content" rows="5" cols="40" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>
        <input type="submit" value="Update">
    </form>
    <br>
    <a href="index.php">← Back to Posts</a>
</body>
</html>