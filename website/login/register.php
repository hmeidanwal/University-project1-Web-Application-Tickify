<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/shared.css">
  <link rel="stylesheet" href="../styles/register-login.css"> 
  <title>Register page</title>
</head>

<body>
  <div class = "background"></div>
<br>

<?php include '../navbar.php'; ?>


  <?php
  if (isset($message)) {
    echo "<p style='color: green;'>$message</p>";
  }
  ?>
  <div class="container">
    <div class="box form-box">
      <header>Sign Up</header>
      <form action="" method="post">

        <div class="info">
          <label for="firstname">First name:</label>
          <input type="first_name" name="firstname" id="firstname" required>
        </div>

        <div class="info">
          <label for="lastname">Last name:</label>
          <input type="last_name" name="lastname" id="lastname" required>
        </div>

        <div class="info">
          <label for="birth_date">Date of birth:</label>
          <input type="bod" name="birth_date" id="dob" required>
        </div>

        <div class="info">
          <label for="email">Email:</label>
          <input type="email" name="email" id="email" required>
        </div>

        <div class="info">
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" required>
        </div>

        <div class="login-button">
          <input type="submit" class="button" name="submit" value="Create account" required>
        </div>

        <div class="no-account-link">
          Already an account?<a href="login.php"> Login!</a>
        </div>
      </form>
    </div>

  </div>

</body>

<?php
include_once("../dbconnect.php");

if (isset($_POST['submit'])) {
  // Retrieve form data and assign to variables the names you put after between brackets has to be equal to the name u set in the input type
  $first_name = $_POST['firstname'];
  $last_name = $_POST['lastname'];
  $dob = $_POST['birth_date'];
  $email = $_POST['email'];
  $password = $_POST['password'];

// Hash the password securely using password_hash()
// PASSWORD_DEFAULT makes sure a strong and secure hashing algorithm is used
// This function automatically generates a unique salt and uses it in the hash.
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  try {
    // Prepare the SQL statement to insert it into the account table 
    $stmt = $conn->prepare("INSERT INTO account (first_name, last_name, birth_date, email, password)
                            VALUES (:first_name, :last_name, :birth_date, :email, :password)");

    // Bind the variables you put before to a named placeholder and at the end is the prepared statements in which you say what data type should be your text 
    $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':birth_date', $dob, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);

    // Execute the statement
    if ($stmt->execute()) {
      // Redirect to the profile page after successful registration
      header("Location: profile.php");
      exit();
    } else {
      //if executions fails produce error
      $message = "Error: Unable to register.";
    }
  } catch (PDOException $e) {
    //handles exceptions
    $message = "Error: " . $e->getMessage();
  }
}
?>



