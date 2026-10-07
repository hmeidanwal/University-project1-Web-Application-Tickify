<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project 1 - Test Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <style>
        

        nav {
            display: flex;
            justify-content: space-between;
            background-color: cadetblue;
            padding: 10px;
            border-radius: 10px;
            max-width: 1200px;
            margin: auto;
        }

        .menu-left a {
            text-decoration: none;
            color: #39FF14;
            margin-right: 20px;
            font-size: 18px;
            padding: 10px;
        }

        .menu-left a:hover {
            color: pink;
            background-color: #3498db;
        }


        .menu-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }


        .search-bar {
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            width: 200px;
        }

        .login-button {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #39FF14;
            /* Text color */
            font-size: 18px;
            padding: 5px;
            border-radius: 5px;

        }

        .login-button:hover {
            color: pink;
            background-color: #3498db;
        }


        .profile-icon {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }

        @media screen and (max-width: 768px) {

        nav {
            flex-direction: column;
        }

        .menu-left {
           text-align: center;
            display: flex;
            flex-direction: column;
            }

        .menu-right {
            text-align: center;
            display: flex;
            flex-direction: column;
        }
    
    }
    </style>
    
        <nav>
            <div class="menu-left">
                <a href="../index.php">Home</a>
                <a href="../eventpage.php">Events</a>
                <a href="../aboutUs.php">About Us</a>
                <a href="../customer_support.php">Contact</a>
            </div>
            <div class="menu-right">
                <?php
                 if (session_status() == PHP_SESSION_NONE) {
                    session_start(); // Start the session if it hasn't been started yet
                }
                //include the database
                include_once("dbconnect.php");
                // make a variable for the files so its easy to read
                $orgfile = 'organiserprofile.php';
                $userfile = '/login/profile.php';
                //if a session isset (started) 
                //isset: This checks if the account_id key exists in the $_SESSION.
                //!empty: checks if the account_id is not null and a valid value.
                if (isset($_SESSION['account_id']) && !empty($_SESSION['account_id']) && ($_SESSION['is_organiser'] == true)) {
                    echo "<a href='$orgfile' class='login-button'>";
                    echo "<img src='../images/icons8-signin-50.png' alt='Profile' class='profile-icon'>Profile";
                    echo "</a>";
                } else if (isset($_SESSION['account_id']) && !empty($_SESSION['account_id'])) {
                    echo "<a href='$userfile' class='login-button'>";
                    echo "<img src='../images/icons8-signin-50.png' alt='Profile' class='profile-icon'>Profile";
                    echo "</a>";
                 }else {
                    echo "<a href='../login/login.php' class='login-button'>";
                    echo "<img src='../images/icons8-signin-50.png' alt='Profile' class='profile-icon'> Log In";
                    echo  "</a>";
                }
                ?>
                <input type="text" placeholder="Search..." class="search-bar">
            </div>
        </nav>
   