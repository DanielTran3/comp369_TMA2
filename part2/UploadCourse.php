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

                $courseID = mysql_insert_id($database);

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

                    $unitID = mysql_insert_id($database);
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

                if (!empty($_FILES['lessonObjects'])) {
                    $numObjects = count($_FILES['lessonObjects']['name']);
                    $directory = "./uploads/" . $course . $courseID;
                    if (!file_exists($directory)) {
                        mkdir($directory);
                    }
                    $path = $directory . "/";
                    for ($i = 0; $i < $numObjects; $i++) {
                        if (isset($_FILES['lessonObjects']['name'][$i]) && !empty($_FILES['lessonObjects']['name'][$i])) {
                            $lessonObjectName = $_FILES['lessonObjects']['name'][$i];
                            $lessonObjectTmpName = $_FILES['lessonObjects']['tmp_name'][$i];
                            $dotPosition = strrpos($lessonObjectName, ".");
                            $lessonObjectType = substr($lessonObjectName, $dotPosition + 1);
                            if (move_uploaded_file($lessonObjectTmpName, $path.$lessonObjectName)) {
                                // Create a query to the users table to get the admin status of the currently
                                // logged in user
                                echo("<p>Name: " . $lessonObjectName . "</p>");
                                $query = "INSERT INTO lessonObjects (course, type, filename) VALUES ('$courseID', '$lessonObjectType','$lessonObjectName') " . 
                                         "ON DUPLICATE KEY UPDATE type='$lessonObjectType', filename='$lessonObjectName'";

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
                                echo 'Uploaded!';
                            }
                            else {
                                echo("Move object failed");
                            }
                        }
                        else {
                            echo("Object not set");            
                        }
                    }
                }
                else {
                    echo("Lesson Objects Empty");
                }

                // query Products database
                
                mysql_close( $database );
            ?>
        </body>
    </head>
</html>