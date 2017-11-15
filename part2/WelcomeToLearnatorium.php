<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="SiteMark.js" ></script>
        <script type="text/javascript"></script>
        <title>Welcome To Learnatorium</title>
    </head>
    <body>
        <div class="linksBar">
            <h1 class="banner">Learnatorium</h1>
            <ul>
                <li>
                    <a href="../tma2.htm">Home</a>
                </li>
                <li>
                    <a href="../part1/WelcomeToSiteMark.php">SiteMark</a>
                </li>
                <li>
                    <a href="../part2/WelcomeToLearnatorium.php">Learnatorium</a>
                </li>
            </ul>
        </div>
        <div class="welcomeText">
            <span class="title1">Welcome To Learnatorium</span>
            <span class="title2">Learnatorium is a place for you to quickly learn the basics for a variety of courses!</span>
            <div class="innerDiv" style="width: 225px;">
                <form action="LearnatoriumLogin.php">    
                    <button class="whiteButton floatLeft" style="height: 50px; width: 100px;"type="submit">Login</button>
                </form>
                <form action="LearnatoriumSignup.php">
                    <button class="whiteButton floatRight" style="height: 50px; width: 100px;"type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </body>
</html>