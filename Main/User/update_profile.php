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
    <link type="image/png" sizes="16x16" rel="icon" href="../../Images/logo.PNG" />
    <link rel="stylesheet" href="../../Css/participant_profile.css">
    <script src="../../JavaScript/update_user_profile.js"></script>
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
</head>
<body>
                          <?php
                            require_once('../connection/connect.php');
                            $get_user_info="SELECT * from `user` where user_name='$user_name' ";
                            $result_of_user_info=mysqli_query($con,$get_user_info);
                            $query_to_find_total_given_quiz="SELECT COUNT(quiz_id) FROM `quiz` WHERE user_name='$user_name'";
                            $result_of_given_quiz=mysqli_query($con,$query_to_find_total_given_quiz);
                            $query_to_find_max_quiz_on_job_profile="SELECT job_profile_name, COUNT(*) AS quiz_count
                             FROM quiz GROUP BY job_profile_name ORDER BY quiz_count DESC LIMIT 1";
                            $result_for_max_quiz=mysqli_query($con,$query_to_find_max_quiz_on_job_profile);
                            if(mysqli_num_rows($result_of_user_info)>0){
                                $row=mysqli_fetch_assoc($result_of_user_info);
                                $total=mysqli_fetch_assoc($result_of_given_quiz);
                                $t=$total['COUNT(quiz_id)'];
                                $row_of_job_profile=mysqli_fetch_assoc($result_for_max_quiz);
                                $job_profile=$row_of_job_profile['job_profile_name'];
                            }
                            ?>
      <div class='text-center my-4'>
          <h2 class="fw-20 fs-3" style="font-weight: bolder;"> Hello <?php echo $row['user_name'] ?></h2>
      </div>
                                <div class="col-lg-10 col-md-6 text-center m-auto">
                                    <form>
                                    <table class="table">
                                    <tbody>
                                        <tr >
                                            <th scope="col">Name:</th>
                                            <td scope="col" class="split-column">
                                                <div class="d-flex justify-content-center">
                                                    <input type="hidden" id="username" name="username" value="<?php echo $row['user_name'] ?>">
                                                    <input type="text" class="form-control w-75 text-center"  id="update_full_name" name="update_full_name" value="<?php echo $row['name']?>" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr >
                                            <th scope="col">Registered Email:</th>
                                            <td scope="col" class="split-column">
                                                <div class="d-flex justify-content-center">
                                                    <input type="text" class="form-control w-75 text-center" id="update_email" name="update_email" value="<?php echo $row['email']?>" >
                                                </div>
                                                <div id="emailVerify" class="form-text"></div>
                                            </td>
                                        </tr>
                                        <tr >
                                            <th scope="col">Password:</th>
                                            <td scope="col" class="split-column">
                                                <div class="d-flex justify-content-center">
                                                    <input type="password" name="update_password" class="form-control w-75 text-center" id="update_password" 
                                                    aria-describedby="pass_verify" placeholder="Password" 
                                                    value="<?php echo $row['pwd']?>" required autocomplete="off">
                                                    <span class="input-group-text pass_icon" id="basic-addon1">
                                                        <i class="bi bi-eye-fill pass_open_eye"></i>
                                                        <i class="bi bi-eye-slash-fill pass_close_eye"></i>
                                                    </span>
                                                </div>
                                                <div id="pass_verify" class="form-text"></div>
                                            </td>
                                        </tr >
                                        
                                    </tbody>
                                    </table>
                                    <button class="btn btn-primary d-flex justify-content-center m-auto" id="submit">Update</button>
                                    </form>
                                </div>
</body>
</html>