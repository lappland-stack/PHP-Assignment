
<?php

require_once 'includes/db.php';
require_once 'includes/auth.php';

requireLogin();

// Retrieve bookings belonging to the logged-in user
$sql = "SELECT
            b.booking_id,
            e.event_name,
            e.description,
            e.event_date
        FROM bookings b
        JOIN EVENTS e ON b.event_id = e.event_id
        WHERE b.user_id = :user_id
        ORDER BY e.event_date";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'user_id' => $_SESSION['user_id']
]);

$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings | Event Horizon</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="icon" href="favicon.webp">
</head>

<body>
<div class="content">

    <header>
        <h1>My Bookings</h1>
        <p>Manage your upcoming technology workshops.</p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="events.php">Events</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="my-bookings.php">My Bookings</a>
        <a href="logout.php">Logout</a>
    </nav>

    <main>

        <section>
            <h2>Your Reservations</h2>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>

                <p class="login-notice">
                    Your booking was successful!
                </p>

            <?php elseif (isset($_GET['status']) && $_GET['status'] === 'cancelled'): ?>

                <p class="login-notice">
                    Your booking has been cancelled.
                </p>

            <?php endif; ?>

        </section>

        <div class="event-grid">

            <?php if (count($bookings) > 0): ?>

                <?php foreach ($bookings as $booking): ?>

                    <article class="event-card">

                        <h3>
                            <?= htmlspecialchars($booking['event_name']) ?>
                        </h3>

                        <p>
                            <?= htmlspecialchars($booking['description']) ?>
                        </p>

                        <p class="event-date">
                            <?= date('j F Y · H:i', strtotime($booking['event_date'])) ?>
                        </p>

                        <form action="cancel-booking.php" method="POST">

                            <input
                                type="hidden"
                                name="booking_id"
                                value="<?= (int) $booking['booking_id'] ?>"
                            >

                            <button class="cancel-button" type="submit">
                                Cancel Booking
                            </button>

                        </form>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <p>You haven't booked any events yet.</p>

                <a class="main-button" href="events.php">
                    Browse Events
                </a>

            <?php endif; ?>

        </div>

    </main>

    <footer>
        <p>&copy; 2026 Event Horizon</p>
    </footer>

</div>
</body>
</html>

