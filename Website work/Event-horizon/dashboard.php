
<?php

require_once 'includes/auth.php';

requireLogin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Event Horizon</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="icon" href="favicon.webp">
</head>

<body>
<div class="content">

    <header>
        <h1>Event Horizon</h1>
        <p>Your personal event dashboard.</p>
    </header>

   <?php require_once 'includes/header.php'; ?>

    <main>

        <section>
            <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

            <p>You are successfully logged in.</p>

            <p>From here, you can browse upcoming workshops and manage your bookings.</p>

            <a class="main-button" href="events.php">
                Browse Events
            </a>
        </section>

    </main>

    <footer>
        <p>&copy; 2026 Event Horizon</p>
    </footer>

</div>
</body>
</html>

