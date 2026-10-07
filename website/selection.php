<?php
include_once("dbconnect.php");

// SQL query to select the price column
$sqlZone1 = "SELECT price FROM ticket where category_name = 'Zone 1'";
$stmt1 = $conn->query($sqlZone1);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
$priceZone1 = $row1['price'];

$sqlZone2 = "SELECT price FROM ticket where category_name = 'Zone 2'";
$stmt2 = $conn->query($sqlZone2);
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$priceZone2 = $row2['price'];

$sqlVip = "SELECT price FROM ticket where category_name = 'VIP'";
$stmt3 = $conn->query($sqlVip);
$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
$priceVip = $row3['price'];


$sqlStanding = "SELECT price FROM ticket where category_name = 'Standing'";
$stmt4 = $conn->query($sqlStanding);
$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
$priceStanding = $row4['price'];

$sqlSit = "SELECT price FROM ticket where category_name = 'Sit'";
$stmt5 = $conn->query($sqlSit);
$row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
$priceSit = $row5['price'];

$totalPrice = 0;

// Define an emty errormessage variable for later use! 
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $quantityZone1 = isset($_POST['quantityZone1']) ? (int)$_POST['quantityZone1'] : 0;
  $quantityZone2 = isset($_POST['quantityZone2']) ? (int)$_POST['quantityZone2'] : 0;
  $quantityVip = isset($_POST['quantityVip']) ? (int)$_POST['quantityVip'] : 0;
  $quantityStanding = isset($_POST['quantityStanding']) ? (int)$_POST['quantityStanding'] : 0;
  $quantitySit = isset($_POST['quantitySit']) ? (int)$_POST['quantitySit'] : 0;

  // formula to calculate the total amount of tickets:
  $totalTickets = $quantityZone1 + $quantityZone2 + $quantityVip + $quantityStanding + $quantitySit;

  // Check whether the maximum number of 10 tickets has been surpassed: 
  if ($totalTickets > 10) {
    $errorMessage = "Max 10 tickets per event 😉";
  } else {
    // Calculate total price
    $totalPrice = ($quantityZone1 * $priceZone1) +
      ($quantityZone2 * $priceZone2) +
      ($quantityVip * $priceVip) +
      ($quantityStanding * $priceStanding) +
      ($quantitySit * $priceSit);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="styles/selection.css">
</head>

<?php include 'navbar.php' ?>
<br>

<body>
  <form method="POST" action="">

    <div class="container">
      <!-- If the errorMessage variabele isn't emty, it will 'echo' an error message  -->
      <?php if (!empty($errorMessage)): ?>
        <p style="color: black;"><?php echo $errorMessage; ?></p>
      <?php endif; ?>

      <div class="zone">
        <p>Zone 1</p>
        <input type="number" name="quantityZone1" min="0" placeholder="0" value="0">
        <p id="price1">Price: €<?php echo $priceZone1; ?></p>
      </div>
      <div class="zone">
        <p>Zone 2</p>
        <input type="number" name="quantityZone2" min="0" placeholder="0" value="0">
        <p id="price2">Price: €<?php echo $priceZone2; ?></p>
      </div>
      <div class="zone">
        <p>VIP</p>
        <input type="number" name="quantityVip" min="0" placeholder="0" value="0">
        <p id="price3">Price: €<?php echo $priceVip; ?></p>
      </div>
      <div class="zone">
        <p>Standing</p>
        <input type="number" name="quantityStanding" min="0" placeholder="0" value="0">
        <p id="price4">Price: €<?php echo $priceStanding; ?></p>
      </div>
      <div class="zone">
        <p>Sit</p>
        <input type="number" name="quantitySit" min="0" placeholder="0" value="0">
        <p id="price5">Price: €<?php echo $priceSit; ?></p>
      </div>
      <div class="total">
        <p>Total Price: €<?php echo number_format((float)$totalPrice, 2); ?></p>
        <select name="bank">
          <option>Choose bank</option>
          <option>ING</option>
          <option>ABN</option>
        </select>

        <button type="submit">Purchase</button>
        
      </div>
    </div>
    </div>

</body>

</html>