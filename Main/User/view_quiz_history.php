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
    <script src="../../JavaScript/quiz_history.js"></script>
</head>
<body>
    <?php
    require_once("../connection/connect.php");
    ?>
        <div class="col-lg-10 col-md-6  m-auto mt-5">    
            <h3 class="text-center">Explore Your Journey: Revisit Past Quizzes with Ease!</h3>
            <input type="hidden" id="username" value="<?php echo $user_name?>">
                <form class="my-5">
                        <div class="mb-3">
                            <label  class="form-label fw-bold">Select Job Profile Name</label>
                            <select class="form-select" id="job_profile_quiz_view">
                                                    <option selected>Select Job Profile</option>
                                                    <?php
                                                    $get_job = "SELECT distinct job_profile_name FROM `quiz` where user_name='$user_name' ";
                                                    $result = mysqli_query($con,$get_job);
                                                   ?>
                                                   <?php
                                                    if(mysqli_num_rows($result)>0)
                                                    {
                                                        while($row = mysqli_fetch_assoc($result))
                                                        {
                                                            ?>
                                                            <option value="<?php echo($row['job_profile_name']); ?>" >
                                                            <?php echo($row['job_profile_name']); ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label  class="form-label fw-bold">Select date </label>
                            <select class="form-select" name="date_of_quiz" id="date_of_quiz">
                                    <option selected>Select Date</option>
                            </select>
                        </div>
                        <div class="mb-3">
                           <button class="btn btn-primary" id="submit_to_see_preview">Next</button>
                        </div>
                    </form>
        </div>
</body>
<script>
    
</script>
</html>