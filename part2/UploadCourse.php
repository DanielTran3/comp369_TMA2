<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma3_stylesheet.css" />
        <body>
            <?php
                // The current lesson that is being uploaded to the server
                $currentLesson = 0;

                if (!isset($_POST['unit']) || !isset($_POST['lesson']) || 
                    !isset($_POST['lessonEML']) || !isset($_POST['quizEML'])) {
                        print("<p>Please include at least one unit and lesson/quiz");
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                }

                if (empty($_POST['courseNameName'])) {
                    print("<p>Please include a name for the course");
                    print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                    die("</body></html>");
                }

                foreach ($_POST['unit'] as $postedUnit) {
                    if (empty($postedUnit)) {
                        print("<p>Please include a name for all units");
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }
                }

                foreach ($_POST['lesson'] as $postedUnit) {
                    if (empty($postedUnit)) {
                        print("<p>Please include a name for all lessons");
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }
                }
                
                // Connect to MySQL
                if (!($database = mysql_connect("localhost", "iw3htp", "password"))) {
                    die("Could not connect to database </body></html>");
                }

                // Open Learnatorium database
                if (!mysql_select_db( "learnatorium", $database)) {
                    die("Could not open learnatorium database </body></html>");
                }

                // Get the name of the course
                $course = $_POST['courseNameName'];

                // Create a query to inser the course into the database
                $query = "INSERT INTO courses (name) VALUES ('$course')";
                if (!($result = mysql_query($query, $database))) 
                {
                    // Could not add the course, display the error message to the user
                    print( "<p>Could not add Course</p>" );
                    print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                    die("</body></html>");
                }

                // Get the auto incremented ID of the most recently inserted course
                $courseID = mysql_insert_id($database);

                // Iterate through each unit that is created
                for ($unitIndex = 0; $unitIndex < sizeOf($_POST['unit']); $unitIndex++) {
                    $unit = $_POST['unit'][$unitIndex];

                    // Insert the unit into the units database
                    $query = "INSERT INTO units (course, name) VALUES ('$courseID', '$unit')";
                    if (!($result = mysql_query($query, $database))) 
                    {
                        // Could not add the unit, display the error message to the user
                        print( "<p>Could not add Unit: " . $unit . " in Course ID: " . $courseID . "</p>" );
                        print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                        die("</body></html>");
                    }

                    // Get the auto incremented ID of the most recently inserted unit
                    $unitID = mysql_insert_id($database);

                    // Iterate through each lesson that is created
                    $numberOfLessons = $_POST['numLessons'][$unitIndex];
                    for ($lessonIndex = 0; $lessonIndex < $numberOfLessons; $lessonIndex++) {
                        // Get the lesson name, lesson EML, and quiz EML
                        $lesson = $_POST['lesson'][$currentLesson];
                        $lessonEML = $_POST['lessonEML'][$currentLesson];
                        $quizEML = $_POST['quizEML'][$currentLesson];

                        // Create an insert query to insert the lesson into the lessons table
                        $query = "INSERT INTO lessons (unit, name, content) VALUES ('$unitID', '$lesson', '$lessonEML')";
                        if (!($result = mysql_query($query, $database))) 
                        {
                            // Could not add the lesson, display the error message to the user
                            print( "<p>Could not add Lesson: " . $lesson . "</p>" );
                            print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                            die("</body></html>");
                        }

                        // Get the auto incremented ID of the most recently inserted lesson
                        $lessonID = mysql_insert_id($database);

                        // Insert the quiz into the quizzes table
                        $query = "INSERT INTO quizzes (lesson, content) VALUES ('$lessonID', '$quizEML')";
                        if (!($result = mysql_query($query, $database))) 
                        {
                            // Could not add the quiz, display the error message to the user
                            print( "<p>Could not add Quiz to Lesson ID: " . $lessonID . "</p>" );
                            print( "<p><a href='CreateCourseContent.php'>Click Here</a> to continue.</p>" );
                            die("</body></html>");
                        }
                        // Move to the next lesson
                        $currentLesson++;
                    }
                }

                // If there are learning objects available
                if (!empty($_FILES['learningObjects'])) {
                    // Get the number of learning objects
                    $numObjects = count($_FILES['learningObjects']['name']);
                    // Create a specific directory for the course in the uploads folder on the server. Directory is 
                    // composed of the course name and ID
                    $directory = "./uploads/" . $course . $courseID;
                    // If the directory doesn't exist, then make one
                    if (!file_exists($directory)) {
                        mkdir($directory);
                    }
                    $path = $directory . "/";
                    
                    // Iterate through each of the learningObjects
                    for ($i = 0; $i < $numObjects; $i++) {
                        // Check if the learningObject is set and not empty
                        if (isset($_FILES['learningObjects']['name'][$i]) && !empty($_FILES['learningObjects']['name'][$i])) {
                            // Get the name of the learningObject and the tmp name
                            $learningObjectName = $_FILES['learningObjects']['name'][$i];
                            $learningObjectTmpName = $_FILES['learningObjects']['tmp_name'][$i];

                            // Get the position of the last period, denoting the beginning of the file type
                            $dotPosition = strrpos($learningObjectName, ".");
                            // Get the file type (ignoring the period)
                            $learningObjectType = substr($learningObjectName, $dotPosition + 1);

                            $lessonFileLocation = $path.$learningObjectName;
                            // Movve the file to the correct location (uploads folder + course name + course ID)
                            if (move_uploaded_file($learningObjectTmpName, $lessonFileLocation)) {
                                // Create a query to insert the learningObject into the learningObjects table with the objects type and name. 
                                // If there is a duplicate, then update the table's columns with the new data
                                $query = "INSERT INTO learningObjects (course, type, filename, location)" . 
                                         "VALUES ('$courseID', '$learningObjectType', '$learningObjectName', '$lessonFileLocation') " . 
                                         "ON DUPLICATE KEY UPDATE type='$learningObjectType', filename='$learningObjectName', location='$lessonFileLocation'";

                                // Execute the to insert the learning object into the table
                                if (!($result = mysql_query( $query, $database))) 
                                {
                                    // If the select query failed, notify the user
                                    print( "<p>Failed to add Learning Object</p>" );
                                    print("<form method='post' action='Learnatorium.php'>");
                                    print("<button class='whiteButton' type='submit' style='margin-top:0px;'>Continue</button>");
                                    print("</form>");
                                    die( mysql_error() . "</body></html>" );
                                }
                            }
                        }
                    }
                }
                mysql_close( $database );
            ?>
            <form method="post" action="AvailableCourses.php">
                <div class="welcomeText">
                    <span class="title1 titleFont">The course has been successfully created!</span>
                    <span class="title4">Click the button below to continue</span>
                    <button class="whiteButton" type="submit">Continue</button>
                </div>
            </form>
        </body>
    </head>
</html>