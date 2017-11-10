<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="SiteMark.js" ></script>
        <script type="text/javascript"></script>
        <title>Welcome To SiteMark</title>
    </head>
    <body>
        <?php
            // Create a query that looks at all of the bookmarks in the database and orders it in descending
            // order by number of hits. Thus, the bookmarks with the most hits are at the top
            $query = "SELECT url, name FROM bookmarks ORDER BY hits DESC";

            // Connect to MySQL
            if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                die("Could not connect to database </body></html>");
            }

            // open users database
            if (!mysql_select_db( "users", $database)) {
                die("Could not open products database </body></html>");
            }

            // Execute the select query and return the resulting rows back to be read
            if (!($result = mysql_query( $query, $database))) 
            {
                // Error retrieving the bookmarks
                print( "<p>Could retrieve Top 10 Marked Sites</p>" );
                die( mysql_error() . "</body></html>" );
            }

            // Query was successful, close the database
            mysql_close( $database );
        ?>

        <div class="welcomeText">
            <span class="title1">Welcome To SiteMark</span>
            <span class="title2">Top 10 Marked Sites!</span>
            <div id="bookmarkDiv" style="text-align:start;">
                <ol>
                    <?php
                        // Iterate through the first 10 bookmarks from the query and display them on the main page
                        $numBookmarks = 0;
                        while($row = mysql_fetch_assoc($result)) {
                            if ($numBookmarks > 9) {
                                break;
                            }
                            $urlVal = $row["url"];
                            $nameVal = $row["name"];
                            print("<li class='bookmarkListElement'><p href='$urlVal' class='blueText' onclick='OpenURL(this);'>$nameVal</p></li>");
                            $numBookmarks++;
                        }
                    ?>
                </ol>
            </div>
            <div class="innerDiv" style="width: 225px;">
                <form action="SiteMarkLogin.php">    
                    <button class="whiteButton floatLeft" style="height: 50px; width: 100px;"type="submit">Login</button>
                </form>
                <form action="SiteMarkSignup.php">    
                    <button class="whiteButton floatRight" style="height: 50px; width: 100px;"type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </body>
</html>