
<?php

require_once 'includes/db.php';

// Retrieve events and calculate remaining places
$sql = "SELECT
            e.event_id,
            e.event_name,
            e.description,
            e.capacity,
            e.event_date,
            e.capacity - (
                SELECT COUNT(*)
                FROM bookings b
                WHERE b.event_id = e.event_id
            ) AS places_left
        FROM EVENTS e
        ORDER BY e.event_date";

$stmt = $pdo->query($sql);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | Event Horizon</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="icon" href="favicon.webp">
</head>

<body>
<div class="content">

    <header>
        <h1>Upcoming Events</h1>
        <p>Find your next opportunity to learn something new.</p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="events.php">Events</a>
        <a href="login.php">Login</a>
    </nav>

    <main>
        <section>
            <h2>Available Workshops</h2>
            <p>Browse our upcoming technology workshops and find one that interests you.</p>
        </section>

        <div class="event-grid">

            <?php foreach ($events as $event): ?>

                <article class="event-card">

                    <h3>
                        <?= htmlspecialchars($event['event_name']) ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars($event['description']) ?>
                    </p>

                    <p class="event-date">
                        <?= date('j F Y · H:i', strtotime($event['event_date'])) ?>
                    </p>

                    <p class="event-capacity">

                        <?php if ($event['places_left'] > 0): ?>

                            <?= (int) $event['places_left'] ?> places available

                        <?php else: ?>

                            Fully booked

                        <?php endif; ?>

                    </p>

                    <?php if ($event['places_left'] > 0): ?>

                        <a class="main-button" href="login.php">
                            Sign in to book
                        </a>

                    <?php else: ?>

                        <span class="event-full">No places remaining</span>

                    <?php endif; ?>

                </article>

            <?php endforeach; ?>

        </div>
    </main>

    <footer>
        <p>&copy; 2026 Event Horizon</p>
    </footer>

</div>
</body>
</html>

