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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>View Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
    <!-- <script src='../../JavaScript/update_user_profile.js'></script> -->
    <!-- <script src='../../JavaScript/update_user_profile.js'></script> -->
    <script>
        $('document').ready(function(){
            $('.pass_open_eye').hide();
            $('.cpass_open_eye').hide();
            $('.pass_icon').on('click',function(){
        if('password' == $('#update_password').attr('type')){
            $('#update_password').prop('type', 'text');
            $('.pass_open_eye').show();
            $('.pass_close_eye').hide();
       }else{
            $('#update_password').prop('type', 'password');
            $('.pass_open_eye').hide();
            $('.pass_close_eye').show();
       }
    })
        })
         
    </script>
    <link rel="stylesheet" href="../../Css/participant_profile.css">
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
            <div class="col-md-10 col-lg-10 mx-auto">
                <div class="row mt-3" >
                    <!-- left side navbar -->
                    <div class="col-lg-3 col-md-3 d-md-block  m-auto text-center my-5 h-auto" >
                        <div class='card card-left' >
                            <div class="class-body mt-2 bg-light">
                                <div class="person-shape">
                                    <div class="circle-profile">
                                        <a class="nav-link" href="participant_profile.php" tabindex="-1" aria-disabled="true">PROFILE</a>
                                    </div>
                                    <div class="upper-body">
                                        <ul class="nav flex-column">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" href="participant_profile.php?update_profile" tabindex="-1" aria-disabled="true">UPDATE PROFILE</a>
                                            </li> 
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" href="participant_profile.php?view_quiz_history" tabindex="-1" aria-disabled="true">VIEW QUIZ HISTORY</a>
                                            </li> 
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" href="participant_profile.php?view_analysis" tabindex="-1" aria-disabled="true">VIEW ANALYSIS</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- right side division -->
                    <div class="col-lg-9 col-md-7">
                        <div class="card">
                            <div class="card-header border-bottom mb-3 justify-content-center align-items-center">
                                <?php
                                if(isset($_GET['view_profile'])){
                                    include('./participant_profile.php');
                                }
                                else if(isset($_GET['update_profile'])){
                                    include('./update_profile.php');
                                }
                                else if(isset($_GET['view_quiz_history'])){
                                    include('./view_quiz_history.php');
                                }
                                else if(isset($_GET['view_analysis'])){
                                    include('./view_analysis.php');
                                }
                                else{
                            include '../connection/connect.php';
                            $get_user_info="SELECT * from `user` where user_name='$user_name' ";
                            $result_of_user_info=mysqli_query($con,$get_user_info);
                            $query_to_find_total_given_quiz="SELECT COUNT(quiz_id) FROM `quiz` WHERE user_name='$user_name'";
                            $result_of_given_quiz=mysqli_query($con,$query_to_find_total_given_quiz);
                            $query_to_find_max_quiz_on_job_profile="SELECT job_profile_name, COUNT(*) AS quiz_count
                            FROM quiz where quiz.user_name='$user_name' GROUP BY job_profile_name ORDER BY quiz_count DESC LIMIT 1";
                            $result_for_max_quiz=mysqli_query($con,$query_to_find_max_quiz_on_job_profile);
                            if(mysqli_num_rows($result_of_user_info)>0){
                                $row=mysqli_fetch_assoc($result_of_user_info);
                                $total=mysqli_fetch_assoc($result_of_given_quiz);
                                $t=$total['COUNT(quiz_id)'];
                                if(mysqli_num_rows($result_for_max_quiz)){
                                    $row_of_job_profile=mysqli_fetch_assoc($result_for_max_quiz);
                                    $job_profile=$row_of_job_profile['job_profile_name'];
                                }
                                else{
                                    $job_profile="No Quiz Perform";
                                }
                               
                              ?>
                                <div class='text-center my-4'>
                                   <h2 class="fw-20 fs-3" style="font-weight: bolder;"> Hello <?php echo $row['user_name'] ?></h2>
                                </div>
                                <div class="col-lg-10 col-md-6 text-center m-auto">
                                    <table class="table table-hover ">
                                    <tbody>
                                        <tr >
                                            <th scope="col">Name:</th>
                                            <td scope="col" class="split-column"><?php echo $row['name']?></td>
                                        </tr>
                                        <tr >
                                            <th scope="col">Registered Email:</th>
                                            <td scope="col" class="split-column"><?php echo $row['email']?></td>
                                        </tr>
                                        <tr >
                                            <th scope="col">Password:</th>
                                            <td scope="col" class="split-column">
                                                <div class="d-flex justify-content-center">
                                                    <input type="password" name="update_password" class="form-control w-75 text-center" id="update_password" 
                                                    aria-describedby="pass_verify" placeholder="Password" 
                                                    value="<?php echo $row['pwd']?>" required autocomplete="off" readonly>
                                                    <span class="input-group-text pass_icon" id="basic-addon1">
                                                        <i class="bi bi-eye-fill pass_open_eye"></i>
                                                        <i class="bi bi-eye-slash-fill pass_close_eye"></i>
                                                    </span>
                                                </div>
                                                <div id="pass_verify" class="form-text"></div>
                                            </td>
                                        </tr >
                                        <tr>
                                            <th scope="col">Total attained quiz:</th>
                                            <td scope="col" class="split-column"><?php echo $t?></td>
                                        </tr>
                                        <tr >
                                            <th scope="col">Maximum quiz given on:</th>
                                            <td scope="col" class="split-column"><?php echo $job_profile?></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                              <?php
                            }
                          }
                            ?>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var navLinks = document.querySelectorAll('.nav-item a');
navLinks.forEach(function(link) {
    link.addEventListener('click', function() {
        // Remove 'active' class from all links
        navLinks.forEach(function(item) {
            item.classList.remove('active');
        });
        // Add 'active' class to the clicked link
        link.classList.add('active');
    });
});
</script>
</body>
</html>