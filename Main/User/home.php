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
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="image/png" sizes="16x16" rel="icon" href="../../Images/logo.PNG" />

  <style>
.image-container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.moving-image {
  animation: moveLeft 2s linear forwards;
  position: absolute;
  left: -100%; 
  transition: left 2s; 
}
@keyframes moveLeft {
  0% {
    left: -100%;
  }
  100% {
    left: 50%;
    transform: translateX(-50%);
  }
}
/* for adjusting image width */
@media (min-width: 768px) {
  img {
    width: 50%; 
    height: auto; 
  }
}

@media (max-width: 767px) {
  img {
    width: 80%; 
    height: auto;
  }
}

  </style>
</head>
<body>
  <div class="" style=" background: linear-gradient(to bottom,#1a1aff, #ff6699);height:100vh">
        <?php
       
           require("../log_session/session.php");
            require_once('../User/user_navbar.html');
            ?>
        <div class="row">
          <div style="text-align:center" class="col-md-6 col-lg-12 ">
          <h2 class="fs-2 fw-bolder cssanimation sequence leFadeIn text-light">HELLO  <?php echo($user_name); ?>  DISCOVER YOUR IT SKILL LEVEL</h2>
          </div>
          <div class="image-container moving-image col-md-6 col-lg-12 mt-5">
            <img src="http://s3.amazonaws.com/digitaltrends-uploads-prod/2015/06/Acer-S277HK-4K-monitor-hero-v2.jpg" 
            alt="Your Image" style="height:60vh;width:1000px">
          </div>
        </div>
  </div>
</body>
</html>
