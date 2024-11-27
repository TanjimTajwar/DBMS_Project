const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');

const app = express();
const port = 3000;

// Body parser middleware
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// MySQL connection setup
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '975321',
    database: 'jobra_movies'
});

// Connect to MySQL database
db.connect((err) => {
    if (err) throw err;
    console.log('Connected to MySQL database');
});

// Handle POST request to add booking info
app.post('/add-ticket', (req, res) => {
    const { username, password, movie_name, showtime, day, total_tickets, ticket_type, hall, mobile, issue_date, gender } = req.body;

    const query = 'INSERT INTO tickets (username, password, movie_name, showtime, day, total_tickets, ticket_type, hall, mobile, issue_date, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

    db.query(query, [username, password, movie_name, showtime, day, total_tickets, ticket_type, hall, mobile, issue_date, gender], (err, result) => {
        if (err) {
            console.log(err);
            res.status(500).send('Error inserting data');
        } else {
            res.status(200).send('Booking added successfully');
        }
    });
});

// Start server
app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});
