<?php
        require_once('../connection/connect.php');

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
    <title>Admin Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
    <script src='../../JavaScript/job_profile.js'></script>
    <script src='../../JavaScript/question.js'></script>

    <style>
    /* Additional CSS */
    .job_role {
        height: 300px;
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
</style>
</head>
<body>
    <!-- modal to select difficulty level -->
<div class="modal fade" id="difficulty_level_selection_modal_to_view_questions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <button type="button" class="btn btn-outline-primary w-25" id="difficulty_level_selected" name="difficulty_level_selected">Next</button>
            </div>
            </div>
        </div>
    </div>
        <!-- modal to add new job profie information -->
<div class="modal fade text-light" id="new_job_profile_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-centered w-75 mx-auto">
                <div class="modal-content" style="background-color: #100a4d;">
                    <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="mb-3">
                            <label  class="form-label">Job Profile Name</label>
                            <input type="text" class="form-control" id="job_profile_name" required >
                            <div id="job_profile_nameVerify" class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label  class="form-label">Role</label>
                            <textarea class="form-control auto-resize" id="job_profile_role" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="job_profile_pic" class="form-label">Job Profile Photo</label>
                            <input type="file" class="form-control" id="job_profile_pic" required >
                            <small class="text-light">Add  picture with job profile name eg. data_analyst.png</small><br>
                        </div>

                        <div class="mb-3">
                            <label  class="form-label">Tasks </label>
                            <div id="tasksContainer">
                                <input type="text" class="form-control tasks" name="tasks[]">
                            </div>
                        </div>
                        <small class="text-danger">If want to delete task just remove all text from textbox</small><br>
                        <button type="button" class="btn btn-outline-primary text-light" id="more_task" name="more_task">Add Task</button>

                        <div class="mb-3">
                            <label class="form-label">Skills required  </label>
                            <div id="technologiesContainer">
                                <input type="text" class="form-control technologies" name="technologies[]">
                            </div>
                        </div> 
                        <small class="text-danger">If want to delete skill just remove all text from textbox</small><br>
                        <button type="button" class="btn btn-outline-primary text-light" id="more_tech" name="more_tech">Add skill</button>
                    </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-primary text-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button"  class="btn btn-outline-primary text-light" id="submit_info" name="submit_info">Add Info</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to delete job profile information -->
        <div class="modal fade text-light" id="delete_job_profile_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" style="background-color: #100a4d;">
                    <div class="modal-body">
                        <h6 class="font-weight-bold">Are You Sure? You Want To Delete this</h6>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-primary w-25" data-bs-dismiss="modal">NO</button>
                        <button type="button" class="btn btn-outline-primary w-25" id="yes_delete_job_profile">YES</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal to update job profile information -->
        <div class="modal fade text-light" id="update_job_profile_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content" style="background-color: #100a4d;">
                    <div class="modal-body">
                        <form enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="update_job_profile_name" class="form-label">Doing Update For:<h5 id="show_job_update"></h5>
                            </label>
                            <input type="text" style="display:none;" class="form-control" id="update_job_profile_name" required  readonly>
                        </div>
                        <div class="mb-3">
                            <label for="update_job_profile_role" class="form-label">Role</label>
                            <textarea class="form-control auto-resize" id="update_job_profile_role" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label  class="form-label">Job Profile Photo</label>
                            <input type="file" class="form-control" id="update_job_profile_pic" required >
                            <input type="hidden" class="form-control" id="update_job_profile_pic_name">
                            <small class="text-light">Add  picture with job profile name eg. data_analyst.png</small><br>
                        </div>
                        <div class="mb-3">
                            <label  class="form-label">Tasks </label>
                            <div id="updatetasksContainer">
                                <input type="text" class="form-control updatetasks" name="updatetasks[]">
                            </div>
                        </div>
                        <small class="text-danger">If want to delete task just remove all text from textbox</small><br>
                        <button type="button" class="btn btn-outline-primary text-light" id="update_more_task" name="update_more_task">Add Task</button>

                        <div class="mb-3">
                            <label class="form-label">Skills </label>
                            <div id="updatetechnologiesContainer">
                                <input type="text" class="form-control updatetechnologies" name="updatetechnologies[]">
                            </div>
                        </div> 
                        <small class="text-danger">If want to delete technology just remove all text from textbox</small><br>
                        <button type="button" class="btn btn-outline-primary text-light" id="update_more_tech" name="update_more_tech">Add Skill</button>
                    </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-primary text-light w-25" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-outline-primary text-light w-25" id="update_job_profile">Modify</button>
                    </div>
                </div>
            </div>
        </div>
        
    <!-- //modal to add question -->
    <div class="modal fade text-light" id="new_question_modal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-centered w-75 mx-auto">
                <div class="modal-content" style="background-color: #100a4d;">
                    <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label  class="form-label">Select Job Profile Name</label>
                            <select class="form-select" id="job_profile_question">
                                                    <option selected>Select Job Profile</option>
                                                    <?php
                                                    $get_job = "SELECT * FROM `job_profile` ";
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
                            <label for="difficulty_level_for_question" class="form-label">Select Difficulty level</label>
                            <select class="form-select" name="difficulty_level_for_question" id="difficulty_level_for_question">
                                    <option selected>Select Difficulty Level</option>
                                    
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category/Skill</label>
                            <select type="text" class="form-select" name="category" id="category" >
                                <option selected>Select Category</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" class="form-control" id="question" required >
                            <div id="questionVerify" class="form-text"></div>  
                        </div>
                        
                        <div class="mb-3">
                            <label for="option1" class="form-label">Option 1</label>
                            <input type="text" class="form-control" id="option1" required >
                        </div>
                        <div class="mb-3">
                            <label for="option2" class="form-label">Option 2</label>
                            <input type="text" class="form-control" id="option2" required >
                        </div>
                        <div class="mb-3">
                            <label for="option3" class="form-label">Option 3</label>
                            <input type="text" class="form-control" id="option3" required >
                        </div>
                        <div class="mb-3">
                            <label for="option4" class="form-label">Option 4</label>
                            <input type="text" class="form-control" id="option4" required >
                        </div>
                        <div class="mb-3">
                            <label for="option4" class="form-label">Correct Answer Option</label>
                            <br>
                            <!-- <input type="text" class="form-control" id="answer_option" required > -->
                                <input class="form-check-input" type="radio"  name="answer_option" value="option_1">
                                <label class="form-check-label text-light" for="option_1">option 1</label>
                                <input class="form-check-input" type="radio"  name="answer_option" value="option_2">
                                <label class="form-check-label text-light" for="option_2">Option 2</label>
                                <input class="form-check-input" type="radio"  name="answer_option" value="option_3">
                                <label class="form-check-label text-light" for="option_3">Option 3</label>
                                <input class="form-check-input" type="radio"  name="answer_option" value="option_4">
                                <label class="form-check-label text-light" for="option_4">Option 4</label>
                        </div>
                        <div class="mb-3">
                            <label for="answer_description" class="form-label">Correct Answer Description</label>
                            <textarea class="form-control auto-resize" id="answer_description" required></textarea>
                        </div>
                    </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn  btn-outline-primary text-light " data-bs-dismiss="modal">Cancel</button>
                        <button type="button"  class="btn btn-outline-primary text-light " id="submit_question" name="submit_question">Add Question</button>
                        
                    </div>
                </div>
            </div>
        </div>




        <!-- Main content -->
    <div class="main">
        <div class="row justify-content-center">
        <?php
        require_once('../admin/admin_navbar.html');
        ?>
        <?php
        require_once('../connection/connect.php');
        date_default_timezone_set("Asia/Calcutta");
        $today_date = date("Y-m-d");
        $get_job_profile_info="SELECT * from `job_profile`";
        $result_of_job_profile_info = mysqli_query($con,$get_job_profile_info);
        $jobs=[];
        $job_pics=[];
        if(mysqli_num_rows($result_of_job_profile_info)>0)
        {
            while($row_of_query = mysqli_fetch_assoc($result_of_job_profile_info))
            {
                $profile_job=$row_of_query['job_profile_name'];
                $jobs[]=$row_of_query['job_profile_name'].trim(' ');
                $job_pics[]=$row_of_query['job_pic'].trim(' ');
                ?>
                    <div class=" job-profile-container col-lg-4 col-md-6 mb-5 p-3" >
                    <div class="rounded p-3  text-dark card" style="cursor: pointer; transition: all 0.3s;height: 400px;">
                       
                        <div class="job-heading rounded d-flex justify-content-center align-items-center" >
                            <h5 class="card-title my-5 text-center" >
                                <?php echo $row_of_query['job_profile_name']; ?>
                            </h5>
                            <img src="" alt="" style="height: 100px;width: 100px;" class="job-profile-image">
                        </div>
                        <div class="job_role" style="height: 200px; overflow-y: auto;">
                            <p class="card-text"><span style="font-weight:bolder;font-size:large">Role:  </span><?php echo $row_of_query['role']; ?></p>
                        </div>
                        <p class="card-text"><span style="font-weight:bolder;font-size:large">Last Update Date:</span><?php echo date("d M Y", strtotime($row_of_query['update_date'])); ?></p>
                        <form style="display: none;">
                            <input type="text" class="text-white bg-dark profile_name"  id="profile_name" name="profile_name" value="<?php echo $row_of_query['job_profile_name']; ?>">
                        </form>
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-lg-6  d-flex justify-content-between">
                                <a href="complete_job_profile_info.php?profile_job=<?php echo $profile_job?>" ><button type="button" class="btn rounded btn-info text-dark mx-2"   id="view_more_info<?php echo $row_of_query['job_profile_name']; ?>" 
                                name="view_more_info" >More Info</button></a>
                                <button type="button"  class="btn rounded btn-info text-dark mx-2" id="update_job_profile_info<?php echo $row_of_query['job_profile_name']; ?>" name="update_job_profile_info" >Update Info</button>
                            </div>
                            <div class="col-md-6 col-lg-6  d-flex justify-content-between mt-md-0 mt-3">
                                <button type="button" class="btn rounded btn-info text-dark mx-2 delete-job-profile" data-profile-id="<?php echo $row_of_query['job_profile_name']; ?>" data-bs-toggle="modal" data-bs-target="#delete_job_profile_modal">Delete Info</button>
                        
                                <button type="button"  class="btn rounded btn-info text-dark mx-2" id="view_questions<?php echo $row_of_query['job_profile_name']; ?>" 
                                data-bs-toggle="modal" data-bs-target="#difficulty_level_selection_modal_to_view_questions" name="view_questions">
                                View Questions
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
    //code for random colors
    const colors = ["#ffcc00", "#66cccc", "#ff8533"];
    const shuffledColors = shuffleArray(colors);

    const jobHeadings = document.querySelectorAll(".job-heading");
    jobHeadings.forEach(function(element, index) {
        const colorIndex = index % shuffledColors.length;
        element.style.backgroundColor = shuffledColors[colorIndex];
    });
    //code for job profile wise images
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