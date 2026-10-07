<!DOCTYPE html>
<html>
 <html lang="en">
<head>
    <title>Project 1 - Test Page</title>
    <link rel="stylesheet" href="styles/customer_support.css">
    <link rel="stylesheet" href="styles/shared.css">
</head>
        

<br>
        
<body>
<div class = "background"></div>

<?php include 'navbar.php' ?>
      

    <div class="input">
        <label for="email">Enter your email:</label>
        <input type="email" id="email" name="email" autocomplete="email" class="email-input" placeholder="example@example.com" required>
        
        <label for="problem">What is the problem?</label>
        <textarea id="problem" class="problem-input" placeholder="Enter your problem here.."></textarea>
        <button type="submit">Submit</button>
    </div>


</html>