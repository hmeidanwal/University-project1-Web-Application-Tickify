<!DOCTYPE html>
<html>
 <html lang="en">
<head>
    <title>Project 1 - Test Page</title>
    <link rel="stylesheet" href="styles/addevent.css">
    <link rel="stylesheet" href="styles/shared.css">
    <meta name= "viewport" content="width=device-width, initial-scale=1.0">
</head>


<br>

<body>
    <div class = background></div>
    <br>

<?php include 'navbar.php' ?>

<div class = "grid-container">

<div class="container">

        <h2>Add Event</h2>

        <form action="addevent.php" method="POST">
            <!-- Event Name -->
            <div>
                <label for="event_name">Event Name</label>
                <input type="text" id="event_name" name="event_name" required>
            </div>

            <!-- Start/End Date and Time -->
            <div class="grid-row">
                <div class = date>
                    <label for="date">Start Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div>
                    <label for="start_time">Start Time</label>
                    <input type="time" id="start_time" name="start_time" required>
                </div>
                <div>
                    <label for="duration">Duration</label>
                    <input type="number" id="duration" name="duration" required>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <!-- Location -->
            <div>
                <label for="location">Location</label>
                <input type="text" id="location" name="location" required>
            </div>
            </div>

            <div class="ticket-container">
            
                <div class = "grid-row">
                    <div>
                <label for="category_name_1">Category</label>
                <input type="text" name="category_name[]" id="category_name_1" required></div>
                <div>
                <label for="ticket_description_1">Description</label>
                <input type="text" name="ticket_description[]" id="ticket_description_1" required></div>
                <div>
                <label for="price_1">Price</label>
                <input type="number" name="price[]" id="price_1" required></div>
                <div>
                <label for="quantity_1">Quantity</label>
                <input type="number" name="quantity[]" id="quantity_1" required></div>
                </div>

               
                <div class = "grid-row">
                    <div>
                <label for="category_name_2">Category</label>
                <input type="text" name="category_name[]" id="category_name_2" required></div>
                <div>
                <label for="ticket_description_2">Description</label>
                <input type="text" name="ticket_description[]" id="ticket_description_2" required></div>
                <div>
                <label for="price_2">Price</label>
                <input type="number" name="price[]" id="price_2" required></div>
                <div>
                <label for="quantity_2">Quantity</label>
                <input type="number" name="quantity[]" id="quantity_2" required></div>
                </div>
            


           
                <div class = "grid-row">
                    <div>
                <label for="category_name_3">Category</label>
                <input type="text" name="category_name[]" id="category_name_3" required></div>
                <div>
                <label for="ticket_description_3">Description</label>
                <input type="text" name="ticket_description[]" id="ticket_description_3" required></div>
                <div>
                <label for="price_3">Price</label>
                <input type="number" name="price[]" id="price_3" required></div>
                <div>
                <label for="quantity_3">Quantity</label>
                <input type="number" name="quantity[]" id="quantity_3" required></div>
                </div>
            

           
                <div class = "grid-row">
                    <div>
                <label for="category_name_4">Category</label>
                <input type="text" name="category_name[]" id="category_name_4" required></div>
                <div>
                <label for="ticket_description_4">Description</label>
                <input type="text" name="ticket_description[]" id="ticket_description_4" required></div>
                <div>
                <label for="price_4">Price</label>
                <input type="number" name="price[]" id="price_4" required></div>
                <div>
                <label for="quantity_4">Quantity</label>
                <input type="number" name="quantity[]" id="quantity_4" required></div>
                </div>
            
            
                <div class = "grid-row">
                    <div>
                <label for="category_name_5">Category</label>
                <input type="text" name="category_name[]" id="category_name_5" required></div>
                <div>
                <label for="ticket_description_5">Description</label>
                <input type="text" name="ticket_description[]" id="ticket_description_5" required></div>
                <div>
                <label for="price_5">Price</label>
                <input type="number" name="price[]" id="price_5" required></div>
                <div>
                <label for="quantity_5">Quantity</label>
                <input type="number" name="quantity[]" id="quantity_5" required></div>
                </div>
            

            </div>

            
            
            <!-- Buttons -->
        <div class = "button-container">
            <div class="button-row">
                <button type="submit" name = "submit" class="save-button">Save</button>
                <button type="button" class="cancel-button" onclick="window.location.href='index.php';">Cancel</button>
            </div>
        </div>
</form>
    
</div>



</body>

<?php

include_once("dbconnect.php");

if (isset($_POST['submit'])) {
  // Retrieve and sanitize form data
  $name = $_POST['event_name'];
  $date = $_POST['date'];
  $start_time = $_POST['start_time'];
  $duration = $_POST['duration'];
  $description = $_POST['description'];
  $location = $_POST['location'];
 
 $account_id = $_SESSION['account_id'];
  

  try {

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO event (description, name, location, date, start_time, duration, a_id)
                            VALUES (:description, :event_name, :location, :date, :start_time, :duration, :account_id)");

   
    // Bind the values
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':event_name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':location', $location, PDO::PARAM_STR);
    $stmt->bindValue(':date', $date, PDO::PARAM_STR);
    $stmt->bindValue(':start_time', $start_time, PDO::PARAM_STR);
    $stmt->bindValue(':duration', $duration, PDO::PARAM_STR);
    $stmt->bindValue(':account_id', $account_id, PDO::PARAM_INT);    
       
    $stmt->execute();

    $event_id = $conn->lastInsertId();

    $categories = $_POST['category_name'];
    $descriptions = $_POST['ticket_description'];  // Corrected typo here
    $prices = $_POST['price'];
    $quantities = $_POST['quantity'];

    for ($i = 0; $i < count($categories); $i++) {
        // Prepare and execute the SQL for ticket categories
        $stmt = $conn->prepare("INSERT INTO ticket (Event_ID, Category_name, Description, Price, Quantity)
                                VALUES (:event_id, :category_name, :description, :price, :quantity)");

        // Bind values for each ticket category
        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_name', $categories[$i], PDO::PARAM_STR);
        $stmt->bindValue(':description', $descriptions[$i], PDO::PARAM_STR);
        $stmt->bindValue(':price', $prices[$i], PDO::PARAM_STR);
        $stmt->bindValue(':quantity', $quantities[$i], PDO::PARAM_INT);

        // Execute query for each category
        $stmt->execute();
    }   
    
        echo "Event added successfully.";

   
  } catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
    echo $message;
  }
}
?>
 </html>    