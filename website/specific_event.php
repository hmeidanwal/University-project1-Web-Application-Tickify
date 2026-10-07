<?php include 'dbconnect.php'; ?>

<?php
// Assuming you're fetching a specific event by an ID passed in the URL and if not, default to 1
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

try {
    // Fetch event details
    $stmt = $conn->prepare("SELECT * 
                           FROM event 
                           WHERE Event_ID = :id");
    $stmt->execute(['id' => $event_id]);
    $event = $stmt->fetch();

    // Fetch total income from ticket sales for this event
    $incomeStmt = $conn->prepare("
        SELECT 
            SUM(ticket.price * (ticket.quantity - COALESCE(purchased.total_quantity, 0))) AS total_income
        FROM ticket
        INNER JOIN (
            SELECT t_id, SUM(quantity) AS total_quantity
            FROM purchase
            GROUP BY t_id
        ) purchased ON ticket.ticket_id = purchased.t_id
        WHERE ticket.event_id = :event_id
        GROUP BY ticket.event_id
    ");
    $incomeStmt->execute(['event_id' => $event_id]);
    $income = $incomeStmt->fetchColumn();

    $organizer_income = $income * 0.9; // 90% for the organizer
    $tickify_income = $income * 0.1;  // 10% for Tickify

} catch (PDOException $e) {
    "Error retrieving event or income: " . $e->getMessage();
}
?>

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project 1 - Test Page</title>

    <link rel="stylesheet" href="styles/specific_event.css">
    <link rel="stylesheet" href="styles/shared.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="background"></div>

    <br>

    <?php include 'navbar.php'; ?>

    <br>
    <div class="grid-container">
        <div class="info">

            <h3>
                <center><u><?php echo ($event['name']); ?></u></center>
            </h3><br>
            <p> Start time: <?php echo ($event['start_time']); ?></p>
            <p>Duration: <?php echo ($event['duration']); ?> hours</p>
            <p>Location: <?php echo ($event['location']); ?></p>
            <p>Date: <?php echo ($event['date']); ?></p>

        </div>

        <div class="test">
            <h3>
                <center><u>Total Income</u></center>
            </h3><br>
            <p>€<?php echo number_format($income, 2); ?></p>
        </div>

        <div class="test">
            <h3>
                <center><u>Revenue Split</u></center>
            </h3><br>
            <p>Organizer: €<?php echo number_format($organizer_income, 2); ?></p>
            <p>Tickify: €<?php echo number_format($tickify_income, 2); ?></p>
        </div>

        <div class="image-placeholder"></div>


        <div class="description">
            <h3>
                <center><u>Description </u></center>
            </h3><br>
            <p>
            <p>Description: <?php echo ($event['description']); ?></p>
            </p>
        </div>


        <div class="test">

        </div>
        <div class="test">

        </div>

        <div class="button-row">
            <a href="selection.php"><button type="submit" class="buy">Buy</button></a>
        </div>
    </div>


</body>

</html>