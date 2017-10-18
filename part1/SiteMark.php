<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="SiteMark.js" ></script>
        <script type="text/javascript">
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
            if (!isset($_COOKIE["user"]) || !isset($_COOKIE["pass"])) {
                header("Location:SiteMarkLogin.php");
            }

            $query = "SELECT url, name FROM bookmarks WHERE username='$_COOKIE[user]'";

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
        <h1 class="title1">SiteMark</h1>
        <div id="bookmarkDiv">
            <ol>
                <?php
                    while($row = mysql_fetch_assoc($result)) {
                        $urlVal = $row["url"];
                        $nameVal = $row["name"];
                        print("<li class='bookmarkListElement'><p href='$urlVal' class='blueText' onclick='OpenURL(this);'>$nameVal</p></li>");
                    }
                ?>
            </ol>
        </div>
        <form method="post" onsubmit="return VerifyURL()" action="AddBookmark.php">    
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
            <button id="addBookmarkButton" type="submit" class="whiteButton" style="margin-top:0px;">Add Bookmark</button>
        </form>
        <form method="post" action="EditBookmark.php">
            <input type="hidden" name="oldBookmarkName"></input>
            <input type="hidden" name="oldBookmarkURL"></input>
            <input type="hidden" name="editedBookmarkName"></input>
            <input type="hidden" name="editedBookmarkURL"></input>
            <button id="editBookmarkButton" type="submit" class="whiteButton" style="margin-top:0px;">Edit Bookmark</button>            
        </form>
        <form method="post" action="DeleteBookmark.php">
            <input type="hidden" name="bookmarkNameToDelete"></input>
            <input type="hidden" name="bookmarkURLToDelete"></input>            
            <button id="deleteBookmarkButton" type="submit" class="whiteButton" style="margin-top:0px;">Delete Bookmark</button>        
        </form>
        </div>
    </body>
</html>