<?php
session_start();
if(!isset($_SESSION["user_email"]) )
{
  // var_dump($_SESSION);
  // echo("<script>window.location='../User/login.php';</script>");
}
else{
  $user_name=$_SESSION["user_name"];
  $user_email = $_SESSION["user_email"];
  $full_name = $_SESSION["user_full_name"];
  $user_type = $_SESSION["user_type"];
}
?>