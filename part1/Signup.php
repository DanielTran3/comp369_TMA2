<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <?php
                // Get the user's inputted username and password
                $user = $_POST["signupUsername"];
                $pass = $_POST["signupPassword"];

                // Create a query to insert the specified username and password into the users database
                $query = "INSERT INTO credentials (username, password) VALUES ('$user', '$pass')";

                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // open users database
                if (!mysql_select_db( "users", $database)) {
                    die("Could not open products database </body></html>");
                }

                // Perform the insert query to create a new user in the database
                if (!($result = mysql_query( $query, $database))) 
                {
                    // If the insert failed, then the username already exists in the database. Prompt the user and 
                    // create a button to redirect the user to the Signup page
                    print("<span class='title4' style='margin-top: 100px'>Username already exists!</span>");
                    print("<form method='post' action='SiteMarkSignup.php'>");
                    print("<button class='whiteButton' type='submit' style='margin-top:0px;'>Continue</button>");
                    print("</form>");
                    die("</body></html>");
                }

                // Query was successful. Close the database and display the rest of the page
                mysql_close( $database );
            ?>

            <!-- Display the successful signup information and create a button to redirect the user to the main page -->
            <form method="post" action="SiteMark.php">
                <div class="welcomeText">
                    <h1 class="title1 titleFont">SiteMark</h1>

                    <span class="title1">You've Been signed up <?php print($user) ?>!</span>
                    <span class="title4">Click the button below to continue</span>
                    <button class="whiteButton" type="submit">Continue</button>
                </div>
            </form>
            <?php
                // Set the cookies for the user's username and password for an hour 
                define("ONE_HOUR", 60 * 60 * 1);

                setcookie("user", $_POST["signupUsername"], time() + ONE_HOUR);
                setcookie("pass", $_POST["signupPassword"], time() + ONE_HOUR);
            ?>
        </body>
    </head>
</html>