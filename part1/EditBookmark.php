<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <?php
                if (!isset($_COOKIE["user"]) || !isset($_COOKIE["pass"])) {
                    header("Location:SiteMarkLogin.php");
                }

                $url = $_POST["editedBookmarkURL"];
                $name = $_POST["editedBookmarkName"];
                $oldURL = $_POST["oldBookmarkURL"];
                $oldName = $_POST["oldBookmarkName"];
                $user = $_COOKIE["user"];

                print( "<p>editedURL: $url</p>" );
                print( "<p>editedName: $name</p>" );
                print( "<p>oldURL: $oldURL</p>" );
                print( "<p>oldName: $oldName</p>" );

                $query = "UPDATE bookmarks SET url = '$url', name = '$name' WHERE username = '$user' AND url = '$oldURL' AND name = '$oldName'";

                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // open Products database
                if (!mysql_select_db( "users", $database)) {
                    die("Could not open products database </body></html>");
                }

                // query Products database
                if (!($result = mysql_query($query, $database))) 
                {
                    print( "<p>Could not execute query!</p>" );
                    die( mysql_error() . "</body></html>" );
                } // end if
                mysql_close( $database );
                // header("Location:SiteMark.php");
            ?>
        </body>
    </head>
</html>