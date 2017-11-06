<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma3_stylesheet.css" />
        <body>
            <?php
                $unitName = $_POST['unit'];
                foreach ($unitName as $unit) {
                    echo($unit);
                }
                
                print("<hr />");

                print("<p> PAUL </p>");
            ?>
        </body>
    </head>
</html>


<!-- // foreach ($_POST['numLessons'] as $number) {
                //     print("<p>" + $number + " | </p>");
                // }
                // echo($_POST['unit'][0]); -->

<!-- print("<hr />");

                foreach($_POST["numLessons[]"] as $num) {
                    echo($num);
                }

                print("<hr />");                

                foreach($_POST["eml[]"] as $eml) {
                    echo($eml);
                } -->


<!-- 
// $query = "INSERT INTO bookmarks (username, url, name, hits) VALUES ('$user', '$url', '$name', '0')";

                // // Connect to MySQL
                // if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                //     die("Could not connect to database </body></html>");
                // }

                // // open Products database
                // if (!mysql_select_db( "users", $database)) {
                //     die("Could not open products database </body></html>");
                // }

                // // query Products database
                // if (!($result = mysql_query($query, $database))) 
                // {
                //     print( "<p>The bookmark already exists!</p>" );
                //     print( "<p><a href='SiteMark.php'>Click Here</a> to continue.</p>" );
                //     die("</body></html>");
                // } // end if
                // mysql_close( $database );
                // header("Location:CreateCourseContent.php"); -->