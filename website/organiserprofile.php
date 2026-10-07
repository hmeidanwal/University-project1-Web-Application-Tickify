<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project 1 - Test Page</title>
    <link rel="stylesheet" href="styles/shared.css">
    <link rel="stylesheet" href="styles/organiserprofile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="background"></div>
    <header>
        <h1> Ticketland  </h1>
    </header>
    <br>

    <?php include 'navbar.php'; ?>
    <br>
    <?php
    include_once("dbconnect.php");


    // if the user has a valid account_id and is not empty then it will do what';s inside the if statement

    if (isset($_SESSION['account_id']) && !empty($_SESSION['account_id'])) {
        $account_id = $_SESSION['account_id'];

        //sellects data from event and account where its equal to the sessions account_id
        $sql = "SELECT * FROM account WHERE account_id= $account_id";
        $sqlEvent = "SELECT * FROM event WHERE a_id = $account_id";

        //execut the sql statements
        $stmt = $conn->query($sql);
        $stmtEvent = $conn->query($sqlEvent);

        //get the data of the user
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        echo "<section>
<div class='center'>
<h2>Event organizer dashboard</h2>
<br>
<div class=border>
<p>" . $row['first_name'] . "</p>
<p>" . $row['email'] . "</p>
</div>
<div class='borderevent'>";
        while ($rowEvent = $stmtEvent->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>" . $rowEvent['name'] . " (" . $rowEvent['description'] . ")</p>";
        }

        echo "</div>
</div>
<div class='button-row'>
    <a href='addevent.php'>
<button>add event</button>
 </a>
                <form method='POST' action=''>
                    <button type='submit' name='logout' class='log-out'>Logout</button>
                </form>
            </div>
        </section>";
    }

    if (isset($_POST['logout'])) {
        // Destroy the session and redirect to the homepage or login page
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header("Location: ../index.php"); // Redirect to homepage or login page
        exit();
    }
    ?>

</body>