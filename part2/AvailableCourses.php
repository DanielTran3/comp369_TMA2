<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
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
                        if ($adminRights == 1) {
                            print('<li><a href="CreateCourseContent.php">Create A Course</a></li>');
                        }
                    ?>
                </ul>
            </div>
            <div>
                <h1>Available Courses</h1>
                <form id="selectCourseForm" method="post" action="SelectedCourse.php">
                <input type="hidden" name="courseId"></input>
                <?php
                    // Connect to MySQL
                    if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                        die("Could not connect to database </body></html>");
                    }

                    // open Products database
                    if (!mysql_select_db( "Learnatorium", $database)) {
                        die("Could not open Learnatorium database </body></html>");
                    }

                    // $query = "SELECT courses FROM users";
                    $query = "SELECT ID, name FROM courses";
                    if (!($result = mysql_query($query, $database))) 
                    {
                        print( "<p>Could not add Course</p>" );
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }

                    if (mysql_num_rows($result) > 0) {
                        print("<ul>");
                        while($row = mysql_fetch_assoc($result)) {
                            $val = $row['name'];
                            $courseID = $row['ID'];
                            print("<li><input id='$courseID' type='submit' class='whiteButton' style='margin:0px' onclick='SelectACourse(this)' value='$val' /></li>");
                        }
                        print("</ul>");
                    }

                    mysql_close( $database );
                ?>
                </form>
            </div>
        </body>
    </head>
</html>