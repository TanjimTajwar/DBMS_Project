document.getElementById('ticket-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const movieName = document.getElementById('movie-name').value;
    const showtime = document.getElementById('showtime').value;
    const day = document.getElementById('day').value;
    const totalTickets = document.getElementById('tickets').value;
    const type = document.getElementById('type').value;
    const hall = document.getElementById('hall').value;
    const mobile = document.getElementById('mobile').value;
    const issueDate = document.getElementById('issue-date').value;
    const gender = document.getElementById('gender').value;

    const data = {
        username: username,
        password: password,
        movieName: movieName,
        showtime: showtime,
        day: day,
        totalTickets: totalTickets,
        type: type,
        hall: hall,
        mobile: mobile,
        issueDate: issueDate,
        gender: gender
    };

    // Send data to the backend using fetch
    fetch('http://localhost:3000/bookTicket', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        alert('Ticket booked successfully!');
        document.getElementById('ticket-form').reset();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to book ticket');
    });
});
