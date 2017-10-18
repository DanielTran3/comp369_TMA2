<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type="text/css" href="../shared/tma2_stylesheet.css" />
        <body>
            <?php
                define("ONE_HOUR", 60 * 60 * 1);      
                setcookie('user', '', time() - ONE_HOUR);
                setcookie('pass', '', time() - ONE_HOUR);
                
                // if (isset($_COOKIE['user'])) {
                //     unset($_COOKIE['user']);
                //     setcookie('user', '', time() - ONE_HOUR, '/');
                // }
                // if (isset($_COOKIE['pass'])) {
                //     unset($_COOKIE['pass']);
                //     setcookie('pass', '', time() - ONE_HOUR, '/');
                // }
                // echo $_COOKIE['user'];
                // echo $_COOKIE['pass'];
            ?>
            <form method="post" action="WelcomeToSiteMark.php">
                <div class="welcomeText">
                    <h1 class="title1 titleFont">You've Been Logged Out!</h1>

                    <span class="title4">Click the button below to return to the Welcome Page.</span>
                    <button class="whiteButton" type="submit">Continue</button>
                </div>
            </form>
        </body>
    </head>
</html>