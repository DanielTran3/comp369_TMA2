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

                // Get the bookkmark URL, bookmark name, and current user's url
                $url = $_POST["newBookmarkURL"];
                $name = $_POST["newBookmarkName"];
                $user = $_COOKIE["user"];

                // Create a query to insert the bookmark into the database under the user's username with 0 hits
                $query = "INSERT INTO bookmarks (username, url, name, hits) VALUES ('$user', '$url', '$name', '0')";

                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // open users database
                if (!mysql_select_db( "users", $database)) {
                    die("Could not open products database </body></html>");
                }

                // Insert the bookmark into the users database, under the bookmarks table
                if (!($result = mysql_query($query, $database))) 
                {
                    // If the bookmark already exists, then redirect the user back to the main page
                    print( "<p>The bookmark already exists!</p>" );
                    print( "<p><a href='SiteMark.php'>Click Here</a> to continue.</p>" );
                    die("</body></html>");
                } // end if
                
                // If the insert was successful, redirect the user to the main page
                mysql_close( $database );
                header("Location:SiteMark.php");
            ?>
        </body>
    </head>
</html>