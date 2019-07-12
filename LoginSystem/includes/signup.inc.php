<?php

    if(isset($_POST['signup-submit'])) {

        require 'db.inc.php';

        $username = $_POST['username'];
        $email = $_POST['mail'];
        $password = $_POST['pwd'];
        $passwordRepeat = $_POST['pwd-repeat'];

        if(empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
            header("Location: ../signup.php?error=emptyfields&username=".$username."&mail=".$email);
            exit();
        }

        else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ../signup.php?error=invalidmailandusername");
            exit();
        }

        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../signup.php?error=invalidmail&username=".$username);
            exit();
        }

        else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ../signup.php?error=invalidusername&mail=".$email);
            exit();
        }

        else if($password !== $passwordRepeat) {
            header("Location: ../signup.php?error=passwordcheck&username=".$username."&mail=".$email);
            exit();
        }

        else {
            $sql = "SELECT username FROM users WHERE username=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../signup.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if($resultCheck > 0) {
                    header("Location: ../signup.php?error=usertaken&mail=".$email);
                    exit();
                }
                else {

                    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../signup.php?error=sqlerror");
                        exit();
                    }
                    else {
                        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../signup.php?signup=success");
                        exit();
                    }
                }
            }    
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("Location: ../signup.php");
        exit();  
    }
?>