<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="Learnatorium.js" ></script>
        <script type="text/javascript">
            // Load the event listeners for the buttons and for selecting a bookmark to fill in the
            // appropriate field information
            window.onload = function () {
                $('.availableCourse').click(function(){
                    SelectCourse(this);
                });
            }
        </script>
        <body>
            <?php
                // Check for valid user login, if there is one, redirect the user to the main page
                if (!isset($_COOKIE["user"])) {
                    header("Location:LearnatoriumLogin.php");
                }

                // Create a query to the users table to get the admin status of the currently
                // logged in user
                $query = "SELECT admin FROM users WHERE username='$_COOKIE[user]'";
                
                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }
    
                // Open Learnatorium database
                if (!mysql_select_db( "Learnatorium", $database)) {
                    die("Could not open products database </body></html>");
                }
    
                // Execute the to retrieve the user's admin status
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
                        // display the Create A Course link
                        $adminRights = mysql_fetch_assoc($result);
                        if ($adminRights["admin"]) {
                            print('<li><a href="CreateCourseContent.php">Create A Course</a></li>');
                        }
                    ?>
                </ul>
            </div>
            <div>
                <form id="selectCourseForm" method="post" action="AddCourse.php">            
                    <h1>Available Courses</h1>
                    <input type='hidden' id="addCourseID" name="addCourseID"></input>
                    <input id='$courseID' type='submit' class='whiteButton' style='margin:0px' onclick='SelectACourse(this)' value='Add Course' />                  
                </form>
                <form id="selectCourseForm" method="post" action="SelectedCourse.php">
                <input type="hidden" name="courseId"></input>
                <?php
                    // Connect to MySQL
                    if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                        die("Could not connect to database </body></html>");
                    }

                    // Open Learnatorium database
                    if (!mysql_select_db( "Learnatorium", $database)) {
                        die("Could not open Learnatorium database </body></html>");
                    }

                    // Get the currently logged in user's name
                    $user = $_COOKIE["user"];

                    // Create a query to retrieve all of the available courses (or courses that the user has not added yet)
                    $query = "SELECT ID, name FROM courses WHERE ID NOT IN (SELECT courseID FROM usersCourses WHERE username='$user')";
                    if (!($result = mysql_query($query, $database))) 
                    {
                        print( "<p>Could not find available Course</p>" );
                        print( "<p><a href='Learnatorium.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }

                    // Check if there are any available courses for the user to add
                    if (mysql_num_rows($result) > 0) {
                        print("<ul>");
                        // Iterate through each of the available courses and display them as list elements
                        while($row = mysql_fetch_assoc($result)) {
                            $val = $row['name'];
                            $courseID = $row['ID'];
                            print("<li id='$courseID' class='courseListItem availableCourse'><h2 style='margin:0px'>$val</h2></li>");
                        }
                        print("</ul>");
                    }
                    else {
                        print("<h1>There are currently no available courses, or you have added all available courses");
                    }

                    mysql_close( $database );
                ?>
                </form>
            </div>
        </body>
    </head>
</html>