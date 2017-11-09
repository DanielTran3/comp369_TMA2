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
        <div id="mainDiv">
            <h1 class="title1">Create A Course</h1>
            <form id="addBookmarkForm" method="post" action="UploadCourse.php">    
                <div id="courseDiv" class="innerDiv">
                    <span>Course Name: </span>
                    <input id="courseNameInput" name="courseNameName" type="text" class="largeInputBox"></input>        
                    <button type="button" id="addUnitButton" class="whiteButton" Value="AddUnit">Add Unit</button>
                    <button type="submit" id="createCourseButton" class="whiteButton" Value="CreateCourse">Create Course</button>                
                    <input id="uploadFile" name="fileToUpload" type="file" multiple></input>        
                </div>
            </form>
        </div>
    </body>
</html>