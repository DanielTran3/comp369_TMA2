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
        <div id="mainDiv">
            <h1 class="title1">Create A Course</h1>
            <form id="addBookmarkForm" method="post" action="UploadCourse.php">    
                <div id="courseDiv" class="innerDiv">
                    <span>Course Name: </span>
                    <input id="courseNameInput" name="courseNameName" type="text" class="largeInputBox"></input>        
                    <button type="button" id="addUnitButton" class="whiteButton" Value="AddUnit">Add Unit</button>
                    <button type="submit" id="createCourseButton" class="whiteButton" Value="CreateCourse">Create Course</button>                
                </div>
            </form>
        </div>
    </body>
</html>