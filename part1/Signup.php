<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <?php
                $user = $_POST["signupUsername"];
                $pass = $_POST["signupPassword"];

                // $query = "INSERT INTO credentials ('username', password') VALUES ("  . $user . ", " . $password . ")";
                $query = "INSERT INTO credentials (username, password) VALUES ('$user', '$pass')";

                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // open Products database
                if (!mysql_select_db( "users", $database)) {
                    die("Could not open products database </body></html>");
                }

                // query Products database
                if (!($result = mysql_query( $query, $database))) 
                {
                    print( "<p>Could not execute query!</p>" );
                    die( mysql_error() . "</body></html>" );
                } // end if
                mysql_close( $database );
            ?>

            <form method="post" action="SiteMark.php">
                <div class="welcomeText">
                    <h1 class="title1 titleFont">SiteMark</h1>

                    <span class="title1">You've Been signed up <?php print($user) ?>!</span>
                    <span class="title4">Click the button below to continue</span>
                    <button class="whiteButton" type="submit">Continue</button>
                </div>
            </form>
            <?php
                define("ONE_HOUR", 60 * 60 * 1);

                setcookie("user", $_POST["signupUsername"], time() + ONE_HOUR);
                setcookie("pass", $_POST["signupPassword"], time() + ONE_HOUR);
            ?>
        </body>
    </head>
</html>