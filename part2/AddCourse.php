<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <?php
                // Check for valid user login, if there is one, redirect the user to the main page
                if (!isset($_COOKIE["user"])) {
                    header("Location:LearnatoriumLogin.php");
                }

                $user = $_COOKIE["user"];
                $courseID = $_POST["addCourseID"];
                echo($courseID);

                // Create a select query to select the user's username from the database that matches the user's 
                // inputted username and password
                $query = "INSERT INTO usersCourses (username, courseID) VALUES ('$user', '$courseID')";

                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // open Learnatorium database
                if (!mysql_select_db( "Learnatorium", $database)) {
                    die("Could not open products database </body></html>");
                }

                // Perform the insert query on the usersCourses table in the Learnatorium database 
                if (!($result = mysql_query($query, $database))) 
                {
                    // If the insert failed, then the course already exists for the user
                    print("<span class='title4' style='margin-top: 100px'>The course has already been added.</span>");
                    print("<form method='post' action='LearnatoriumLogin.php'>");
                    print("<button class='whiteButton' type='submit' style='margin-top:0px;'>Try Again</button>");
                    print("</form>");
                    die("</body></html>");  
                } // end if

                // The inputted credentials were valid, close the database and display the welcome page
                mysql_close( $database );
            ?>

            <form method="post" action="Learnatorium.php">
                <div class="welcomeText">
                    <h1 class="title1 titleFont">The course has been added!</h1>

                    <span class="title4">Click the button below to continue</span>
                    <button class="whiteButton" type="submit">Continue</button>
                </div>
            </form>
        </body>
    </head>
</html>