<!DOCTYPE html>
<?php
        require_once('../connection/connect.php');
?>
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
    <script src='../../JavaScript/question.js'></script>

    <style>
    /* Additional CSS */
    .ans_description {
        height: 150px;
        overflow-y: auto;
    }

    .ans_description::-webkit-scrollbar {
        width: 0; /* Hide scrollbar */
    }
    .options {
        height: 150px;
        overflow-y: auto;
        scrollbar-width: none;
        scrollbar-color: transparent transparent;
    }
    .options::-webkit-scrollbar {
    width: 0;
    }
    .rounded:hover {
        transform: translateY(-10px); /* Example of a pop-up effect */
        box-shadow: 0 5px 15px rgba(0, 0, 0.3, 0.3); /* Example of a shadow effect */
        /* background-color: #073763; Example of a color change on hover */
    }
</style>
</head>
<body>
    <!-- Modal to delete question and answer information -->
    <div class="modal fade text-light" id="delete_question_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" style="background-color: #100a4d;">
                    <div class="modal-body">
                        <h6 class="font-weight-bold">Are You Sure? You Want To Delete this</h6>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-primary w-25" data-bs-dismiss="modal">NO</button>
                        <button type="button" class="btn btn-outline-primary w-25" id="yes_delete_quetion">YES</button>
                    </div>
                </div>
            </div>
    </div>

<!-- modal to update question -->
    <div class="modal fade text-light" id="update_question_modal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-centered w-75 mx-auto">
                <div class="modal-content" style="background-color: #100a4d;">
                    <div class="modal-body">
                    <form>
                        <div class="mb-3" style="display: none;">
                            <label for="question_id" class="form-label">Question ID</label>
                            <input type="text" class="form-control" id="question_id" required>
                        </div>
                        <div class="mb-3">
                            <label  class="form-label">Select Job Profile Name</label>
                            <select class="form-select" id="update_job_profile_question">
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
                            <label for="update_difficulty_level_for_question" class="form-label">Select Difficulty level</label>
                            <select class="form-select" name="update_difficulty_level_for_question" id="update_difficulty_level_for_question">
                                    <option selected>Select Difficulty Level</option>
                                    
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label  class="form-label">Category/Skill</label>
                            <select type="text" class="form-select" name="update_category" id="update_category" >
                                <option selected>Select Category</option>
                               
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="update_question" class="form-label">Question</label>
                            <input type="text" class="form-control" id="update_question" required >
                            <div id="update_questionVerify" class="form-text"></div>  
                        </div>
                        <div class="mb-3">
                            <label for="update_option1" class="form-label">Option 1</label>
                            <input type="text" class="form-control" id="update_option1" required >
                        </div>
                        <div class="mb-3">
                            <label for="update_option2" class="form-label">Option 2</label>
                            <input type="text" class="form-control" id="update_option2" required >
                        </div>
                        <div class="mb-3">
                            <label for="update_option3" class="form-label">Option 3</label>
                            <input type="text" class="form-control" id="update_option3" required >
                        </div>
                        <div class="mb-3">
                            <label for="update_option4" class="form-label">Option 4</label>
                            <input type="text" class="form-control" id="update_option4" required >
                        </div>
                        <div class="mb-3">
                            <label for="option4" class="form-label">Correct Answer Option</label>
                            <br>
                            <!-- <input type="text" class="form-control" id="update_answer_option" required > -->
                                <input class="form-check-input" type="radio"  name="update_answer_option" value="option_1" id="update_op_1">
                                <label class="form-check-label text-light" for="option_1">option 1</label>
                                <input class="form-check-input" type="radio"  name="update_answer_option" value="option_2" id="update_op_2">
                                <label class="form-check-label text-light" for="option_2">Option 2</label>
                                <input class="form-check-input" type="radio"  name="update_answer_option" value="option_3" id="update_op_3">
                                <label class="form-check-label text-light" for="option_3">Option 3</label>
                                <input class="form-check-input" type="radio"  name="update_answer_option" value="option_4" id="update_op_4">
                                <label class="form-check-label text-light" for="option_4">Option 4</label>
                        </div>
                        <div class="mb-3">
                            <label for="update_answer_description" class="form-label">Correct Answer Description</label>
                            <textarea class="form-control auto-resize" id="update_answer_description" required></textarea>
                        </div>
                    </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn  btn-outline-primary text-light " data-bs-dismiss="modal">Cancel</button>
                        <button type="button"  class="btn btn-outline-primary text-light " id="update_question_submit" name="update_question">Update Question</button>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="main">
    <div class="row justify-content-center">
        <?php
        require_once('../admin/reduced_navbar.html');
        ?>
    </div>
    <div class="row justify-content-center">
        <?php
        require_once('../connection/connect.php');
        if (isset($_GET['job_profile']) && isset($_GET['difficulty'])) {
            $job_profile_name = $_GET['job_profile'];
            $difficulty_level=$_GET['difficulty'];
            ?>
            <div class="d-flex justify-content-center">
                    <div><a href="javascript:history.back()"><img src="https://tse3.mm.bing.net/th?id=OIP.3WDg3dO3K_fFvzpULWYoIgHaHa&pid=Api&P=0&h=180" alt="" style="height:50px;width:50px"></a></div>
                    <div class="col-md-6 col-lg-8 m-auto">
                    <h3 class="text-center" style="display: inline;margin:0;">Questions on <h3 id="dynamic_job_profile" style="display: inline;margin:0;"><?php echo $job_profile_name ;?></h3> <h3 style="display: inline;margin:0;">With Difficulty Level <?php echo $difficulty_level?></h3>
                    </div>
            </div>
        <?php
            $question_answer_table = "SELECT * FROM `question_answer` where job_profile_name='$job_profile_name' and difficulty_level='$difficulty_level' ";
            $result_of_question_answer_table_query = mysqli_query($con, $question_answer_table);
            if (mysqli_num_rows($result_of_question_answer_table_query) > 0) {
                while ($row = mysqli_fetch_assoc($result_of_question_answer_table_query)) {
        ?>
                    <div class="col-md-6 col-lg-6 mb-5 p-3">
                        <div class="rounded p-3 text card" style="cursor: pointer; transition: all 0.3s;height: 300px;">
                                    <p class="card-title">
                                        <span class="fw-bolder">Category of question :</span>
                                        <?php echo $row['category']; ?>
                                    </p>
                                    <div class="ans_description" style="height: 150px; overflow-y: auto;">
                                    <p class="card-title">
                                        <span class="fw-bolder">Question :</span>
                                        <?php echo $row['question']; ?>
                                    </p>
                                    </div>
                                    <div class="row justify-content-center" class="options" style="height: 150px; overflow-y: auto;">
                                        <div class="col-md-6 col-lg-6  d-flex justify-content-between">
                                            <p class="card-title">
                                            <span style="background-color: yellow; color: black;" class="fw-bold">Option 1 :</span>
                                            <?php echo $row['option_1']; ?>
                                            </p>
                                            <p class="card-title">
                                            <span style="background-color: lightblue; color: black;"  class="fw-bold">Option 2 :</span>
                                            <?php echo $row['option_2']; ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6 col-lg-6  d-flex justify-content-between mt-md-0 mt-3">
                                            <p class="card-title">
                                            <span style="background-color: lightgreen; color: black;"  class="fw-bold">Option 3 :</span>
                                            <?php echo $row['option_3']; ?>
                                            </p>
                                            <p class="card-title">
                                            <span style="background-color: pink; color: black;"  class="fw-bold">Option 4 :</span>
                                            <?php echo $row['option_4']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="card-title">
                                        <span class="fw-bolder">Answer Option:</span>
                                        <?php echo $row['answer_option']; ?>
                                    </p>
                                    <div class="ans_description" style="height: 150px; overflow-y: auto;">
                                    <p class="card-title">
                                        <span class="fw-bolder">Answer Description : </span>
                                        <?php echo $row['correct_answer_description']; ?>
                                    </p>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-6 col-lg-6 m-auto  d-flex justify-content-center">
                                        </div>
                                        <div class="col-md-6 col-lg-6 m-auto  d-flex justify-content-center">
                                            <button type="button" class="btn btn-info rounded mx-2" id="update_question_info<?php echo $row['question_id']; ?>" name="update_question_info" >Update Question</button>
                                            <button type="button" class="btn btn-info rounded mx-2 delete-question" data-profile-id="<?php echo $row['question_id']; ?>" data-bs-toggle="modal" data-bs-target="#delete_question_modal">Delete Question</button>
                                        </div>
                                    </div>
                        </div>
                    </div>
        <?php
                }
            } else {
                echo "
                <div class='col-md-6 col-lg-6 mt-5'>
                    <div class='container d-flex align-items-center justify-content-center' style='border-radius:20px;height:50vh'>
                        <div style='border-radius:20px'>
                            <h2 class='text-center'>Questions are not Available</h2>
                        </div>
                    </div>
                </div>";
            }
        }
        ?>
    </div>
</div>
</body>

</html>