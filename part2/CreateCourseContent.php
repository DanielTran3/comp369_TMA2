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
                header("Location:LearnatoriumLogin.php");
            }

            // Create a query to the users table to get the admin status of the currently logged in user
            $query = "SELECT admin FROM users WHERE username='$_COOKIE[user]'";
            
            // Connect to MySQL
            if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                die("Could not connect to database </body></html>");
            }

            // open Learnatorium database
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
            <h1 class="banner">Learnatorium</h1>
            <!-- Print the user's name along with a link to log out -->
            <span class="title4 floatRight" style="color:white"> Welcome <?php print($_COOKIE["user"]) ?>, <a href="Logout.php">Logout?</a></span>
            <ul>
                <li>
                    <a href="../tma2.htm">Home</a>
                </li>
                <li>
                    <a href="../part1/WelcomeToSiteMark.php">SiteMark</a>
                </li>
                <li>
                    <a href="../part2/WelcomeToLearnatorium.php">Learnatorium</a>
                </li>
                <li>
                    <a href="../part2/AvailableCourses.php">Available Courses</a>
                </li>
                <li>
                    <a href="../part2/YourCourses.php">Your Courses</a>
                </li>
                <?php 
                    // Retrieve the user's satatus and check if they are an admin or not. If they are,
                    // display the Create A Course link, otherwise send the user back to the Learnatorium main page
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
            <form id="addCourse" method="post" action="UploadCourse.php" enctype="multipart/form-data">    
                <div id="courseDiv" class="innerDiv">
                    <span>Course Name: </span>
                    <input id="courseNameInput" name="courseNameName" type="text" class="largeInputBox"></input>        
                    <button type="button" id="addUnitButton" class="whiteButton" Value="AddUnit">Add Unit</button>
                    <button type="submit" id="createCourseButton" class="whiteButton" Value="CreateCourse">Create Course</button>                
                    <br />  
                    <label>Add Learning Objects: </label>
                    <input id="uploadFile" name="learningObjects[]" class="whiteButton" type="file" multiple></input>        
                    <button type="submit" id="createCourseButton" class="whiteButton" Value="CreateCourse">Create Course</button>   
                </div>
            </form>
        </div>
    </body>
</html>