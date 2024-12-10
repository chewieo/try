<!doctype html>
<html lang="en">
<head>
    <title>Login Page</title>
    <meta charset = "utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="container">
        <?php include('header.php'); ?>
        <?php include('navigations/login-nav.php'); ?>
        <div id="registration">
            <div id="reg-form">
            <h2 id="reg-head">Login</h2>
                <form id="reg-form" action="login.php" method="post">
                    <p class="inputs">
                        <label class="label" for="email">Email Address:</label>
                        <input class="textbox" type="password" id="psword" name="psword" size="20" maxlength="40" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>">
                    </p>
                </form>
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                require('mysqli_connect.php');
                echo '<div id="errors">';
                if(!empty($_POST['email'])){
                    $e = mysqli_real_escape_string($dbcon, $_POST['email']);
                }else{
                    echo '<p class="error"> Email cannot be blank</p>';
                    $e = NULL;
                }
                if(!empty($_POST['psword'])){
                    $p = mysqli_real_escape_string($dbcon, $_POST['psword']);

                }else{
                    echo '<p class="error">Password cannot be blank</p>';
                    $p = NULL;
                }
                if ($e  && $p){
                    $hashedPsword = hash('sha256', $p);
                    $q = "SELECT userid, fname, user_lvl FROM users WHERE (email = '$e' AND password = '$hashedPsword')";
                    $result = mysqli_query($dbcon, $q);
                    if (@mysqli_num_rows($result)==1){
                        session_start();
                        $_SESSION = @mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $_SESSION['user_lvl'] = (int) $_SESSION['user_lvl'];
                        $url = ($_SESSION['user_lvl'] === 1) ? 'admin.php' : 'member-homepage.php';
                        header('Location:' .$url);
                        exit();
                        mysqli_free_result($result);
                        mysqli_close($dbcon);
                } else {
                    echo "<p class='error'>User not found, please login first.</p>";
                }
            }
            else {
                echo "<p class='error'>Please try again.</p>";
            }
            echo '</div>';
            mysqli_close($dbcon);
        }
        ?>
    </div>
    <?php include('footer.php'); ?>
    </div>
</body>
</html>