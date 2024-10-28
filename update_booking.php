<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM bookings WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $booking = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);

    $query = "UPDATE bookings SET customer_name='$customer_name', email='$email', phone='$phone', event_type='$event_type', location='$location', event_date='$event_date' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Booking updated successfully!'); window.location.href='read_booking.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/background.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-container input,
        .form-container select {
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
    </style>
    <script>
        function validateForm() {
            let isValid = true;
            const name = document.forms["bookingForm"]["customer_name"].value;
            const email = document.forms["bookingForm"]["email"].value;
            const phone = document.forms["bookingForm"]["phone"].value;
            const location = document.forms["bookingForm"]["location"].value;
            const eventDate = document.forms["bookingForm"]["event_date"].value;

            if (name == "") {
                document.getElementById('nameError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('nameError').style.display = 'none';
            }

            if (email == "" || !/^\S+@\S+\.\S+$/.test(email)) {
                document.getElementById('emailError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('emailError').style.display = 'none';
            }

            if (phone == "" || !/^\d{10}$/.test(phone)) {
                document.getElementById('phoneError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('phoneError').style.display = 'none';
            }

            if (location == "") {
                document.getElementById('locationError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('locationError').style.display = 'none';
            }

            if (eventDate == "") {
                document.getElementById('dateError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('dateError').style.display = 'none';
            }

            return isValid;
        }
    </script>
</head>
<body>

<div class="form-container">
    <h2>Update Booking</h2>

    <form name="bookingForm" action="update_booking.php?id=<?php echo $booking['id']; ?>" method="POST" onsubmit="return validateForm();">
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name" value="<?php echo $booking['customer_name']; ?>">
        <span id="nameError" class="error">Please enter your name</span>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $booking['email']; ?>">
        <span id="emailError" class="error">Please enter a valid email</span>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo $booking['phone']; ?>">
        <span id="phoneError" class="error">Please enter a valid 10-digit phone number</span>

        <label for="event_type">Event Type:</label>
        <select name="event_type">
            <option value="Wedding" <?php if ($booking['event_type'] == 'Wedding') echo 'selected'; ?>>Wedding</option>
            <option value="Indoor" <?php if ($booking['event_type'] == 'Indoor') echo 'selected'; ?>>Indoor</option>
            <option value="Birthday" <?php if ($booking['event_type'] == 'Birthday') echo 'selected'; ?>>Birthday</option>
            <option value="Other" <?php if ($booking['event_type'] == 'Other') echo 'selected'; ?>>Other</option>
        </select>

        <label for="location">Location:</label>
        <input type="text" name="location" value="<?php echo $booking['location']; ?>">
        <span id="locationError" class="error">Please enter the event location</span>

        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" value="<?php echo $booking['event_date']; ?>">
        <span id="dateError" class="error">Please select a date</span>

        <button type="submit">Update Booking</button>
    </form>
</div>

</body>
</html>
