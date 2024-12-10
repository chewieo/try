<!doctype html>
<html lang="en">
<head>
    <title>Website ni Salapantan</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="constant">
        <?php include('header.php'); ?>
        <?php include('nav.php'); ?>
        <?php include('info-col.php'); ?>
        <div id='content'>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $errors = array();

                if (empty($_POST['fname'])) {
                    $errors[] = "Please input your first name.";
                } else {
                    $fn = trim($_POST['fname']);
                }

                if (empty($_POST['lname'])) {
                    $errors[] = "Please input your last name.";
                } else {
                    $ln = trim($_POST['lname']);
                }

                if (empty($_POST['email'])) {
                    $errors[] = "Please input your email.";
                } else {
                    $e = trim($_POST['email']);
                }

                if (!empty($_POST['psword1'])) {
                    if ($_POST['psword1'] != $_POST['psword2']) {
                        $errors[] = "Passwords do not match.";
                    } else {
                        $p = trim($_POST['psword1']);
                    }
                } else {
                    $errors[] = "Please input your password.";
                }

                // All fields are successful
                if (empty($errors)) {
                    require('mysqli_connect.php');

                    // Prepare the statement
                    $stmt = mysqli_prepare($dbcon, "INSERT INTO users (fname, lname, email, psword, registration_date) VALUES (?, ?, ?, ?, NOW())");

                    if ($stmt) {
                        // Hash the password
                        $hashed_password = password_hash($p, PASSWORD_DEFAULT);

                        // Bind the parameters
                        mysqli_stmt_bind_param($stmt, 'ssss', $fn, $ln, $e, $hashed_password);

                        // Execute the statement
                        $result = mysqli_stmt_execute($stmt);

                        if ($result) { // If successful
                            header("Location: register-success.php");
                            exit();
                        } else { // If not successful
                            echo '<h2>System Error</h2>
                                  <p class="error">Your registration failed due to an unexpected error. Sorry for the inconvenience.</p>';
                            echo '<p>' . mysqli_error($dbcon) . '</p>';
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        echo '<h2>System Error</h2>
                              <p class="error">Unable to prepare the database statement.</p>';
                    }

                    // Close the database connection
                    mysqli_close($dbcon);
                    include('footer.php');
                    exit();

                } else { // Errors occurred
                    echo '<h2>Error!</h2>
                          <p class="error">The following error(s) occurred:</p>';
                    foreach ($errors as $msg) {
                        echo " - $msg<br/>\n";
                    }
                    echo '</p><h3>Please try again.</h3><br/><br/>';
                }
            }
            ?>
            <h2>Registration Page</h2>
            <form action="register.php" method="post">
                <p>
                    <label class="class" for="fname">First Name: </label>
                    <input type="text" id="fname" name="fname" size="30" maxlength="40"
                           value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>">
                </p>

                <p>
                    <label class="class" for="lname">Last Name: </label>
                    <input type="text" id="lname" name="lname" size="30" maxlength="40"
                           value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>">
                </p>

                <p>
                    <label class="class" for="email">Email Address: </label>
                    <input type="text" id="email" name="email" size="30" maxlength="50"
                           value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                </p>

                <p>
                    <label class="class" for="psword1">Password: </label>
                    <input type="password" id="psword1" name="psword1" size="20" maxlength="50">
                </p>

                <p>
                    <label class="class" for="psword2">Repeat Password: </label>
                    <input type="password" id="psword2" name="psword2" size="20" maxlength="50">
                </p>

                <p>
                    <input type="submit" id="submit" name="submit" value="Register">
                </p>
            </form>
        </div>
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
