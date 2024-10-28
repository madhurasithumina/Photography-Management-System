<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM bookings WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        // After successful deletion, redirect to read_booking.php
        header("Location: read_booking.php?msg=deleted");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
