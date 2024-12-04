<?php
include 'db_connect.php';

// Fetch all users
$usersQuery = "
    SELECT au.userID, au.Name, au.email, COUNT(t.TicketID) AS TotalMoviesBooked
    FROM AccountUser au
    LEFT JOIN Ticket t ON au.userID = t.UserID
    GROUP BY au.userID
";
$users = $conn->query($usersQuery);

// Fetch all reviews
$reviewsQuery = "
    SELECT au.Name, m.Title, r.Rating, r.Comment, r.ReviewDate
    FROM Review r
    JOIN AccountUser au ON r.UserID = au.userID
    JOIN Movie m ON r.MovieID = m.MovieID
";
$reviews = $conn->query($reviewsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>User Information</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Total Movies Booked</th>
        </tr>
        <?php while ($row = $users->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['userID']); ?></td>
            <td><?php echo htmlspecialchars($row['Name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['TotalMoviesBooked']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>All Reviews</h2>
    <table>
        <tr>
            <th>User Name</th>
            <th>Movie Title</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Review Date</th>
        </tr>
        <?php while ($row = $reviews->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['Name']); ?></td>
            <td><?php echo htmlspecialchars($row['Title']); ?></td>
            <td><?php echo htmlspecialchars($row['Rating']); ?></td>
            <td><?php echo htmlspecialchars($row['Comment']); ?></td>
            <td><?php echo htmlspecialchars($row['ReviewDate']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
