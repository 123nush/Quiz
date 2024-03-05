<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Forgot Password</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
    <link rel="stylesheet" href="../../Css/landing.css">
    <script src="https://smtpjs.com/v3/smtp.js"></script>

    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
  <script src="../../JavaScript/forgot.js"></script>
    <title>Forgot Password</title>
    <style>
        #first, #second, #third, #fourth{
            width:25%;
    height:60px;
    text-align: center;
        }
    </style>
   
</head>
<body>
<?php
    require "../connection/connect.php";
    // require_once("../loader.html");
    ?>

    <main id="main">
         <!-- SUCCESS -->
         <div class="modal fade" id="success" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-centered w-75 mx-auto">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="" class="img-fluid" alt="">
                        <p class="fs-6 text-center"><strong>Congratulations.</strong> <br/> Password Reset successfully.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-primary" onclick="location.href='login.php'">Login</button>
                        <!-- onclick="location.href='login.php';" -->
                    </div>
                </div>
            </div>
        </div>
        <!-- FAILED -->
        <div class="modal fade" id="failed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-centered w-75 mx-auto">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="https://img.freepik.com/free-vector/401-error-unauthorized-concept-illustration_114360-5531.jpg?w=1060&t=st=1683877856~exp=1683878456~hmac=dc95863d337270b3f7d86dfae1957dcbffa77e5ca417f4dbc27522cd8a3f7a04" class="img-fluid" alt="">
                        <p class="fs-6 text-center"><strong>Login Failed</strong> <br/> Incorrect  Password </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Try Again</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container mt-5 mb-5 shadow p-3  bg-body" style="border-radius: 20px;width:90%;">
            <div class="row p-3">
                <div class="p-1 col-lg-6">
                    <form  method="POST">
                    <div id="section1">
                        <div class="col-lg-12 mt-5">
                            <p class="h1">Forgot password?</p>
                        </div>
                        <div class="col-lg-12">
                            <p class="h5">No worries we will send a otp to your account</p>
                        </div>
                        <!-- email template division -->
                        <div id="emailTemp" >

                        </div>
                        <div class="mb-3 pt-3 col-lg-12">
                            <label for="username" class="form-label">Username </label>
                            <input type="text" name="username" class="form-control" id="username" autocomplete="off" aria-describedby="usernameVerify" placeholder="e.g.123nush" required />
                        
                        </div>
                        <div class="mb-3  col-lg-12">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" autocomplete="off" aria-describedby="emailVerify" placeholder="Enter email which is registered" required />
                            <div id="verify" class="form-text"></div>
                        </div>
                        <button type="button"  name="CrossCheckUser" id="CrossCheckUser" class="btn btn-primary px-5 py-2 mt-3 w-100">
                           Check
                        </button>  
                        <button type="button"  name="sendotp" id="sendotp" class="btn btn-primary px-5 py-2 mt-3 w-100">
                           Click to get otp
                        </button>                        
                        <p class="mt-3 text-center">
                            <a href="login.php" class="link-dark text-decoration-none"><i class="bi bi-arrow-left"></i>  &nbsp Back to Sign in</a>
                        </p>
                    </div>
                    <div id="section2">
                        <div class="col-lg-12 mt-5">
                            <p class="h1">Verify OTP</p>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <p  class="text-wrap" style="word-wrap: break-word;">Enter OTP sent to your gmail<span class="fw-bold" id="emailInfo"></span></p>
                        </div>
                            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"> 
                                <input pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==1) return false;" name="first" class="m-2 text-center form-control rounded" type="text" id="first" autocomplete="off"> 
                                <input pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==1) return false;" name="second" class="m-2 text-center form-control rounded" type="text" id="second" autocomplete="off"> 
                                <input pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==1) return false;" name="third" class="m-2 text-center form-control rounded" type="text" id="third" autocomplete="off"> 
                                <input pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==1) return false;" name="fourth" class="m-2 text-center form-control rounded" type="text" id="fourth" autocomplete="off"> 
                            </div> 
                            <div id="invalidOtp" class="form-text"></div>
                        <button type="button" name="verifyOtp" id="verifyOtp"  class="btn btn-primary px-5 py-2 mt-5 w-100">
                            Verify 
                        </button>
                    </div>
                    <div id="section3">
                        <div class="col-lg-12 mt-5">
                            <p class="h1">Set new password</p>
                        </div>
                        <div class="col-lg-12 mb-5">
                            <p class="fw-3">Password Must be of at least 8 characters and  should contain one upper case character and number</p>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="password" autocomplete="off" aria-describedby="pass_verify" placeholder="Password">
                                <span class="input-group-text pass_icon" id="basic-addon1">
                                    <i class="bi bi-eye-fill pass_open_eye"></i>
                                    <i class="bi bi-eye-slash-fill pass_close_eye"></i>
                                </span>
                            </div>
                            <div id="pass_verify" class="form-text"></div>
                        </div> 
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" autocomplete="off" aria-describedby="cpass_verify" placeholder="Password" >
                                <span class="input-group-text confirm_pass_icon" id="basic-addon1">
                                    <i class="bi bi-eye-fill cpass_open_eye"></i>
                                    <i class="bi bi-eye-slash-fill cpass_close_eye"></i>
                                </span>
                            </div>
                            <div id="confirm_password_verify" class="form-text"></div>
                        </div> 
                        <button type="button" name="resetpassword" id="resetpassword" class="btn btn-primary px-5 py-2 mt-5 w-100">
                            Reset password
                        </button>
                        </div>
                       
                    </form>
                </div>
                <div class="p-4 col-lg-6 mt-1">
                    <img src="https://img.freepik.com/free-vector/two-factor-authentication-concept-illustration_114360-5488.jpg?size=626&ext=jpg&ga=GA1.1.1270697051.1699685084&semt=ais" alt="" class="img-fluid h-100 w-100" />
                </div>
            </div>
        </div>
    </main>
    
</body>
</html>