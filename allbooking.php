<?php
// Include the database configuration file
include 'config.php';

// Fetch all bookings from the database
$query = "SELECT * FROM bookings";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/background.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .table-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1000px;
            overflow-x: auto;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #2980b9;
        }

        .action-links {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
    <script>
        // Confirm deletion action
        function confirmDelete() {
            return confirm('Are you sure you want to delete this booking?');
        }
    </script>
</head>
<body>

<div class="table-container">
    <h2>All Photography Bookings</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Event Type</th>
            <th>Event Date</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <!-- Loop through each booking record -->
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['event_type']; ?></td>
            <td><?php echo $row['event_date']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <div class="action-links">
                    <!-- Only delete action -->
                    <a href="delete_booking.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();">Delete</a>
                </div>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- Back to Main Menu Button -->
    <a href="admin_dashboard.html" class="back-button">Back to Main Menu</a>
</div>

</body>
</html>
