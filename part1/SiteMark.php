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
                        print("<li class='bookmarkListElement'><a href='$urlVal'>$nameVal</a></li>");
                    }
                ?>
            </ol>
        </div>
        <form method="post" action="AddBookmark.php">    
            <div class="innerDiv" style="width: 350px;">
                <span class="floatLeft">Bookmark Name: </span>
                <input id="newBookmarkNameTextBox" name="newBookmarkName" type="text" class="largeInputBox floatRight"></input>        
            </div>
            <div class="innerDiv" style="width: 350px;">
                <span class="floatLeft">URL: </span>
                <input id="newBookmarkTextBox" name="newBookmarkURL" type="text" class="largeInputBox floatRight"></input>
            </div>
            <button id="addBookmarkButton" type="submit" class="whiteButton" style="margin-top:0px;">Add Bookmark</button>
        </form>
        <form method="post" action="editBookmark.php">
            <button id="editBookmarkButton" type="submit" class="whiteButton" style="margin-top:0px;">Edit Bookmark</button>            
        </form>
        <form method="post" action="deleteBookmark.php">
            <button id="deleteBookmarkButton" type="submit" class="whiteButton" style="margin-top:0px;">Delete Bookmark</button>        
        </form>
    </body>
</html>