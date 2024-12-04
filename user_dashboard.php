<?php
include 'db_connect.php';

// Assuming user is logged in and their ID is stored in a session
session_start();
$userID = $_SESSION['userID']; // Replace with actual session variable

// Fetch user details
$userQuery = "SELECT Name, email FROM AccountUser WHERE userID = $userID";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();

// Fetch movies booked by the user
$bookedMoviesQuery = "
    SELECT m.Title, h.Name AS HallName, h.Location, s.StartTime, s.EndTime
    FROM Ticket t
    JOIN Session s ON t.SessionID = s.SessionID
    JOIN Movie m ON s.MovieID = m.MovieID
    JOIN Hall h ON s.HallID = h.HallID
    WHERE t.UserID = $userID
";
$bookedMovies = $conn->query($bookedMoviesQuery);

// Fetch reviews by the user
$reviewsQuery = "
    SELECT m.Title, r.Rating, r.Comment, r.ReviewDate
    FROM Review r
    JOIN Movie m ON r.MovieID = m.MovieID
    WHERE r.UserID = $userID
";
$reviews = $conn->query($reviewsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['Name']); ?></h1>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

    <h2>Movies Booked</h2>
    <table>
        <tr>
            <th>Movie Title</th>
            <th>Hall Name</th>
            <th>Location</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php while ($row = $bookedMovies->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['Title']); ?></td>
            <td><?php echo htmlspecialchars($row['HallName']); ?></td>
            <td><?php echo htmlspecialchars($row['Location']); ?></td>
            <td><?php echo htmlspecialchars($row['StartTime']); ?></td>
            <td><?php echo htmlspecialchars($row['EndTime']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Your Reviews</h2>
    <table>
        <tr>
            <th>Movie Title</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Review Date</th>
        </tr>
        <?php while ($row = $reviews->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['Title']); ?></td>
            <td><?php echo htmlspecialchars($row['Rating']); ?></td>
            <td><?php echo htmlspecialchars($row['Comment']); ?></td>
            <td><?php echo htmlspecialchars($row['ReviewDate']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
