<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$delete_query = "DELETE FROM users WHERE id='$user_id'";

if (mysqli_query($conn, $delete_query)) {
    session_destroy();
    echo "Account deleted successfully.";
    header('Location: register.php');
} else {
    echo "Error deleting account: " . mysqli_error($conn);
}
?>
