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

                // Get the current user's username, the bookmark to delete's URL and name
                $user = $_COOKIE["user"];
                $bookmarkName = $_POST["bookmarkNameToDelete"];
                $bookmarkURL = $_POST["bookmarkURLToDelete"];

                // Create a query to delete the specified bookmark from the bookmarks table using
                $query = "DELETE FROM bookmarks WHERE username = '$user' AND url = '$bookmarkURL' AND name = '$bookmarkName'";

                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // open users database
                if (!mysql_select_db( "users", $database)) {
                    die("Could not open products database </body></html>");
                }

                // Delete the bookmark from the users database from the bookmarks table
                if (!($result = mysql_query($query, $database))) 
                {
                    // If the delete query could not be performed, prompt he user and redirect the user back to the main page
                    print( "<p>Could not delete bookmark</p>" );
                    print( "<p><a href='SiteMark.php'>Click Here</a> to continue.</p>" );
                    die( mysql_error() . "</body></html>" );
                }

                // If the query was successful, close the database and redirect the user back to the main page
                mysql_close( $database );
                header("Location:SiteMark.php");
            ?>
        </body>
    </head>
</html>