<!DOCTYPE html>
<html>
<html lang="en">

<head>
  <title>Project 1 - Test Page</title>
  <link rel="stylesheet" href="styles/is_org_event.css">
</head>



<body>
  <div class=background></div>
  <?php include 'navbar.php' ?>
  <br>
  <?PHP
  include_once("dbconnect.php");

  $account_id = $_SESSION['account_id'];




  $sql = "SELECT * FROM account WHERE account_id= $account_id";
  $sqlEvent = "SELECT * FROM event WHERE a_id = $account_id";

       //execut the sql statements
       $stmt = $conn->query($sql);
       $stmtEvent = $conn->query($sqlEvent);

      //get the data of the user
       $row = $stmt->fetch(PDO::FETCH_ASSOC);    
       $rowEvent = $stmtEvent->fetch(PDO::FETCH_ASSOC); 

         

  if (isset($_SESSION['account_id']) && !empty($_SESSION['account_id']) && ($_SESSION['is_organiser'] == true)) {
    echo '
  <div class="content">
    <div class="details">
      <h2>Event Name:</h2>
      <p>Start time:</p>
      <p>Price:</p>
      <p>Location:</p>
      <p>Duration:</p>
      <p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean in finibus metus.
        Sed rutrum tortor est, eu mattis velit iaculis non. Vestibulum venenatis tellus nec ex facilisis, quis tempor diam tincidunt.
        Sed malesuada magna urna, et ornare eros tristique at. Nunc sollicitudin volutpat sem, a commodo neque dapibus faucibus.
        Ut feugiat, erat nec lobortis scelerisque, massa dui elementum turpis,
        in mollis nisi eros id leo. Aliquam sed augue vel quam pretium rutrum. Praesent sodales at felis id sodales.
      </p>
    </div>
    <div class="image">
      <div class="placeholder"></div>
    </div>
    <div class="buttons">
      <button class="edit-btn">Edit</button>
      <button class="dlt-btn">Delete</button>
    </div>
    <div class="tickets">
      <p>Amount of money:</p>
      <p>'. $rowEvent['description'] .'<p>
    </div>
  </div>
  </div>
</body>';
  }
  // else {
  //   echo '<p>This page is not for you.</p>';
  //   // Redirect to the main page (index.php)
  //   header("Location: index.php");
  //   exit();
  // }
  ?>

</html>