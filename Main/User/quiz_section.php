<?php
        require_once('../connection/connect.php');
?>
<!DOCTYPE html>
<html>
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
    <title>User Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="image/png" sizes="16x16" rel="icon" href="../../Images/logo.PNG" />
    <script src='../../JavaScript/job_profile.js'></script>
    <!-- link for text animation -->
  <link href="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/cssanimation.min.css" rel="stylesheet">
  <script src="../../JavaScript/animation.js"></script>
  <script src="../../JavaScript/quiz_time.js"></script>

</head>
<style>
    .job_role {
        height: 150px;
        overflow-y: auto;
    }
    .job_role::-webkit-scrollbar {
        width: 0; /* Hide scrollbar */
    }
    .rounded:hover {
        transform: translateY(-10px); /* Example of a pop-up effect */
        box-shadow: 0 5px 15px rgba(0, 0, 0.3, 0.3); /* Example of a shadow effect */
        /* background-color: #073763; Example of a color change on hover */
    }
    /* .float_nav{
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000; 
    }
    .main-content {
    margin-top: 60px;
    } */
</style>
<body>
    <!-- modal to select difficulty level -->
    <div class="modal fade" id="difficulty_level_selection_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="background-color: #100a4d;">
            <div class="modal-body">
            <form>
                <label class="form-check-label text-light" >Select Difficulty Level</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="easy" name="options" value="easy">
                    <label class="form-check-label text-light" for="easy">Easy</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" id="medium" name="options" value="medium">
                    <label class="form-check-label text-light" for="medium">Medium</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" id="hard" name="options" value="hard">
                    <label class="form-check-label text-light" for="hard">Hard</label>
                </div>
            </form>
            </div>
            <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-primary w-25" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-outline-primary w-25" id="show_rules_of_quiz" name="show_rules_of_quiz">Next</button>
            </div>
            </div>
        </div>
    </div>

    <div class="main ">
        <div class="row justify-content-center">
            <div class="float_nav">
            <?php
            require_once('../User/user_navbar.html');
            ?>
            </div>
            <div class="main-content">
                <h2 style="color:#100a4d;text-align:center" class="cssanimation sequence leFadeIn infinite mb-3 fw-bolder fs-3">
                EXPERIENCE IT</h2>
            </div>
            <?php
            require_once('../connection/connect.php');
            date_default_timezone_set("Asia/Calcutta");
            $today_date = date("Y-m-d");
            $get_job_profile_info="SELECT * from `job_profile`";
            $result_of_job_profile_info = mysqli_query($con,$get_job_profile_info);
            if(mysqli_num_rows($result_of_job_profile_info)>0)
            $jobs=[];
            $job_pics=[];
            {
                while($row_of_query = mysqli_fetch_assoc($result_of_job_profile_info))
                {
                    $profile_job=$row_of_query['job_profile_name'];
                    $jobs[]=$row_of_query['job_profile_name'].trim(' ');
                    $job_pics[]=$row_of_query['job_pic'].trim(' ');
                    ?>
                        <div class=" job-profile-container col-lg-4 col-md-6 mb-5 p-3" >

                        <div class="rounded p-3  text-dark card" style="cursor: pointer; transition: all 0.3s;height: 330px;">
                            <!-- Your card content -->
                            <div class="job-heading rounded d-flex justify-content-center align-items-center" >
                                <h5 class="card-title my-5 text-center" >
                                    <?php echo $row_of_query['job_profile_name']; ?>
                                </h5>
                                <img src="" alt="" style="height: 100px;width: 100px;" class="job-profile-image">
                            </div>

                            <div class="job_role" style="height: 100px; overflow-y: auto;">
                                <p class="card-text"><span style="font-weight:bolder;font-size:large">Role:</span><?php echo $row_of_query['role']; ?></p>
                            </div>
                            <form style="display: none;">
                                <input type="text" class="text-dark bg-dark profile_name"  name="profile_name" value="<?php echo $row_of_query['job_profile_name']; ?>">
                            </form>
                            <input type="text" id="getting_job_profile" style="display: none;">
                            <input type="text" id="getting_difficulty_level" style="display: none;">
                            <div class="row justify-content-center" style="padding-bottom: 1px;">
                                <div class="col-md-6 col-lg-6  d-flex justify-content-between">
                                </div>          
                                <div class="col-md-6 col-lg-6  d-flex justify-content-between" >
                                    <a href="participant_side_complete_job_profile_info.php?profile_job=<?php echo $profile_job?>" ><button type="button" 
                                    class="btn rounded btn-info text-dark mx-2 " 
                                    name="view_more_info" >More Info</button></a>
                                    <button type="button" class="btn rounded btn-info text-dark mx-2" data-bs-toggle="modal" 
                                    data-bs-target="#difficulty_level_selection_modal" id="take_a_quiz<?php echo $row_of_query['job_profile_name']; ?>" name="take_a_quiz">Take A Quiz
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
    </div>

</body>
<script>
    $('document').ready(function(){
        function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }
    const colors = ["#ffcc00", "#66cccc", "#ff8533"];
    const shuffledColors = shuffleArray(colors);

    const jobHeadings = document.querySelectorAll(".job-heading");
    jobHeadings.forEach(function(element, index) {
        const colorIndex = index % shuffledColors.length;
        element.style.backgroundColor = shuffledColors[colorIndex];
    });

    const jobProfileImages = {
        "Cybersecurity Analyst":"cybersecurity analyst.png",
        "Android Developer":"android developer.png",
        "Artificial Intelligence (AI) Engineer":"artificial intelligence (AI) engineer.png",
        "Cloud Architect":"cloud architect.png",
        "Data Analyst": "data analyst.png",
        "Database Administrator":"database administrator.png",
        "DevOps Engineer":"devops engineer.png",
        "Full Stack Developer":"full stack developer.png",
        "IoT Specialist":"iot specialist.png",
        "Software Engineer":"software engineer.png",
        // "UI Designer":"ui designer.png",
        // Add mappings for other job profiles here...
    };
    const jobProfiles = <?php echo json_encode($jobs); ?>;
    const jobPics=<?php echo json_encode($job_pics);?>;
document.querySelectorAll('.job-profile-container').forEach((container, index) => {
    const job = jobProfiles[index].trim(' ');
   // const imageFilename = jobProfileImages[job];
    // container.querySelector('.card-title').textContent = job;
    container.querySelector('.job-profile-image').src = jobPics[index];
});
 })
</script>
</html>