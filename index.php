<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Blog</title>
</head>
<body>
    <h2>Welcome,  <?php echo $_SESSION['username']; ?></h2>
    <a href="add.php">+ Add New Post</a> | 
    <a href="logout.php">Logout</a>
    <hr>
    <h3>All Blog Posts</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php
        $sql = "SELECT * FROM posts ORDER BY time_stamp DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
        <tr>	
            <td><?= $row['id'] ?></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['content'] ?></td>
            <td><?= $row['time_stamp'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php
            endwhile;
        else:
        ?>
        <tr>
            <td colspan="5">No posts found.</td>
        </tr>
        <?php endif; ?>
    </table>
</body>
</html>