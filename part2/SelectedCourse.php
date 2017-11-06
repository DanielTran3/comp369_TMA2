<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <div class="linksBar">
                <h1 class="banner">Learn The Web</h1>
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
                        <a href="CreateCourseContent.php">Create A Course</a>
                    </li>
                    <li>
                        <a href="YourCourses.php">Your Courses</a>
                    </li>
                </ul>
            </div>
            <div>
                <?php
                    $courseName = $_POST["submittedCourse"];
                    // Connect to MySQL
                    if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                        die("Could not connect to database </body></html>");
                    }

                    // open Products database
                    if (!mysql_select_db( "learnatorium", $database)) {
                        die("Could not open learnatorium database </body></html>");
                    }

                    $query = "SELECT ID FROM courses where name='$courseName'";
                    if (!($result = mysql_query($query, $database))) 
                    {
                        print( "<p>Could not retrieve Course ID</p>" );
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }

                    $courseID = mysql_fetch_assoc($result)["ID"];

                    $query = "SELECT ID, name FROM units where course='$courseID'";
                    if (!($result = mysql_query($query, $database))) 
                    {
                        print( "<p>Could not retrieve Unit ID or Unit Name</p>" );
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }

                    if (mysql_num_rows($result) > 0) {
                        print("<ol>");
                        while($row = mysql_fetch_assoc($result)) {
                            print("<li>" . $row["ID"] . " " . $row["name"] . "</li>");
                        }
                        print("</ol>");
                    }

                    mysql_close( $database );
                ?>
            </div>
        </body>
    </head>
</html>