<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <title>Logged Out</title>
        <body>
            <?php
                // Clear the user and pass cookies by making them expire
                define("ONE_HOUR", 60 * 60 * 1);      
                setcookie('user', '', time() - ONE_HOUR);
            ?>
            <!-- Display the logged out page and create a button that returns the user to the Welcome Page -->
            <form method="post" action="WelcomeToLearnatorium.php">
                <div class="welcomeText">
                    <h1 class="title1 titleFont">You've Been Logged Out!</h1>

                    <span class="title4">Click the button below to return to the Welcome Page.</span>
                    <button class="whiteButton" type="submit">Continue</button>
                </div>
            </form>
        </body>
    </head>
</html>