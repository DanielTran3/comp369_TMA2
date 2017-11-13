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
                print("<form method='post' action='YourCourses.php'>");
                print("<button class='whiteButton' type='submit' style='margin-top:0px;'>Continue</button>");
                print("</form>");
                die( mysql_error() . "</body></html>" );
            }

            // Query was valid, close the database and display the main page
            mysql_close( $database );
        ?>
        <?php
            // PHP parser for Lesson EMLs. Returns a string that is HTML decoded and is ready to be displayed in a browser
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

                // Replace the BulletPoint tags with list element (li) tags
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

            // Parse a section header title
            function parseSection($lesson) {
                // Parse the Section tag as a h2 tag
                $lesson = preg_replace('/&lt;Section&gt;/', '&lt;h2&gt;', $lesson);
                $lesson = preg_replace('/&lt;\/Section&gt;/', '&lt;/h2&gt;', $lesson);

                return $lesson;
            }

            // Parse a paragraph within a lesson
            function parseParagraph($lesson) {
                // Parse the Paragraph tag a p tag
                $lesson = preg_replace('/&lt;Paragraph&gt;/', '&lt;p&gt;', $lesson);
                $lesson = preg_replace('/&lt;\/Paragraph&gt;/', '&lt;/p&gt;', $lesson);

                return $lesson;
            }

            // Parse the learning objectives, where the program currently supports images, videos, and audio files
            function parseLearningObjects($lesson, $courseID, $database) {
                // Query for the current course
                
                // Match for all <Image filename= and get the value of the filename
                $allFilenames = preg_match_all('/&lt;Image filename="(.+?[\s\S])"/', $lesson, $match);

                // Iterate through each matched filename
                foreach ($match[1] as $nameOfFile) {

                    // Get the location of the lesson object based on the course ID and the name of the file
                    $query = "SELECT location FROM lessonObjects WHERE course = '$courseID' AND filename = '$nameOfFile'";
                    if (!($result = mysql_query($query, $database))) 
                    {
                        print( "<p>Could not retrieve Lesson Object Location</p>" );
                        die("</body></html>");
                    }

                    // Retrieve the current Lesson Object file location
                    $lessonObjectLocation = mysql_fetch_assoc($result);
                    $lessonObjectLocation = $lessonObjectLocation['location'];
                    
                    // Parse the Image tag to replace it with an image tag and replace the filename attribute with a src attribute, 
                    // pointing to the designated file location.
                    $lesson = preg_replace('/&lt;Image filename="' . $nameOfFile . '/', '&lt;image src="' . $lessonObjectLocation, $lesson);
                    $lesson = preg_replace('/&lt;\/Image&gt;/', '', $lesson);
                    
                    // Parse the description tag and replace it with an alt tag. This is done by matching the image tag with the source attribute as 
                    // a group and the value of the description attribute as another group. Afterwards, the description tag is replaced with an alt 
                    // tag and the saved groups are unaffected.
                    $lesson = preg_replace('/(&lt;image src=".+?[\s\S]") description=(".+?[\s\S]"&gt;)/', '$1alt=$2', $lesson);
                    
                    // Replace the Video tag with a video tag set the width and height of the video to 360px by 240px. Also set controls for the video.
                    // Currently, the only supported source type is mp4. Set the filename attribute to be a src attribute with a value set to the 
                    // respective file location
                    $lesson = preg_replace('/&lt;Video filename="' . $nameOfFile . '/', '&lt;video width="360" height="240" controls&gt; &lt;source type="video/mp4" src="' . $lessonObjectLocation, $lesson);
                    $lesson = preg_replace('/&lt;\/Video&gt;/', 'Your Browser Does Not Support Video. &lt;/video&gt;', $lesson);

                    // Replace the Audio tag with a audio tag and set the controls for the audio input. Currently, the only supported source type 
                    // is mp3 (or mpeg). Set the filename attribute to be a src attribute with a value set to the respective file location
                    $lesson = preg_replace('/&lt;Audio filename="' . $nameOfFile . '/', '&lt;audio controls&gt; &lt;source type="audio/mpeg" src="' . $lessonObjectLocation, $lesson);
                    $lesson = preg_replace('/&lt;\/Audio&gt;/', 'Your Browser Does Not Support Audio. &lt;/audio&gt;', $lesson);
                }

                return $lesson;
            }

            // PHP parser for Quiz EMLs. Returns a string that is HTML decoded and is ready to be displayed in a browser
            function quizEMLParser($quiz) {
                $quiz = parseQuestion($quiz);
                $quiz = parseAnswers($quiz);

                return htmlspecialchars_decode($quiz);
            } 

            // Parse the Quiz's question
            function parseQuestion($quiz) {
                // Parse the Question tag as a h3 tag
                $quiz = preg_replace('/&lt;Question/', '&lt;h3', $quiz);
                $quiz = preg_replace('/&lt;\/Question&gt;/', '&lt;/h3&gt;', $quiz);

                return $quiz;
            }

            // Parse the Quiz's answer
            function parseAnswers($quiz) {
                // Parse the Answer tag as a radio input tag
                $quiz = preg_replace('/&lt;Answer/', '&lt;input type="radio"', $quiz);
                $quiz = preg_replace('/&lt;\/Answer&gt;/', '&lt;/input&gt; &lt;br /&gt;', $quiz);

                return $quiz;
            }
        ?>
        <div class="linksBar">
            <h1 class="banner">Learnatorium</h1>
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
        <div id="courseContentDiv">
        <?php
            // If the page is refreshed or there is no submitted course name or course ID, 
            // then return the user to the 'Your Courses' page
            if (!isset($_POST["submittedCourse"]) || !isset($_POST["courseId"])) {
                header("Location:YourCourses.php");
            }
            // Get the course name and ID
            $courseName = $_POST["submittedCourse"];
            $courseID = $_POST["courseId"];

            // Connect to MySQL
            if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                die("Could not connect to database </body></html>");
            }

            // open Learnatorium database
            if (!mysql_select_db("Learnatorium", $database)) {
                die("Could not open learnatorium database </body></html>");
            }

            // Get the unit's ID and Name from the current course using the course ID
            $query = "SELECT ID, name FROM units where course='$courseID'";
            if (!($result = mysql_query($query, $database))) 
            {
                // Could not retrieve information about the unit, display error message to the user
                print( "<p>Could not retrieve Unit ID or Unit Name</p>" );
                print( "<p><a href='YourCourses.php'>Click Here</a> to continue.</p>" );
                die("</body></html>");
            }

            // Iterate through each each unit in the course and retrieve the course material
            // (units, lessons, and quiz information)
            if (mysql_num_rows($result) > 0) {
                while($unitRow = mysql_fetch_assoc($result)) {

                    // Get the unit ID
                    $unitID = $unitRow['ID'];

                    // Display the unit name in as a h1 title
                    print("<h1 class='title'>" . $unitRow['name'] . "</h1>");
                
                    // Query for the lesson ID, name, and EML content for the unit
                    $lessonQuery = "SELECT ID, name, content FROM lessons where unit='$unitID'";
                    if (!($lessonResult = mysql_query($lessonQuery, $database))) 
                    {
                        // Could not retrieve information about the lesson, display error message to the user
                        print( "<p>Could not retrieve lesson Name or Lesson Content</p>" );
                        print( "<p><a href='YourCourses.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }

                    // Iterate through each each lessons in the unit and retrieve the course material
                    // lesson EML and quiz EML
                    if (mysql_num_rows($lessonResult) > 0) {
                        while($lessonRow = mysql_fetch_assoc($lessonResult)) {
                            // Get the lessonID
                            $lessonID = $lessonRow['ID'];
                    
                            // Display the lesson name in as a h2 title
                            print("<h2 class='title'>" . $lessonRow["name"] . "</h2>");

                            // Get and parse the lesson EML and display the HTML to the user
                            $lessonContent = $lessonRow["content"];
                            $lessonContent = lessonEMLParser($lessonContent, $courseID, $database);
                            print($lessonContent);
                        
                            // Every quiz ID matches the same LessonID since every lesson has a quiz, so get the quiz EML
                            // based off of the lessonID
                            $quizQuery = "SELECT content FROM quizzes where ID='$lessonID'";
                            if (!($quizResult = mysql_query($quizQuery, $database))) 
                            {
                                // Could not retrieve information about the quiz, display error message to the user
                                print( "<p>Could not retrieve quiz Content</p>" );
                                print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                                die("</body></html>");
                            }

                            // Iterate through the quiz that's associated with the lesson and display the quiz information
                            if (mysql_num_rows($quizResult) > 0) {
                                // Create a new div based on the lessonID
                                print("<div id='$lessonID'>");
                                // Display the title for the quiz
                                print("<h2 class='title'>" . $lessonRow["name"] . " - Quiz</h1>");
                                
                                // Parse the quiz information and display it to the user
                                while ($quizRow = mysql_fetch_assoc($quizResult)) {
                                    $quizContent = $quizRow["content"];
                                    $quizContent = quizEMLParser($quizContent);
                                    print($quizContent);
                                }

                                // Create a button to submit and mark the quiz
                                print("<input type='button' class='whiteButton' value='Submit Quiz' onclick='MarkQuiz($lessonID)'/>");
                                print("</div>");
                            }
                            else {
                                print("<p>There is No Quiz For this Lesson</p>");
                            }
                            print("<hr />");
                        }
                    }
                }
            }
            mysql_close( $database );
        ?>
        </div>
    </body>
</html>