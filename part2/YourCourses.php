<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="Learnatorium.js" ></script>
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
                <h1>Your Courses</h1>
                <form id="selectCourseForm" method="post" action="SelectedCourse.php">
                <?php
                    // Connect to MySQL
                    if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                        die("Could not connect to database </body></html>");
                    }

                    // open Products database
                    if (!mysql_select_db( "learnatorium", $database)) {
                        die("Could not open learnatorium database </body></html>");
                    }

                    // $query = "SELECT courses FROM users";
                    $query = "SELECT name FROM courses";
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
                            print("<li><input type='submit' class='whiteButton' style='margin:0px' onclick='SelectACourse(this)' value='$val' /></li>");
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