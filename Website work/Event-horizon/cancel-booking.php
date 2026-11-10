
<?php

require_once 'includes/db.php';
require_once 'includes/auth.php';

requireLogin();

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: my-bookings.php");
    exit;
}

// Get the booking ID
$booking_id = filter_input(INPUT_POST, 'booking_id', FILTER_VALIDATE_INT);

if (!$booking_id || $booking_id < 1) {
    header("Location: my-bookings.php");
    exit;
}

// Delete the booking only if it belongs to the logged-in user
$sql = "DELETE FROM bookings
        WHERE booking_id = :booking_id
        AND user_id = :user_id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'booking_id' => $booking_id,
    'user_id' => $_SESSION['user_id']
]);

// Check whether a booking was actually deleted
if ($stmt->rowCount() > 0) {

    header("Location: my-bookings.php?status=cancelled");

} else {

    header("Location: my-bookings.php?status=notfound");

}

exit;

?>

