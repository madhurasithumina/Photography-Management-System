<?php
// Include database configuration file
include 'config.php';

// Fetch booked dates from the database
$query = "SELECT event_date FROM bookings";
$result = mysqli_query($conn, $query);

$bookedDates = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookedDates[] = $row['event_date'];
}

// Insert booking into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);

    $query = "INSERT INTO bookings (customer_name, email, phone, event_type, location, event_date) 
              VALUES ('$customer_name', '$email', '$phone', '$event_type', '$location', '$event_date')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Booking added successfully!'); window.location.href='read_booking.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Photography</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/background.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-container input, .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #2980b9;
        }

        .error {
            color: red;
            font-size: 14px;
            display: none;
            margin-bottom: 10px;
        }

        .flatpickr-day.available {
            background-color: #27ae60 !important; /* Green for available dates */
            color: white !important;
        }

        .flatpickr-day.disabled {
            background-color: #f5f5f5 !important; /* Gray for booked dates */
            color: #ccc !important;
            pointer-events: none; /* Make them unclickable */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Booked dates from PHP
            const bookedDates = <?php echo json_encode($bookedDates); ?>;

            // Initialize Flatpickr
            flatpickr("input[name='event_date']", {
                minDate: "today", // Prevent selecting past dates
                dateFormat: "Y-m-d",
                disable: bookedDates, // Disable booked dates
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    // Highlight available dates
                    const date = dayElem.dateObj.toISOString().split('T')[0];
                    if (!bookedDates.includes(date)) {
                        dayElem.classList.add("available");
                    }
                }
            });
        });
    </script>
</head>
<body>

<div class="form-container">
    <h2>Photography Booking</h2>

    <form name="bookingForm" action="" method="POST">
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name">
        <span id="nameError" class="error">Please enter your name</span>

        <label for="email">Email:</label>
        <input type="email" name="email">
        <span id="emailError" class="error">Please enter a valid email</span>

        <label for="phone">Phone:</label>
        <input type="text" name="phone">
        <span id="phoneError" class="error">Please enter a valid 10-digit phone number</span>

        <label for="event_type">Event Type:</label>
        <select name="event_type" required>
            <option value="">Select Event Type</option>
            <option value="Wedding">Wedding</option>
            <option value="Indoor">Indoor</option>
            <option value="Birthday">Birthday</option>
            <option value="Other">Other</option>
        </select>

        <label for="location">Location:</label>
        <input type="text" name="location" required>
        <span id="locationError" class="error">Please enter the event location</span>

        <label for="event_date">Event Date:</label>
        <input type="text" name="event_date">
        <span id="dateError" class="error">Please select a date</span>

        <button type="submit">Add Booking</button>
    </form>
</div>

</body>
</html>
