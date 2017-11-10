<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="SiteMark.js" ></script>
        <script type="text/javascript">
            // Load the event listeners for the buttons and for selecting a bookmark to fill in the
            // appropriate field information
            window.onload = function () {
                initListeners();
                $('.bookmarkListElement').click(function(){
                    SelectBookmark(this);
                });
            }
        </script>
        <title>SiteMark</title>
    </head>
    <body>
        <div id="mainDiv">
        <span class="title4"> Welcome <?php print($_COOKIE["user"]) ?>, <a href="Logout.php">Logout?</a>
        <?php
            echo $_COOKIE["user"];
            echo $_COOKIE["pass"];
            // Check for valid user login, otherwise redirect to login screen
            if (!isset($_COOKIE["user"]) || !isset($_COOKIE["pass"])) {
                header("Location:SiteMarkLogin.php");
            }

            // Create a select query to the URL addresses and the name of the bookmark from the database
            $query = "SELECT url, name FROM bookmarks WHERE username='$_COOKIE[user]'";

            // Connect to MySQL
            if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                die("Could not connect to database </body></html>");
            }

            // open users database
            if (!mysql_select_db( "users", $database)) {
                die("Could not open products database </body></html>");
            }

            // Execute the select query and retrieve the user's bookmarks
            if (!($result = mysql_query( $query, $database))) 
            {
                // If the select query failed, notify the user
                print( "<p>Failed to retrieve your bookmarks</p>" );
                print("<form method='post' action='WelcomeToSiteMark.php'>");
                print("<button class='whiteButton' type='submit' style='margin-top:0px;'>Continue</button>");
                print("</form>");
                die( mysql_error() . "</body></html>" );
            }

            // Query was valid, close the database and display the main page
            mysql_close( $database );
        ?>
        <h1 class="title1">SiteMark</h1>
        <div id="bookmarkDiv">
            <ol>
                <?php
                    // Iterate through each row of the query from the database and create list elements
                    // that contain a p element that can redirect the user to the bookmark URL. The name displayed is 
                    // the name retrieved from the database
                    while($row = mysql_fetch_assoc($result)) {
                        $urlVal = $row["url"];
                        $nameVal = $row["name"];
                        print("<li class='bookmarkListElement'><p href='$urlVal' class='blueText' onclick='OpenURL(this);'>$nameVal</p></li>");
                    }
                ?>
            </ol>
        </div>
        <form id="addBookmarkForm" method="post" action="AddBookmark.php">    
            <div class="innerDiv" style="width: 350px;">
                <span class="floatLeft">Bookmark Name: </span>
                <input id="newBookmarkNameTextBox" name="newBookmarkName" type="text" class="largeInputBox floatRight"></input>        
            </div>
            <div class="innerDiv" style="width: 350px;">
                <span id="urlLabel" class="floatLeft">URL: </span>
                <input id="newBookmarkTextBox" name="newBookmarkURL" type="text" class="largeInputBox floatRight"></input>
                <br />
                <br />
                <span id="invalidURL" class="errorText" style="margin-top:10px" hidden>Please input a URL with correct formatting. <br /> (ex. http://www.google.ca)</span>
                <span id="inactiveURL" class="errorText" style="margin-top:10px" hidden>Please input an active URL with correct formatting. <br /> (ex. http://www.google.ca)</span>
            </div>
        </form>            
        <button id="addBookmarkButton" type="submit" class="whiteButton" style="margin-top:0px;">Add Bookmark</button>
        
        <form id="editBookmarkForm" method="post" action="EditBookmark.php">    
            <!-- Hidden elements taht contain the old and new URL information for editing the URLS in the database -->
            <input type="hidden" name="oldBookmarkName"></input>
            <input type="hidden" name="oldBookmarkURL"></input>
            <input type="hidden" name="editedBookmarkName"></input>
            <input type="hidden" name="editedBookmarkURL"></input>
        </form>
        <button id="editBookmarkButton" type="submit" class="whiteButton" style="margin-top:0px;">Edit Bookmark</button>            
        <form method="post" action="DeleteBookmark.php">
            <input type="hidden" name="bookmarkNameToDelete"></input>
            <input type="hidden" name="bookmarkURLToDelete"></input>            
            <button id="deleteBookmarkButton" type="submit" class="whiteButton" style="margin-top:0px;">Delete Bookmark</button>        
        </form>
        </div>
    </body>
</html>