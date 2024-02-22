<?php
        require_once('../connection/connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>View Performance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
    <script src="../../JavaScript/analysis.js"></script>
    <!-- link for chart making -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

</head>
<style>
    #analyseModalLabel pre {
        max-width: 100%;
        overflow: auto;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>
<body>

        <!-- Modal for displaying Performance  -->
                <div class="modal fade text-light" id="analyseModal" tabindex="-1" aria-labelledby="analyseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-dialog-centered  modal-lg">
                    <div class="modal-content" style="background-color: #100a4d;">
                    <div class="modal-header p-5">
                        <h5 class="modal-title text-center" id="analyseModalLabel">Username Your
                             Performance for Job Profile Name is Excellent</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <canvas id="myChart" style="width:100%;max-width:700px"></canvas>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                    </div>
                </div>
                </div>

<div class="col-lg-10 col-md-6  m-auto mt-5">    
            <h3 class="text-center">Performance Panorama: Your Quiz Progress Unveiled</h3>
            <input type="hidden" id="username" value="<?php echo $user_name?>">
                <form class="my-5">
                        <div class="mb-3">
                            <label  class="form-label fw-bold">Select Job Profile Name</label>
                            <select class="form-select" id="job_profile_view_analysis">
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
                            <label  class="form-label fw-bold">Attained Questions </label>
                            <input type="text" class="form-control" id="attained_questions" name="attained_questions" autocomplete="off">
                            
                        </div>
                        <div class="mb-3">
                            <label  class="form-label fw-bold">Acheived Score </label>
                            <input type="text" class="form-control" id="acheived_score" name="acheived_score" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <h5 id="analysis_to_do_data" ></h5>
                        </div>
                        <div class="mb-3">
                           <button class="btn btn-primary"  type="button" id="submit_to_see_performance" 
                           data-toggle="modal" data-target="#analyseModal">Analyse</button>
                        </div>
                    </form>
                    
                    
        </div>
</body>
</html>