<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <?php
                $user = $_POST["signupUsername"];
                $query = "INSERT INTO bookmarks (username, url, hits) VALUES ('$_COOKIE['user']', '$pass', '0')";

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

                if (mysql_num_rows($result) == 0) {
                    print("<span class='title4' style='margin-top: 100px'>Invalid Username and/or Password</span>");
                    print("<form method='post' action='SiteMarkLogin.php'>");
                    print("<button class='whiteButton' type='submit' style='margin-top:0px;'>Try Again</button>");
                    print("</form>");
                    die("</body></html>");                    
                }
                mysql_close( $database );
                header("Location:SiteMark.php");
            ?>
        </body>
    </head>
</html>