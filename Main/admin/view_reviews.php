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
    <link type="image/png" sizes="16x16" rel="icon" href="../../Images/logo.PNG" />
    <script src='../../JavaScript/review.js'></script>
    <style>
        .job_profile {
        height: 300px;
        overflow-y: auto;
    }
    .job_profile::-webkit-scrollbar {
        width: 0; /* Hide scrollbar */
    }
    </style>
</head>
<body>
<div class="main">
        <div class="row justify-content-center">
        <?php
        require_once('../admin/admin_navbar.html');
        ?>
        <?php
        require_once('../connection/connect.php');
        $get_review_info="SELECT * FROM `review` ORDER BY `timestamp` DESC LIMIT 10;";
        $result_of_reviews = mysqli_query($con,$get_review_info);
        if(mysqli_num_rows($result_of_reviews)>0)
        {
            while($row_of_query = mysqli_fetch_assoc($result_of_reviews))
            {
                ?>
                <div class="col-lg-4 col-md-6 mb-5" >
                    <div class="rounded p-3  text-white card" style="cursor: pointer; transition: all 0.3s;background-color: #100a4d;height: 300px;">
                        <!-- Your card content -->
                        <h5 class="card-title">Job Profile Suggested:  <?php echo $row_of_query['job_profile_name']; ?></h5>
                        <div class="job_profile" style="height: 200px; overflow-y: auto;">
                            <p class="card-text">Role:<?php echo $row_of_query['role']; ?></p>
                        </div>
                        <p class="card-text">Last Update Date:<?php echo date("d M Y", strtotime($row_of_query['update_date'])); ?></p>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>

</body>
</html>