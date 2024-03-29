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
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <!-- link for image that should be shown on address bar -->
    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
    <link rel="stylesheet" href="../../Css/landing.css">
    <script src="https://smtpjs.com/v3/smtp.js"></script>
</head>
<body>
    <!-- <div class="loader-container">
    <?php
   
     //require_once("../User/loader.html");
    ?>
    </div> -->
    
    <div id='main'>
    <?php
     require_once("../connection/connect.php");
    ?>
        <div id="video-container">
        <video autoplay loop muted>
            <source src="../../Images/Products and Services Promotion Instagram Story Video in Violet Cyan Gradient Tech Style.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        </div>
    
            
        <!-- FAILED -->
        <div class="modal fade" id="failed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-centered w-75 mx-auto">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="https://img.freepik.com/free-vector/401-error-unauthorized-concept-illustration_114360-5531.jpg?w=1060&t=st=1683877856~exp=1683878456~hmac=dc95863d337270b3f7d86dfae1957dcbffa77e5ca417f4dbc27522cd8a3f7a04" class="img-fluid" alt="">
                        <p class="fs-6 text-center"><strong>Login Failed</strong> <br/> Incorrect Username or Password </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Try Again</button>
                    </div>
                </div>
            </div>
        </div>
    
    <div class="container w-50 mt-5 mb-5 shadowmb-5 bg-body" style="border-radius: 20px">
    <!-- <h4 class="text-center fw-bolder">Login To System!!!</h4> -->
            <div class="row text-dark ">
            <div class=" col-md-5 col-lg-6 mx-auto" style="background-color:#1a75ff;">
                <!-- <img src="https://1.bp.blogspot.com/-aGY128_uhLA/YOiVbVdX-DI/AAAAAAAAAFI/wqvpHrmEgK86934cxNkOS9jbDFwh9rkTQCLcBGAsYHQ/s720/bigstock-Man-Having-an-Online-Registrat-73738582-720x537.jpg"
                alt="Registraion Image" class="img-fluid h-auto" > -->
                <!-- <img src="../../Images/register.PNG"
                alt="Registraion Image" class="img-fluid h-auto"  id="i1"> -->
                <h3 class="p-3 text-center fw-bolder mt-5 text-light">Welcome Back!</h3>
                <h5 class="p-3 text-center fw-bolder mt-3 text-light"> Discover your tech strengths and weaknesses with our quiz
</h5>
                <p class="text-center mt-3 text-light">
                
                        <!-- Enter your personal details and start your journey with us -->
                        <a href="register.php"  class="text-light m-2 p-3" >Don't have an account?<br><br>
                            <button class="btn btn-light">Register</button> </a>
                </p>
                
            </div>
                <div class="col-md-5 col-lg-6 p-3 mb-5 mt-5 mx-auto align-items-center justify-content-center">
                <form >
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" autocomplete="off">
                        <div id="usernameVerify" class="form-text"></div>  
                    </div>             
                        <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="password" 
                                        aria-describedby="pass_verify" placeholder="Password" required autocomplete="off">
                                        <span class="input-group-text pass_icon" id="basic-addon1">
                                            <i class="bi bi-eye-fill pass_open_eye"></i>
                                            <i class="bi bi-eye-slash-fill pass_close_eye"></i>
                                        </span>
                                    </div>
                                    <div id="pass_verify" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                       <a href="../User/forgot.php" >Forgot password</a>

                    </div>  
                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                </form>
            </div>
            <!-- <div class="p-3 col-md-4 col-lg-5 mx-auto"> -->
                <!-- <img src="https://1.bp.blogspot.com/-aGY128_uhLA/YOiVbVdX-DI/AAAAAAAAAFI/wqvpHrmEgK86934cxNkOS9jbDFwh9rkTQCLcBGAsYHQ/s720/bigstock-Man-Having-an-Online-Registrat-73738582-720x537.jpg"
                alt="Registraion Image" class="img-fluid h-auto" > -->
                <!-- <img src="../../Images/register.PNG"
                alt="Registraion Image" class="img-fluid h-auto"  id="i1"> -->
                
            <!-- </div> -->
        <!-- <p class="text-center mt-5"> -->
                        <!-- <a href="register.php"  class="link-dark">Don't have an account? Register</a> -->
                    <!-- </p> -->
        </div>
    </div>
</div>
</body>
<script>
    function sendemail(){
    Email.send({
    Host : "smtp.elasticemail.com",
    Username : "dalvianushka999@gmail.com",
    Password : "4DBA9547DE4797862A68118EF305B0452740",
    To : 'anushkadal1611@gmail.com',
    From : "dalvianushka999@gmail.com",
    Subject : "This is the subject",
    Body : "And this is the body"
}).then(
  message => alert(message)
);
}
// sendemail();
$(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault(); // Prevent default form submission
            sendemail(); // Call the sendemail() function to send the email
        });
    });
</script>
</html>
<?php
mysqli_close($con);
?>