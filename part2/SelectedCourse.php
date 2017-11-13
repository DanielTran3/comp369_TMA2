<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="Learnatorium.js" ></script>
    </head>
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
        <?php
            // PHP parser for Lesson EMLs. Returns a string that is HTML decoded and
            // is ready to be displayed in a browser
            function lessonEMLParser($lesson, $courseID, $database) {
                $lesson = parseOverview($lesson);
                $lesson = parseOutline($lesson);
                $lesson = parseIntroduction($lesson);
                $lesson = parseSection($lesson);
                $lesson = parseParagraph($lesson);
                $lesson = parseLearningObjects($lesson, $courseID, $database);
                
                return htmlspecialchars_decode($lesson);
            }

            // Parse the Overview section
            function parseOverview($lesson) {
                // $patterns = array();
                // $patterns[0] = "/\b&lt;Overview&gt;\b/";
                // $patterns[1] = "/\b&lt;\/Overview&gt;\b/";
                // $replacementStrings = array();
                // $replacementStrings[0] = "&lt;h2&gt;Overview&lt;/h2&gt;&lt;p&gt;";
                // $replacementStrings[1] = "&lt;/p&gt;";
                
                // Create an Overview h2 header and display the contents of the overview in a p element
                $lesson = preg_replace('/&lt;Overview&gt;/', '&lt;h2&gt;Overview&lt;/h2&gt;&lt;p&gt;', $lesson);
                $lesson = preg_replace('/&lt;\/Overview&gt;/', '&lt;/p&gt;', $lesson);

                return $lesson;
            }

            // Parse the outline that is stored within the Overview
            function parseOutline($lesson) {
                // Replace the Outline tag with unordered list (ul) tags
                $lesson = preg_replace('/&lt;Outline&gt;/', '&lt;ul&gt;', $lesson);
                $lesson = preg_replace('/&lt;\/Outline&gt;/', '&lt;/ul&gt;', $lesson);

                // Replacae the BulletPoint tags with list element (li) tags
                $lesson = preg_replace('/&lt;BulletPoint&gt;/', '&lt;li&gt;', $lesson);
                //$lesson = preg_replace('/&lt;\/BulletPoint&gt;/', '&lt;/ligt;', $lesson);

                return $lesson;
            }

            // Parse the introduction
            function parseIntroduction($lesson) {
                // Create an Introduction h2 element and store the contents of the 
                $lesson = preg_replace('/&lt;Introduction&gt;/', '&lt;h2&gt;Introduction&lt;/h2&gt;&lt;p&gt;', $lesson);
                $lesson = preg_replace('/&lt;\/Introduction&gt;/', '&lt;/p&gt;', $lesson);

                return $lesson;
            }

            function parseSection($lesson) {
                $lesson = preg_replace('/&lt;Section&gt;/', '&lt;h2&gt;', $lesson);
                $lesson = preg_replace('/&lt;\/Section&gt;/', '&lt;/h2&gt;', $lesson);

                return $lesson;
            }

            function parseParagraph($lesson) {
                $lesson = preg_replace('/&lt;Paragraph&gt;/', '&lt;p&gt;', $lesson);
                $lesson = preg_replace('/&lt;\/Paragraph&gt;/', '&lt;/p&gt;', $lesson);

                return $lesson;
            }

            function parseLearningObjects($lesson, $courseID, $database) {
                $query = "SELECT name FROM courses where ID='$courseID'";
                if (!($result = mysql_query($query, $database))) 
                {
                    print( "<p>Could not retrieve course ID</p>" );
                    die("</body></html>");
                }
                $course = mysql_fetch_assoc($result);
                
                $lesson = preg_replace('/&lt;Image filename="/', '&lt;image src="./uploads/' . $course['name'] . $courseID . '/', $lesson);
                $lesson = preg_replace('/&lt;\/Image&gt;/', '', $lesson);
                echo("before: ". $lesson);
                $lesson = preg_replace('/(&lt;image src=".+?[\s\S]") description=(".+?[\s\S]"&gt;)/', '$1alt=$2', $lesson);
                echo($lesson);
                $lesson = preg_replace('/&lt;Video filename="/', '&lt;video width="360" height="240" controls&gt; &lt;source type="video/mp4" src="./uploads/' . $course['name'] . $courseID . '/', $lesson);
                $lesson = preg_replace('/&lt;\/Video&gt;/', 'Your Browser Does Not Support Video. &lt;/video&gt;', $lesson);

                $lesson = preg_replace('/&lt;Audio filename="/', '&lt;audio controls&gt; &lt;source type="audio/mpeg" src="./uploads/' . $course['name'] . $courseID . '/', $lesson);
                $lesson = preg_replace('/&lt;\/Audio&gt;/', 'Your Browser Does Not Support Audio. &lt;/audio&gt;', $lesson);

                return $lesson;
            }

            function quizEMLParser($quiz) {
                $quiz = parseQuestion($quiz);
                $quiz = parseAnswers($quiz);

                return htmlspecialchars_decode($quiz);
            } 
            function parseQuestion($quiz) {
                $quiz = preg_replace('/&lt;Question/', '&lt;h3', $quiz);
                $quiz = preg_replace('/&lt;\/Question&gt;/', '&lt;/h3&gt;', $quiz);

                return $quiz;
            }
            function parseAnswers($quiz) {
                $quiz = preg_replace('/&lt;Answer/', '&lt;input type="radio"', $quiz);
                $quiz = preg_replace('/&lt;\/Answer&gt;/', '&lt;/input&gt; &lt;br /&gt;', $quiz);

                return $quiz;
            }
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
                    // Retrieve the user's satatus and check if they are an admin or not. If they are,
                    // display the Create A Course link
                    $adminRights = mysql_fetch_assoc($result);
                    if ($adminRights["admin"]) {
                        print('<li><a href="CreateCourseContent.php">Create A Course</a></li>');
                    }
                ?>
            </ul>
        </div>
        <form id="selectCourseForm" method="post" action="SelectedCourse.php">
        <!-- <div class="aside"> -->
        <?php
            $courseName = $_POST["submittedCourse"];
            $courseID = $_POST["courseId"];
            // Connect to MySQL
            if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                die("Could not connect to database </body></html>");
            }

            // open Products database
            if (!mysql_select_db( "learnatorium", $database)) {
                die("Could not open learnatorium database </body></html>");
            }

            // $query = "SELECT ID FROM courses where name='$courseName'";
            // if (!($result = mysql_query($query, $database))) 
            // {
            //     print( "<p>Could not retrieve Course ID</p>" );
            //     print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
            //     die("</body></html>");
            // }

            // $courseID = mysql_fetch_assoc($result)["ID"];
            print("<p> CourseID: " . $courseID . "</p>");    
            $query = "SELECT ID, name FROM units where course='$courseID'";
            if (!($result = mysql_query($query, $database))) 
            {
                print( "<p>Could not retrieve Unit ID or Unit Name</p>" );
                print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                die("</body></html>");
            }

            if (mysql_num_rows($result) > 0) {
                // $curIndex = 0;
                while($unitRow = mysql_fetch_assoc($result)) {
                    // $unitName = $unitRow['name'];
                    // if ($curIndex == 0) {
                    //     print("<button id='defaultOpen' class='active tablinks' onclick='changeTab(this)'>" . $unitName . "</button>");
                    // }
                    // else {
                    //     print("<button class='tablinks' onclick='changeTab(this)'>" . $unitName . "</button>");
                    // }
                    // $curIndex++;
                    $unitID = $unitRow['ID'];
                    print("<p> UnitID: " . $unitID . "</p>");    
                    print("<h1>" . $unitRow['name'] . "</h1>");
                
                    $lessonQuery = "SELECT ID, name, content FROM lessons where unit='$unitID'";
                    if (!($lessonResult = mysql_query($lessonQuery, $database))) 
                    {
                        print( "<p>Could not retrieve lesson Name or Lesson Content</p>" );
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }

                    if (mysql_num_rows($lessonResult) > 0) {
                        // $curIndex = 0;
                        while($lessonRow = mysql_fetch_assoc($lessonResult)) {
                            $lessonID = $lessonRow['ID'];
                            print("<p> LessonID: " . $lessonID . "</p>");    
                    
                            print("<h2>" . $lessonRow["name"] . "</h2>");
                            $lessonContent = $lessonRow["content"];
                            $lessonContent = lessonEMLParser($lessonContent, $courseID, $database);
                            print($lessonContent);
                        
                            $quizQuery = "SELECT content FROM quizzes where lesson='$lessonID'";
                            if (!($quizResult = mysql_query($quizQuery, $database))) 
                            {
                                print( "<p>Could not retrieve quiz Content</p>" );
                                print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                                die("</body></html>");
                            }

                            if (mysql_num_rows($quizResult) > 0) {
                                print("<div id='$lessonID'>");
                                print("<h1>" . $lessonRow["name"] . " - Quiz</h1>");
                                while ($quizRow = mysql_fetch_assoc($quizResult)) {
                                    $quizContent = $quizRow["content"];
                                    $quizContent = quizEMLParser($quizContent);
                                    print($quizContent);
                                }
                                print("<input type='button' class='whiteButton' value='Submit Quiz' onclick='MarkQuiz($lessonID)'/>");
                                print("</div>");
                            }
                        }
                    }
                }
            }
            mysql_close( $database );
        ?>
        <!-- </div>
        <div class="main-content">
        
        </div> -->
    </body>
</html>