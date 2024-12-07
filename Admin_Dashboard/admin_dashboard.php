<?php
session_start();

// Hardcoded admin credentials
$adminUsername = 'Arnab';
$adminPassword = '22701066';

// Handle admin login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $adminUsername && $password === $adminPassword) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_dashboard.php");
    exit();
}

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
    </head>
    <body>
        <h2>Admin Login</h2>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit" name="login">Login</button>
        </form>
    </body>
    </html>
    <?php
    exit();
}

// Include database connection
require '../connection/db_connect.php';

// Handle user deletion
if (isset($_GET['delete'])) {
    $usernameToDelete = $_GET['delete'];
    try {
        $stmt = $conn->prepare("DELETE FROM AccountUser WHERE username = :username");
        $stmt->bindParam(':username', $usernameToDelete);
        $stmt->execute();
        header("Location: admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Error deleting user: " . $e->getMessage());
    }
}

// Fetch user data
try {
    $stmt = $conn->prepare("SELECT username, email, name, phone FROM AccountUser");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching user data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/Admin_Dashboard.css">
</head>
<body>
    <!-- Navbar -->
    <header class="header">
        <div class="logo">
            <a href="../admin_dashboard/admin_dashboard.php">Admin Panel</a>
        </div>
        <nav>
            <ul>
                <li><a href="../admin_dashboard/admin_dashboard.php">UserInfo</a></li>
                <li><a href="../admin_dashboard/TotalMovieBooked.php">Ticket Booked</a></li>
                <li><a href="../admin_dashboard/Allreviews.php">Reviews</a></li>
                <li><a href="../admin_dashboard/Movie_List.php">Movie List</a></li>
                <li><a href="../loginPage/loginpage.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <div class="about-section">
        <h1>Admin Dashboard</h1>

        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                        <td>
                            <a href="?delete=<?php echo urlencode($user['username']); ?>" 
                               onclick="return confirm('Are you sure you want to delete this user?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="logout-link">
            <a href="?logout=true">Logout</a>
        </div>
    </div>
</body>
</html>
