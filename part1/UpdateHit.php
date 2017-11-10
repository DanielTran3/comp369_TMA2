<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <?php
                // Check for valid user login, otherwise redirect to login screen
                if (!isset($_COOKIE["user"]) || !isset($_COOKIE["pass"])) {
                    header("Location:SiteMarkLogin.php");
                }

                // Get the url that the user clicked on, along with the currently logged in user's username
                $url = $_POST["url"];
                $user = $_COOKIE["user"];

                // Create a query to increment the hits value on the users URL in the bookmarks table
                $query = "UPDATE bookmarks SET hits = hits + 1 WHERE username = '$user' AND url = '$url'";

                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // open users database
                if (!mysql_select_db( "users", $database)) {
                    die("Could not open products database </body></html>");
                }

                // Execute the query to update the hit counter for that user's boomark
                if (!($result = mysql_query($query, $database))) 
                {
                    // Update failed, create a button for user to return to the main page after displaying message
                    print( "<p>Could not update hit counter.</p>" );
                    print("<form method='post' action='SiteMark.php'>");
                    print("<button class='whiteButton' type='submit' style='margin-top:0px;'>Continue</button>");
                    print("</form>");
                    die( mysql_error() . "</body></html>" );
                } // end if
                mysql_close( $database );
            ?>
        </body>
    </head>
</html>