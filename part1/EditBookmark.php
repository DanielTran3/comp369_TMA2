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

                // Get the currently logged in username, old bookmark URL and name, along with the new bookmark URL and name
                $url = $_POST["editedBookmarkURL"];
                $name = $_POST["editedBookmarkName"];
                $oldURL = $_POST["oldBookmarkURL"];
                $oldName = $_POST["oldBookmarkName"];
                $user = $_COOKIE["user"];

                // Create a query to update the bookmarks table by setting the url and name to the new url and name, requiring that 
                // the username, old url, and new url match a row in the table
                $query = "UPDATE bookmarks SET url = '$url', name = '$name' WHERE username = '$user' AND url = '$oldURL' AND name = '$oldName'";

                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // open users database
                if (!mysql_select_db( "users", $database)) {
                    die("Could not open products database </body></html>");
                }

                // Update the bookmarks table in the users database with the newly updated url
                if (!($result = mysql_query($query, $database))) 
                {
                    // If the update query failed, then prompt the user and redirect the user to the main page
                    print( "<p>Could not update URL</p>" );
                    print( "<p><a href='SiteMark.php'>Click Here</a> to continue.</p>" );
                    die("</body></html>");
                }

                // Update query was successful, redirect the user back to the main page
                mysql_close( $database );
                header("Location:SiteMark.php");
            ?>
        </body>
    </head>
</html>