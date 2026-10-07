<!DOCTYPE html>
<html lang="en">

<head>
  <title>Project 1 - Test Page</title>

  
  <link rel="stylesheet" href="styles/shared.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <div class="background"></div>
  <br>

  <?php include 'navbar.php'; ?>

  <br>
  <?php include_once("dbconnect.php");
  //within here do the sql statements to retrieve the items u want

  $sqlSelect = "SELECT * FROM event";
  $stmt = $conn->query($sqlSelect);


  $events = [];
  if ($stmt->rowCount() > 0) {
    // Loop through each row and fetch the event data
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      // Store each event in the $events array
      $events[] = [
        'description' => $row['description'],       
        'event_id' => $row['event_id']
      ];
    }
  } else {
    echo "No events found.";
  }

  //begin the grid container
  echo "<div class='grid-container'>";

  // start a foreach loop so for each event that is within the database print the values in the grid container
  foreach ($events as $event) {
    echo "<div class='image-item'>";
    //kind of functions like a get method since u get the id of the event in the search bar
    echo "<a href='specific_event.php?id=" . $event['event_id'] . "'>";
    echo "<p style = 'color:blue;'>" . $event['description'] . "</p>";
    echo "</a>";
    echo "</div>";
  }

  ?></p>
  </div>
  </div>
</body>