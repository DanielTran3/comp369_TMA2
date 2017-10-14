<!DOCTYPE html>
<html>
   <head>
      <meta charset = "utf-8">
      <body>
            <?php
                  $username = $_POST["signupUsername"];
                  $password = $_POST["signupPassword"];

                  $query = "INSERT INTO credentials (username, password) VALUES ("  . $username . ", " . $password . ")";

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
      </body>
</head>