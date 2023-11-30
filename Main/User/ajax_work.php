<?php
require "../connection/connect.php";
//code to insert registered data
if (!empty($_POST['full_name']) &&
    !empty($_POST['email']) &&
    !empty($_POST['username']) &&
    !empty($_POST['password'])
) {
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $insert_user_info = "INSERT INTO `USER` (user_name,name,email,pwd,user_type) VALUES ('$username','$full_name','$email','$password','o') ";
    if (mysqli_query($con, $insert_user_info)) {
        //echo ("Response  :"."1"."New: ");
        echo(mysqli_query($con, $insert_user_info));
        // $result=mysqli_query($con, $insert_user_info);
        // $row=mysqli_num_rows($result);
       // echo(mysqli_query($con, $insert_user_info));
        // echo '<script>';
        // echo 'console.log("1")';
        // echo '</script>';

    }
    else
    // if(mysqli_error($con))
    {
        echo ("2");
       echo ("Error description: " . mysqli_error($con));
    }
}
//code to see whether email is already refisterde or not
if(!empty($_POST['sign_up_email']))
{
    $email = $_POST['sign_up_email'];
    $query_to_search_email = "SELECT * FROM `user` WHERE email= '$email'";
    if(mysqli_num_rows(mysqli_query($con,$query_to_search_email))>0)
    {
        echo("1");
    }else{
        echo("2");
    }
}
//code to see wheather username alredy exists or not
if(!empty($_POST['username']))
{
    $username = $_POST['username'];
    $query_to_search_username = "SELECT * FROM `user` WHERE user_name= '$username'";
    if(mysqli_num_rows(mysqli_query($con,$query_to_search_username))>0)
    {
        echo("1");
        //echo("You are there");
        // echo("  u:".$username);
        // echo'<script>';
        // echo 'console.log("1")';
        // echo '</script>';
        // console.log('1');
    }else{
        echo("2");
    }
}
//code for login
if (!empty($_POST['username_login']) &&
    !empty($_POST['password_login'])
) {

    $username = mysqli_real_escape_string($con, $_POST["username_login"]);
    $password = mysqli_real_escape_string($con, $_POST["password_login"]);
    $user_info_query = "SELECT * FROM `user` WHERE user_name = '$username' AND  pwd = '$password' ";
    $result_of_user_info = mysqli_query($con, $user_info_query);
    if (mysqli_num_rows($result_of_user_info) == 1) {
        while ($row = mysqli_fetch_assoc($result_of_user_info)) {
            $user_name = $row["user_name"];
            $full_name = $row["name"];
            $user_type = $row["user_type"];
            if ($user_type == "o") {
                echo ("1");
            } elseif($user_type == "a") {
                echo ("2");
            }
            session_start();
            $_SESSION["user_name"] = $user_name;
            $_SESSION["full_name"] = $full_name;
            $_SESSION["user_type"] = $user_type;
        }
    } else {
        echo ("no");
    }
}
//code to see whether username and email both matches with each other when user clicks forgot passsword
if(!empty($_POST['forgot_password_email']) && !empty($_POST['forgot_password_username']))
{
    $email = mysqli_real_escape_string($con, $_POST['forgot_password_email']);
    $username= mysqli_real_escape_string($con, $_POST['forgot_password_username']);
    $verify_user = "SELECT * from `user` where user_name='$username' and email='$email' ";
    if(mysqli_query($con,$verify_user))
    {
        $result=mysqli_query($con,$verify_user);
        if(mysqli_num_rows($result)>0){
            echo("1");
        }
        else{
            echo("2");
            echo ('mysqli error:'.mysqli_error($con));
        }
        //echo(mysqli_query($con,$verify_user));
    }
}
// else{
//     echo("Invalid data");
// }
//code to reset password
if(!empty($_POST['reset_password'])&& !empty($_POST['user_name']) ){
    $username = mysqli_real_escape_string($con, $_POST['user_name']);
    $password = mysqli_real_escape_string($con, $_POST['reset_password']);
    $change_user_password = "UPDATE `USER` SET `pwd` = '$password' WHERE `USER`.`user_name` = '$username' ";
    if(mysqli_query($con,$change_user_password))
    {
        echo('Password Reset');
       // echo("Hello");
        // if(mysqli_num_rows($result)==1){
            //echo("1");
        // }
    }
    else{
        echo("2");
    }
}
?>