
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<nav>
    <a href="index.php">Home</a>
    <a href="events.php">Events</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="my-bookings.php">My Bookings</a>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</nav>

