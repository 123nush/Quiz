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
        .suggestion {
        height: 300px;
        overflow-y: auto;
    }
    .suggestion::-webkit-scrollbar {
        width: 0; /* Hide scrollbar */
    }
    .reason_for_job_profile{
        height: 300px;
        overflow-y: auto;
    }
    .reason_for_job_profile::-webkit-scrollbar {
        width: 0; /* Hide scrollbar */
    }
    .rounded:hover {
        transform: translateY(-10px); /* Example of a pop-up effect */
        box-shadow: 0 5px 15px rgba(0, 0, 0.3, 0.3); /* Example of a shadow effect */
        /* background-color: #073763; Example of a color change on hover */
    }
    </style>
</head>
<body>
<div class="main">
        <div class="row justify-content-center">
        <?php
        require_once('../admin/reduced_navbar.html');
        ?>
        <?php
        require_once('../connection/connect.php');
        $get_review_info="SELECT * FROM `review` ORDER BY `review_date` DESC LIMIT 10;";
        $result_of_reviews = mysqli_query($con,$get_review_info);
        
        if(mysqli_num_rows($result_of_reviews)>0)
        {
            while($row_of_query = mysqli_fetch_assoc($result_of_reviews))
            {
                $suggestionEmpty = empty($row_of_query['suggestion_for_system']);
                $reasonEmpty = empty($row_of_query['reason_for_job_profile']);
                $height = ($suggestionEmpty && $reasonEmpty) ? '100px' : (($suggestionEmpty || $reasonEmpty) ? '150px' : '200px');
                ?>
                <div class="col-lg-4 col-md-6 mb-5 p-3" >
                    <div class="rounded p-3 text-dark card" style="cursor: pointer; transition: all 0.3s; height: <?php echo $height; ?>">
                        <h5 class="card-title">Job Profile Suggested: <?php echo $row_of_query['suggested_job_profile']; ?></h5>

                        <?php if (!$reasonEmpty) { ?>
                            <div class="reason_for_job_profile" style="height: 200px; overflow-y: auto;">
                                <p class="card-text">Reason: <?php echo $row_of_query['reason_for_job_profile']; ?></p>
                            </div>
                        <?php } ?>

                        <?php if (!$suggestionEmpty) { ?>
                            <div class="suggestion" style="height: 200px; overflow-y: auto;">
                                <p class="card-text">Suggestion: <?php echo $row_of_query['suggestion_for_system']; ?></p>
                            </div>
                        <?php } ?>

                        <p class="card-text">Username: <?php echo $row_of_query['user_name']; ?></p>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>

</body>
</html>