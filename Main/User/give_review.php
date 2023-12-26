<?php
session_start();
?>
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
    <title>Give Review</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="image/png" sizes="16x16" rel="icon" href="../../Images/logo.PNG" />
    <script src='../../JavaScript/review.js'></script>
</head>
<body>
  <div class="main">
    <div class="row justify-content-center">
      <!-- code to take username -->
          <?php
            if (!isset($_SESSION["user_email"])) {
                echo("<script>window.location='../User/login.php';</script>");
            } else {
                $user_name = $_SESSION["user_name"];
            }
          ?> 
        <!-- code for navbar -->
            <?php
            require_once('../User/user_navbar.html');
            ?>
            <div class="col-lg-8 col-md-5 m-auto "  >
              <h2 class="text-center fs-4 fw-50 my-3" style="font-weight: bolder;">Your Opinion, Our Growth! Review & Elevate the Quizzing Experience
              </h2>
              <form class="bg-light p-3" style="border-radius: 10px;">
                    <div class="mb-3">
                            <label for="suggested_job_profile" class="form-label">Suggest Job Profile</label>
                            <div id="suggested_job_profileContainer">
                                <input type="text" class="form-control suggested_job_profile" name="suggested_job_profile[]">
                            </div>
                            
                    </div> 
                    <button type="button" class="btn btn-outline-primary" id="more_job_profile" name="more_job_profile">Add Job Profile</button>           
                    <div id="emailHelp" class="form-text">To suggest more job profiles click on Add Job Profile button.</div>
                    <div class="mb-3">
                          <label for="reason_for_job_profile" class="form-label">Reason For Job Profile:</label>
                          <textarea class="form-control" aria-label="With textarea" id="reason_for_job_profile" 
                          name="reason_for_job_profile"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="suggestion_for_system" class="form-label">Suggestion for system:</label>
                        <textarea class="form-control" aria-label="With textarea" id="suggestion_for_system" 
                          name="suggestion_for_system"></textarea>
                    </div>
                        <input type="text" class="form-control" id="username" name="username" style="display:none;"
                          value="<?php echo $user_name;?>">
                    <button type="submit" class="btn btn-primary text-center" id="submit">Submit</button>
                </form>
            </div>

  </div>
</body>
</html>