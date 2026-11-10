<?php

require_once'includes/db.php';
require_once 'includes/auth.php';

//Make sure the user is logged in
requirelogin();

//only accepts POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: events.php");
    exit;
}


// Get the event ID from the submitted form
$event_id = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);

if (!$event_id || $event_id < 1) {
    header("Location: events.php");
    exit;
}

try {

    // Start a database transaction
    $pdo->beginTransaction();

    // Find and lock the selected event
    $sql = "SELECT event_id, capacity
            FROM EVENTS
            WHERE event_id = :event_id
            FOR UPDATE";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['event_id' => $event_id]);

    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        throw new Exception("Event not found.");
    }

    // Count existing bookings for this event
    $sql = "SELECT COUNT(*)
            FROM bookings
            WHERE event_id = :event_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['event_id' => $event_id]);

    $booking_count = $stmt->fetchColumn();

    // Check whether the event is full
    if ($booking_count >= $event['capacity']) {
        throw new Exception("Sorry, this event is fully booked.");
    }

    // Check whether the user has already booked this event
    $sql = "SELECT COUNT(*)
            FROM bookings
            WHERE user_id = :user_id
            AND event_id = :event_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'event_id' => $event_id
    ]);

    if ($stmt->fetchColumn() > 0) {
        throw new Exception("You have already booked this event.");
    }

    // Insert the new booking
    $sql = "INSERT INTO bookings (user_id, event_id)
            VALUES (:user_id, :event_id)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'event_id' => $event_id
    ]);

    // Save the transaction
    $pdo->commit();

    header("Location: my-bookings.php?status=success");
    exit;

} catch (Exception $e) {

    // Undo database changes if something went wrong
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Return to the events page with an error message
    header("Location: events.php?error=" . urlencode($e->getMessage()));
    exit;

}

?>
