<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma3_stylesheet.css" />
        <body>
            <?php
                $currentLesson = 0;
                foreach ($_POST['unit'] as $unit) {
                    print("<p>" . $unit . "</p>");
                }
                
                print("<hr />");

                foreach ($_POST['numLessons'] as $number) {
                    print("<p>" . $number . " | </p>");
                }

                print("<hr />");
                
                foreach ($_POST['lesson'] as $lesson) {
                    print("<p>" . $lesson . " | </p>");
                }

                print("<hr />");
                
                foreach ($_POST['lessonEML'] as $eml) {
                    print("<p>" . $eml . " | </p>");
                }
                
                print("<hr />");
                
                foreach ($_POST['quizEML'] as $quiz) {
                    print("<p>" . $quiz . " | </p>");
                }

                print("<hr />");
                print("<p>Number of Units: " . sizeof($_POST['unit']) . "</p>");
                print("<hr />");

                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // open Products database
                if (!mysql_select_db( "learnatorium", $database)) {
                    die("Could not open learnatorium database </body></html>");
                }

                $course = $_POST['courseNameName'];
                print("<p>Course: " . $course . "</p>");
                $query = "INSERT INTO courses (name) VALUES ('$course')";
                if (!($result = mysql_query($query, $database))) 
                {
                    print( "<p>Could not add Course</p>" );
                    print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                    die("</body></html>");
                }

                $query = "SELECT ID FROM courses WHERE name='$course'";
                if (!($result = mysql_query($query, $database))) 
                {
                    print( "<p>Could not retrieve Course ID</p>" );
                    print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                    die("</body></html>");
                }

                $courseID = mysql_fetch_assoc($result)["ID"];

                print("<p>Course ID: " . $courseID . "</p>");

                for ($unitIndex = 0; $unitIndex < sizeOf($_POST['unit']); $unitIndex++) {
                    $unit = $_POST['unit'][$unitIndex];

                    $query = "INSERT INTO units (course, name) VALUES ('$courseID', '$unit')";
                    if (!($result = mysql_query($query, $database))) 
                    {
                        print( "<p>Could not add Unit: " . $unit . " in Course ID: " . $courseID . "</p>" );
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }

                    $query = "SELECT ID FROM units WHERE name='$unit'";
                    if (!($result = mysql_query($query, $database))) 
                    {
                        print( "<p>Could not retrieve Unit ID</p>" );
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }

                    $unitID = mysql_fetch_assoc($result)["ID"];
                    print("<p>Unit ID: " . $unitID . "</p>");


                    $numberOfLessons = $_POST['numLessons'][$unitIndex];
                    print("<p>Number of Children Lessons: " . $unitID . "</p>");
                    
                    for ($lessonIndex = 0; $lessonIndex < $numberOfLessons; $lessonIndex++) {
                        $lesson = $_POST['lesson'][$currentLesson];
                        $lessonEML = $_POST['lessonEML'][$currentLesson];
                        $quizEML = $_POST['quizEML'][$currentLesson];

                        $query = "INSERT INTO lessons (unit, name, content) VALUES ('$unitID', '$lesson', '$lessonEML')";
                        if (!($result = mysql_query($query, $database))) 
                        {
                            print( "<p>Could not add Lesson: " . $lesson . "</p>" );
                            print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                            die("</body></html>");
                        }

                        $query = "SELECT ID FROM lessons WHERE name='$lesson'";
                        if (!($result = mysql_query($query, $database))) 
                        {
                            print( "<p>Could not retrieve Lesson ID</p>" );
                            print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                            die("</body></html>");
                        }

                        $lessonID = mysql_fetch_assoc($result)["ID"];
                        print("<p>Lesson ID: " . $lessonID . "</p>");

                        $query = "INSERT INTO quizzes (lesson, content) VALUES ('$lessonID', '$quizEML')";
                        if (!($result = mysql_query($query, $database))) 
                        {
                            print( "<p>Could not add Quiz to Lesson ID: " . $lessonID . "</p>" );
                            print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                            die("</body></html>");
                        }
                        $currentLesson++;
                    }
                }

                // query Products database
                
                mysql_close( $database );
            ?>
        </body>
    </head>
</html>