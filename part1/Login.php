<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <?php
                $user = $_POST["loginUsername"];
                $pass = $_POST["loginPassword"];

                // $query = "INSERT INTO credentials ('username', password') VALUES ("  . $user . ", " . $password . ")";
                $query = "SELECT username FROM credentials WHERE username = '$user' AND password = '$pass'";

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
            ?>

            <form method="post" action="SiteMark.php">
                <div class="welcomeText">
                    <h1 class="title1 titleFont">SiteMark</h1>

                    <span class="title1">Welcome to SiteMark</span>
                    <span class="title1"><?php print($user) ?></span>
                    <span class="title4">Click the button below to continue</span>
                    <button class="whiteButton" type="submit">Continue</button>
                </div>
            </form>
            <?php
                define("ONE_HOUR", 60 * 60 * 1);

                setcookie("user", $_POST["loginUsername"], time() + ONE_HOUR);
                setcookie("pass", $_POST["loginPassword"], time() + ONE_HOUR);
            ?>
        </body>
    </head>
</html>