<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="SiteMark.js" ></script>
        <script type="text/javascript">
            window.onload = function () {
                pageStartup();
            }
        </script>
        <title>SiteMark Login</title>
    </head>
    <body>
        <?php
            // Check for valid user login, if there is one, redirect the user to the main page
            if (isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
                header("Location:SiteMark.php");
            }
        ?>
        <div class="linksBar">
            <h1 class="banner">SiteMark</h1>
            <!-- Print the user's name along with a link to log out -->
            <ul>
                <li>
                    <a href="../tma2.htm">Home</a>
                </li>
                <li>
                    <a href="../part1/WelcomeToSiteMark.html">SiteMark</a>
                </li>
                <li>
                    <a href="WelcomeToLearnatorium.php">Available Courses</a>
                </li>
            </ul>
        </div>
        <!-- If there is no currently logged in user, display the login page, allowing for a user 
             to enter their credentials to login-->
        <form method="post" action="login.php">
            <div class="containerDiv">
                <h1 class="title1 loginTitle">SiteMark Login</h1>
                <div class="innerDiv" style="margin-top: 50px;">
                    <label class="floatLeftLabel">Username</label>
                    <input type="text" name="loginUsername" class="floatRight largeInputBox"></input>
                </div>
                <div class="innerDiv">
                    <label class="floatLeftLabel">Password</label>
                    <input type="password" name="loginPassword" class="floatRight largeInputBox"></input>
                </div>
                <div class="innerDiv">
                    <button type="submit" class="whiteButton">Login</input>
                </div>
            </div>
        </form>
    </body>
</html>