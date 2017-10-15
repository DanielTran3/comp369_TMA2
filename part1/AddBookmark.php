<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <?php
                $url = $_POST["newBookmarkURL"];
                $name = $_POST["newBookmarkName"];
                $user = $_COOKIE["user"];
                $query = "INSERT INTO bookmarks (username, url, name, hits) VALUES ('$user', '$url', '$name', '0')";

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
                header("Location:SiteMark.php");
            ?>
        </body>
    </head>
</html>