<?php
    require "header.php";
?>

    <main>
        <h1>Signup</h1> 
        <?php
            if(isset($_GET['error'])) {
                if($_GET['error'] == "emptyfields") {
                    echo '<p>Fill in all fields!</p>';
                }
                else if($_GET['error'] == "invalidmailandusername") {
                    echo '<p>Invalid Username and E-mail!</p>';
                }
                else if($_GET['error'] == "invalidusername") {
                    echo '<p>Invalid Username!</p>';
                }
                else if($_GET['error'] == "invalidmail") {
                    echo '<p>Invalid E-mail!</p>';
                }
                else if($_GET['error'] == "passwordcheck") {
                    echo '<p>Your Passwords do not match!</p>';
                }
                else if($_GET['error'] == "usertaken") {
                    echo '<p>Username is already taken!</p>';
                }
            }
            else if(isset($_GET['signup'])) {
                if($_GET['signup'] == "success") {
                    echo '<p>Signup successful!</p>';
                }
            }
        ?>
        <form action="includes/signup.inc.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="mail" placeholder="E-Mail">
            <input type="password" name="pwd" placeholder="Password">
            <input type="password" name="pwd-repeat" placeholder="Repeat Password">
            <button type="submit" name="signup-submit">Signup</button>
        </form>
    </main>
