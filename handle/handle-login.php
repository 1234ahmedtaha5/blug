<?php require "../inc/connection.php"?>
<?php

if (isset($_POST['submit'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $error = [];
    if (empty($email)) {
        $error[] = "email is empty";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "email is not valid";
    }

    if (empty($password)) {
        $error[] = "password is required";
    } elseif (strlen($password) < 5) {
        $error[] = "password must be more than 5 chars";
    }

    if (empty($error)) {
        $query = "select * from users where `email`='$email'";
        $result=mysqli_query($conn,$query);
        if (mysqli_num_rows($result) == 1) {
            $users = mysqli_fetch_assoc($result);
            $adminpassword=$users['password'];
            $is_valid=password_verify($password,$adminpassword);

            if($is_valid){
                $_SESSION["user_id"]=$users["id"];
                $_SESSION["success"]="welcome back";
                header("location:../index.php");

            }else{
                $_SESSION['error'] = ["credentials not correct...."];
                header("location:../login.php");
            }

        }else{
            $_SESSION['error'] = ["this account not found"];
            header("location:../login.php");
        }
    } else {
        $_SESSION['error'] = $error;
        $_SESSION['email'] = $email;
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}
