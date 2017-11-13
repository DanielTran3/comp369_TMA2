<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="LearnTheWeb.js" ></script>
        <script type="text/javascript">
            window.onload = function () {
                pageStartup();
            }
        </script>
        <title>Learnatorium</title>
    </head>
    <body>
        <?php
            // Check for valid user login, otherwise redirect to login screen
            if (!isset($_COOKIE["user"])) {
                header("Location:LearnatoriumLogin.php");
            }

            // Get the admin status of the user
            $query = "SELECT admin FROM users WHERE username='$_COOKIE[user]'";

            // Connect to MySQL
            if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                die("Could not connect to database </body></html>");
            }

            // open Learnatorium database
            if (!mysql_select_db("Learnatorium", $database)) {
                die("Could not open products database </body></html>");
            }

            // Execute the select query to retrieve the status of the user
            if (!($result = mysql_query($query, $database))) 
            {
                // If the select query failed, notify the user
                print( "<p>Failed to retrieve your user status</p>" );
                print("<form method='post' action='WelcomeToSiteMark.php'>");
                print("<button class='whiteButton' type='submit' style='margin-top:0px;'>Continue</button>");
                print("</form>");
                die( mysql_error() . "</body></html>" );
            }

            // Query was valid, close the database and display the main page
            mysql_close( $database );
        ?>
        <div class="linksBar">
            <h1 class="banner">Learnatorium</h1>
            <!-- Print the user's name along with a link to log out -->
            <span class="title4 floatRight" style="color:white"> Welcome <?php print($_COOKIE["user"]) ?>, <a href="Logout.php">Logout?</a></span>
            <ul>
                <li>
                    <a href="../tma1.htm">Home</a>
                </li>
                <li>
                    <a href="../part1/WelcomeToResume.html">Resume</a>
                </li>
                <li>
                    <a href="AvailableCourses.php">Available Courses</a>
                </li>
                <li>
                    <a href="YourCourses.php">Your Courses</a>
                </li>

                <?php 
                    // Retrieve the user's satatus and check if they are an admin or not. If they are,
                    // display the Create A Course link
                    $adminRights = mysql_fetch_assoc($result);
                    if ($adminRights["admin"]) {
                        print('<li><a href="CreateCourseContent.php">Create A Course</a></li>');
                    }
                ?>
            </ul>
        </div>
    </body>
</html>