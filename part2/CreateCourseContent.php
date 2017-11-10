<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="Learnatorium.js" ></script>
        <script type="text/javascript">
            window.onload = function () {
                InitListeners();
            }
        </script>
        <title>SiteMark</title>
    </head>
    <body>
        <?php
            // Check for valid user login, if there is one, redirect the user to the main page
            if (!isset($_COOKIE["user"])) {
                header("Location:Learnatorium.php");
            }

            $query = "SELECT admin FROM users WHERE username='$_COOKIE[user]'";
            
            // Connect to MySQL
            if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                die("Could not connect to database </body></html>");
            }

            // open users database
            if (!mysql_select_db( "Learnatorium", $database)) {
                die("Could not open products database </body></html>");
            }

            // Execute the select query and retrieve the user's bookmarks
            if (!($result = mysql_query( $query, $database))) 
            {
                // If the select query failed, notify the user
                print( "<p>Failed to retrieve your user status</p>" );
                print("<form method='post' action='WelcomeToSiteMark.php'>");
                print("<button class='whiteButton' type='submit' style='margin-top:0px;'>Continue</button>");
                print("</form>");
                die( mysql_error() . "</body></html>" );
            }

            // Query was valid, close the database and display the main page
            mysql_close( $database );
        ?>
        <div class="linksBar">
            <h1 class="banner">Learn The Web</h1>
            <span class="title4 floatRight" style="color:white"> Welcome <?php print($_COOKIE["user"]) ?>, <a href="Logout.php">Logout?</a></span>
            <ul>
                <li>
                    <a href="../tma1.htm">Home</a>
                </li>
                <li>
                    <a href="../part1/WelcomeToResume.html">Resume</a>
                </li>
                <li>
                    <a href="AvailableCourses.php">Available Courses</a>
                </li>
                <li>
                    <a href="YourCourses.php">Your Courses</a>
                </li>
                <?php 
                    $adminRights = mysql_fetch_assoc($result);
                    if ($adminRights["admin"]) {
                        print('<li><a href="CreateCourseContent.php">Create A Course</a></li>');
                    }
                    else {
                        header("Location:Learnatorium.php");
                    }
                ?>
            </ul>
        </div>
        <div id="mainDiv">
            <h1 class="title1">Create A Course</h1>
            <form id="addBookmarkForm" method="post" action="UploadCourse.php">    
                <div id="courseDiv" class="innerDiv">
                    <span>Course Name: </span>
                    <input id="courseNameInput" name="courseNameName" type="text" class="largeInputBox"></input>        
                    <button type="button" id="addUnitButton" class="whiteButton" Value="AddUnit">Add Unit</button>
                    <button type="submit" id="createCourseButton" class="whiteButton" Value="CreateCourse">Create Course</button>                
                    <input id="uploadFile" name="fileToUpload" type="file" multiple></input>        
                </div>
            </form>
        </div>
    </body>
</html>