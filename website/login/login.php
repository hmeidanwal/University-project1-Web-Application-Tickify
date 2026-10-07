<?php
include_once("../dbconnect.php");




//checks if someone clicked the submit button
if (isset($_POST['submit'])) {
  // Retrieve form data and assign to variables the names you put after between brackets has to be equal to the name u set in the input type
  $email = $_POST['email'];
  $password = $_POST['password'];

  try {
    // Prepare the SQL query to find the user email which he entered
    $sqlSelect = "SELECT * FROM account WHERE email = :email";
    $stmt = $conn->prepare($sqlSelect);

    // Bind the email parameter securely to prevent sql injection
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    // Fetch(Get) the data of the user
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      // Verify the entered password against the hashed password in the database
      // Step 1: User provides a plain-text password during login, stored in $password.
      // Step 2: Retrieve the hashed password for the user from the database ($user['password']).
      // Step 3: Use password_verify() to compare the plain-text password with the hashed password:
      //         - password_verify() re-hashes the plain-text password using the same algorithm and salt
      //           that is used in the stored hash.
      //         - It then compares the newly hashed password with the stored hash.
      // Step 4: If the hashes match, the function returns true, and the user is authenticated.
      //         Otherwise, it returns false, and authentication fails.
      if ($user && password_verify($password, $user['password'])) {
        // Step 5: If the password is correct, start a session and store user details.
        session_start();
        $_SESSION['account_id'] = $user['account_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['is_organiser'] = $user['is_organiser'];
        // redirect to index.php if succesful login 
        header("location: ../index.php");
        exit();
      } else {
        // Display an error message if the combination is incorrect
        $error_message = "🔏Incorrect combination of email adress and password! Please try again.";
      }
    }
  } catch (PDOException $e) {
    // Handle database errors
    $error_message = "Error: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/shared.css">
  <link rel="stylesheet" href="../styles/register-login.css">


  <title>Login page</title>
</head>

<body>
  <div class="background"></div>
  <br>

  <?php include '../navbar.php'; ?>

  <br>
  <div class="container">
    <div class="box form-box">
      <header>Login</header>
      <form action="" method="post"> <!-- method is for php-->

        <div class="info">
          <label for="email">email:</label> <!--tekst dat gevraagd wordt-->
          <input type="email" name="email" id="username" required> <!--user input-->
        </div>

        <div class="info">
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" required> <!--'name' heb je nodig om het later te kunnen koppelen aan de PHP database-->
        </div>

        <div class="info">
          <input type="submit" class="button" name="submit" value="Login" required> <!--Required betekent dat het veld niet leeg mag zijn!-->
        </div>

        <!--Error message that will be displayed when the combination of email adress and password is incorrect! -->
        <?php if (isset($error_message) && $error_message): ?>
          <!-- Display the error message if it exists, and ensure it's safely outputted using htmlspecialchars -->
          <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <div class="no-account-link">
          No account?<a href="register.php"> Sign up</a> and join the excitement&#129321;
        </div>

      </form>
    </div>

  </div>



</body>

</html>