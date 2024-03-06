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
    <title>Registration Page</title>
    <script src="../../JavaScript/register.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link type="image/png" sizes="16x16" rel="icon" href="../../Images/logo.PNG" />
    <link rel="stylesheet" href="../../Css/landing.css">
</head>
<style>
    @media (min-width: 768px) {
  sizing {
    width: 500px; /* Example width */
  /* height: 300px; Example height */
  border: 1px solid #ccc; /* Example border */
  }
}
@media (max-width: 767px) {
  sizing {
    width: 300px; /* Example width */
  /* height: 200px; Example height */
  border: 1px solid #ccc; /* Example border */
  }
}
.oval-button {
    width: 100px; 
    height: 50px; 
    border-radius: 25px; 
    background-color: transparent; 
    color: black; 
    text-align: center; 
    text-decoration: none;
    display: flex; /* Use flexbox */
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    border: 2px solid  #1976d2; 
    cursor: pointer; 
    transition: background-color 0.3s; 
}

.oval-button:hover {
    background-image: linear-gradient(to right, #1976d2, #2196f3); /* Gradient color effect on hover */
}
</style>
<body>
    <!-- <div class="loader-container">
    <?php
    // require_once("../User/loader.html");
    ?>
    </div> -->
    <div id='main' >
    <?php
    require_once('../connection/connect.php');
    ?>
        <div id="video-container">
        <video autoplay loop muted>
            <source src="https://marketplace.canva.com/EAFIGPIs_0g/1/0/450w/canva-blue-abstract-electronic-circuits-instagram-reel-nNFrRp9nxrE.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        </div>
    
             <!-- SUCCESS -->
             <div class="modal fade" id="success" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-centered w-75 mx-auto">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="../../Images/register.PNG" class="img-fluid" alt="">
                        <p class="fs-6 text-center"><strong>Congratulations.</strong> <br/> Your account has been successfully created.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-primary" onclick="location.href='login.php'">Login</button>
                        <!-- onclick="location.href='login.php';" -->
                    </div>
                </div>
            </div>
        </div>
        <!--REG FAILED -->
        <div class="modal fade" id="failed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-centered w-75 mx-auto">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="https://img.freepik.com/premium-vector/website-blocking-icon_1284-66307.jpg?size=626&ext=jpg&ga=GA1.1.1270697051.1699685084&semt=ais" class="img-fluid" alt="">
                        <p class="fs-6 text-center"><strong>Failed to register.</strong> <br/> Try again. </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Try Again</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- Doing changes for adding styling -->
    <!-- <div class="container w-75 mt-5 mb-5 shadow p-3 mb-5 bg-body" style="border-radius: 20px"> -->
    <div class="container sizing  shadow mt-5 mb-5 bg-body" style="border-radius: 20px">

            <div class="row text-dark ">
    <!-- <h4 class="text-center fw-bolder">Create Your Account!!!</h4> -->

                <div class="col-md-5 col-lg-6 mx-auto align-items-center justify-content-center p-3">
                    <form>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" placeholder="eg. nush123" autocomplete="off">
                            <div id="usernameVerify" class="form-text"></div>  
                        </div>
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="full_name" placeholder="eg. Anushka Dalvi" autocomplete="off" required>  
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter Valid Email Address" autocomplete="off">  
                            <div id="emailVerify" class="form-text"></div>
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
                                        <label for="password" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" name="confirm_password" class="form-control"
                                            id="confirm_password" aria-describedby="pass_verify" placeholder="Confirm Password" 
                                            autocomplete="off" required>
                                            <span class="input-group-text confirm_pass_icon" id="basic-addon1">
                                                <i class="bi bi-eye-fill cpass_open_eye"></i>
                                                <i class="bi bi-eye-slash-fill cpass_close_eye"></i>
                                            </span>
                                        </div>
                                        <div id="confirm_password_verify" class="form-text"></div>
                        </div>
                        <button type="submit" class="btn oval-button" id="submit">Submit</button>
                    </form>
                </div>
                <div class="p-4 col-lg-6">
                    <img src="https://img.freepik.com/premium-vector/online-registration-sign-up-with-man-sitting-near-smartphone_268404-95.jpg?w=1480" alt="" class="img-fluid h-auto" />
                    <p class="text-center mt-5">
                        <a href="../User/login.php"  class="link-dark">Already have an account? Sign in</a>
                    </p>
                </div>
        <!-- <p class="text-center mt-5">
                        <a href="login.php"  class="link-dark">Already have an account? Login</a>
                    </p> -->
        </div>
    </div>
</div>
    <!-- <script>
    $(document).ready(function () {
        $("#loader-container").load("../User/loader.html", function () {
                // Once loader.html is loaded, show the main content
                $("#main").fadeIn();
            });
        function animateImage() {
            $('#i1').animate({ marginTop: '50px' }, 1000, function () {
                $('#i1').animate({ marginTop: '0' }, 1000, function () {
                    // Call the function recursively to create a continuous loop
                    animateImage();
                });
            });
        }

        // Start the animation when the window has loaded
        $(window).on('load', function () {
            animateImage();
        });
    });
</script> -->


</body>
</html>
<?php
mysqli_close($con);
?>