<?php
// Starts the session 
session_start();

// If the user is logged in and presses the logout button
if (isset($_POST['logout'])) {
  // Destroy the session and redirect to the homepage or login page
  session_unset(); // Unset all session variables
  session_destroy(); // Destroy the session
  header("Location: ../index.php"); // Redirect to homepage or login page
}

// Database connection!
include_once('../dbconnect.php');

// checks whether the user is logged in or not
if (!isset($_SESSION['account_id'])) {
  // Redirect to the login page if the user is not logged in
  header("Location: login.php");
}

try {
  // Retrieve the account ID from the session
  $accountId = $_SESSION['account_id'];

  // Prepare SQL query
  // Using a placeholder ':accountId' to prevent SQL injections
  $sql = "
        SELECT first_name, last_name, birth_date
        FROM account
        WHERE account_id = :accountId
    ";
  // Prepare the SQL query with the database connection
  $stmt = $conn->prepare($sql);

  // Bind the value of the variable $accountId to the placeholder ':accountId'
  // The value will be inserted into the query safely, ensuring it's treated as an integer. It prevents SQL injections!
  $stmt->bindvalue(':accountId', $accountId, PDO::PARAM_INT);

  // Execute the prepared statement, sending the query to the database
  $stmt->execute();

  // Fetch the result as an associative array (key-value pairs saved in array, where the column names from the database act as the keys)
  // This will get the user's data from the database
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // Checks if the user details were found
  if ($user) {
    $firstName = htmlspecialchars($user['first_name']);
    $lastName = htmlspecialchars($user['last_name']);
    $birthDate = htmlspecialchars($user['birth_date']);
  } else {
    // Display an error message if the user was not found!
    echo "User was not found.";
  }
} catch (PDOException $e) {
  // Handles database-related errors (in general) and displays an error message
  echo "Something went wrong, try again " . $e->getMessage();
}

// START TEST 
try {
  // SQL query to retrieve orders for the logged-in user
  // The JOINS ensure we get the correct information from the 'purchase', 'ticket', and 'event' tables!
  $orderSql = "
      SELECT 
          e.name AS event_name,
          e.location,
          t.price,
          p.order_date AS placed_on,
          p.quantity,
          p.status
      FROM 
          purchase p
      JOIN 
          ticket t ON p.t_id = t.ticket_id
      JOIN 
          event e ON t.event_id = e.event_id
      WHERE 
          p.a_id = :accountId
  ";

  // Prepare the SQL query for execution, storing it in the $orderStmt variable for later use!
  $orderStmt = $conn->prepare($orderSql);

  // Bind the value of the variable $accountId to the placeholder ':accountId'
  // The value will be inserted into the query safely, ensuring it's treated as an integer. It prevents SQL injections!
  $orderStmt->bindValue(':accountId', $accountId, PDO::PARAM_INT);

  // Execute the prepared statement, sending the query to the database
  $orderStmt->execute();

  // Fetch all results as an associative array
  $orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  // Handles errors in case of an issue while retrieving info about the orders
  echo "Error fetching orders: " . $e->getMessage();
}

if (isset($_POST['unregister'])) {
  try {
    // Retrieve the account ID from the session
    $accountId = $_SESSION['account_id'];

    // delete the user account
    $sql = "DELETE FROM account WHERE account_id = $accountId";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Destroy the session and redirect to the homepage
    session_unset();
    session_destroy();
    header("Location: ../index.php");
  } catch (PDOException $e) {
    // Handles errors
    echo "Oopsie doopsie not so good" . $e->getMessage();
  }
}
?>

<!-- ORDERS -->


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="profile.css">
  <link rel="stylesheet" href="../styles/shared.css">
  <title>Customer profile page</title>
</head>

<body>
  <div class="background"></div>
  <?php include '../navbar.php'; ?>

  <div class="profile-container">
    <div class="profile-box">
      <!-- include php code for an dynamic webpage -->
      <h1>Welcome back <?php echo $firstName; ?> <?php echo $lastName; ?>!</h1>
    </div>

    <!-- include php code and variables for an dynamic webpage -->
    <ul class="profile-details">
      <li><strong>First Name:</strong> <?php echo $firstName; ?></li>
      <li><strong>Last Name:</strong> <?php echo $lastName; ?></li>
      <li><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></li>
      <li><strong>Date of Birth:</strong> <?php echo $birthDate; ?></li>
    </ul>

    <p><strong>Your orders:</strong></p>

    <ul class="your-orders">
      <?php if (!empty($orders)) : ?>
        <?php foreach ($orders as $order) : ?>
          <li>
            <strong>Event Name:</strong> <?php echo htmlspecialchars($order['event_name']); ?><br>
            <strong>Location:</strong> <?php echo htmlspecialchars($order['location']); ?><br>
            <strong>Price:</strong> €<?php echo htmlspecialchars($order['price']); ?><br> <!-- not dynamic-->
            <strong>Placed On:</strong> <?php echo htmlspecialchars($order['placed_on']); ?><br>
            <strong>Quantity:</strong> <?php echo htmlspecialchars($order['quantity']); ?><br>
            <strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?>
          </li>
          <br>
        <?php endforeach; ?>
      <?php else : ?>
        <li>Still empty, but the best events are just a click away&#128522;&#127900;</li>
      <?php endif; ?>
    </ul>


    <div class="button-row">
      <form method="POST" action="">
        <button type="submit" name="unregister" class="unregister-button">Unregister</button>
      </form>
      <!-- Form to logout -->
      <form method="POST" action="">
        <button type="submit" name="logout" class="logout-button">Logout</button>
      </form>
    </div>
  </div>
</body>

</html>