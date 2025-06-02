<?php
include 'database.php';
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    if($result->num_rows === 1){
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])){
            $_SESSION['username'] = $username;
            echo "Login successful.<a href='index.php'>Go to Home</a>";
        }else{
            echo "Invalid password.";
        }
    }else{
        echo "Username not found.";
    }
}
?>
<h2>Login</h2>
<form method="POST" action="">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>