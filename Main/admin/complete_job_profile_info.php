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
    <title>Admin Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
    <style>
    /* Additional CSS */
    .rounded:hover {
        transform: translateY(-10px); /* Example of a pop-up effect */
        box-shadow: 0 5px 15px rgba(0, 0, 0.3, 0.3); /* Example of a shadow effect */
        background-color: #073763; /* Example of a color change on hover */
    }
</style>
</head>
<body>
<div class="main">
        <div class="row justify-content-center">
            <?php
            require_once('../admin/admin_navbar.html');
            ?>
            <div class="col-lg-6 col-md-6 mb-5" >
            <img src="../../Images/register.PNG" class="img-fluid" alt="">
            </div>
                <?php
                require_once('../connection/connect.php');
                if (isset($_GET['profile_job'])) {
                $selectedProfileName = $_GET['profile_job'];
                $get_job_profile_info="SELECT * from `job_profile` where job_profile_name='$selectedProfileName'";
                $get_job_tasks_info="SELECT * FROM `job_tasks` where job_profile_name='$selectedProfileName'";
                $get_job_tech_info="SELECT * FROM `job_technologies` where job_profile_name='$selectedProfileName' ";
                $result_of_job_profile_info = mysqli_query($con,$get_job_profile_info);
                $result_of_job_tasks_info=mysqli_query($con,$get_job_tasks_info);
                $result_of_job_tech_info=mysqli_query($con,$get_job_tech_info);

                if(mysqli_num_rows($result_of_job_profile_info)>0 )
                {
                    while($row_of_query = mysqli_fetch_assoc($result_of_job_profile_info))
                    {
                   // echo(mysqli_num_rows($result_of_job_tasks_info));
                        ?>
                        <div class="col-lg-6 col-md-6 mb-5" >
                            <div class="rounded p-3  text-white" style="cursor: pointer; transition: all 0.3s;background-color: #100a4d;">
                                <!-- Your card content -->
                                <h5 class="card-title">Job Profile Name :  <?php echo $row_of_query['job_profile_name']; ?></h5>
                                <p class="card-text">Description:<?php echo $row_of_query['role']; ?></p>
                                <p class="card-text">Last Update Date:<?php echo date("d M Y", strtotime($row_of_query['update_date'])); ?></p>
                                <?php
                            if(mysqli_num_rows($result_of_job_tasks_info)>0 )
                            {
                            while($row_of_tasks = mysqli_fetch_assoc($result_of_job_tasks_info))
                            {    
                                ?>
                                        <p class="card-text">Tasks:<?php echo $row_of_tasks['task']; ?></p>  
                            <?php
                                }
                            }
                            if(mysqli_num_rows($result_of_job_tech_info)>0 )
                            {
                            while($row_of_tech = mysqli_fetch_assoc($result_of_job_tech_info))
                            {    
                                ?>
                                        <p class="card-text">Technologies:<?php echo $row_of_tech['technology']; ?></p>  
                            <?php
                                }
                            }
                ?>
                <?php
                    }
                }
                ?>
                  </div>
                </div>
                <?php
                }
                ?>
   
        </div>
</div>
   

</body>
</html>