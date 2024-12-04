<?php
$servername = "localhost";
$username = "root";
$password = "975321";
$dbname = "dbms_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['Email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM AccountUser WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, redirect to homepage
            echo "<script>window.location.href = 'HomePage.php';</script>";
        } else {
            // Incorrect password
            echo "<script>alert('Invalid password. Please try again.'); window.location.href = 'loginpage.html';</script>";
        }
    } else {
        // No user found with this email
        echo "<script>alert('No user found with this email. Please register first.'); window.location.href = 'loginpage.html';</script>";
    }
}

$conn->close();
?>
