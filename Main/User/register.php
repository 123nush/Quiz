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
    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
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
                        <img src="https://img.freepik.com/free-vector/confirmed-concept-illustration_114360-545.jpg?w=1060&t=st=1683867581~exp=1683868181~hmac=1e7364b0ade26d1472f5c388369363e9158af74c9e3784a415576453158c7a65" class="img-fluid" alt="">
                        <p class="fs-6 text-center"><strong>Congratulations.</strong> <br/> Your account has been successfully created.</p>
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
                        <img src="https://img.freepik.com/free-vector/removing-goods-from-basket-refusing-purchase-changing-decision-item-deletion-emptying-trash-online-shopping-app-laptop-user-cartoon-character-vector-isolated-concept-metaphor-illustration_335657-2843.jpg?w=1060&t=st=1683869448~exp=1683870048~hmac=351919e98226dbde35a446a66fcd783e63766b69193d06232b36da08b0ca3b2c" class="img-fluid" alt="">
                        <p class="fs-6 text-center"><strong>Failed to register.</strong> <br/> Try again. </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Try Again</button>
                    </div>
                </div>
            </div>
        </div>
    
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
                
                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                </form>
            </div>
            <div class=" col-md-5 col-lg-6 mx-auto" style="background-color:#1a75ff;">
                <!-- <img src="https://1.bp.blogspot.com/-aGY128_uhLA/YOiVbVdX-DI/AAAAAAAAAFI/wqvpHrmEgK86934cxNkOS9jbDFwh9rkTQCLcBGAsYHQ/s720/bigstock-Man-Having-an-Online-Registrat-73738582-720x537.jpg"
                alt="Registraion Image" class="img-fluid h-auto" > -->
                <!-- <img src="../../Images/register.PNG"
                alt="Registraion Image" class="img-fluid h-auto"  id="i1"> -->
                <h3 class="p-3 text-center fw-bolder mt-5 text-light">Hello, Friend!</h3>
                <h5 class="p-3 text-center fw-bolder mt-5 text-light">Enter your personal details and start your journey with us</h5>
                <p class="text-center mt-5 text-light">
                
                        <!-- Enter your personal details and start your journey with us -->
                        <a href="login.php"  class="text-light p-3">Already have an account?<br><br>
                            <button class="btn btn-light">Login</button> </a>
                </p>
                
            </div>
        <!-- <p class="text-center mt-5">
                        <a href="login.php"  class="link-dark">Already have an account? Login</a>
                    </p> -->
        </div>
    </div>
</div>
    <script>
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
</script>


</body>
</html>
<?php
mysqli_close($con);
?>