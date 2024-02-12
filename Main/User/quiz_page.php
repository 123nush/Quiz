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
    <script src="https://unpkg.com/scrollreveal"></script> 
    <!-- scroll js not works -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Quiz Page</title>
    <!-- talwind link -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
    <!-- link for animation  with text-->
  <link href="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/cssanimation.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/cssanimation.min.css">
  <script src="../../JavaScript/animation.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/letteranimation.min.js"></script>
<!-- link for various effects with shape -->
<link rel="stylesheet" href="../../Css/shape.css">
<script src="../../JavaScript/quiz_time.js"></script>
<style>
.option-container {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 8px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    cursor: pointer;
}
.option-number {
    margin-right: 5px;
}
.option {
    flex-grow: 1;
}
.selected {
    background-color: #3366cc; 
    color: white;
}
.option-container:hover {
    border-color: black; 
}
.option-container.active {
    background-color: black !important; /* Ensure the selected background color overrides */
    color: white;
}
.preview-question {
    margin-bottom: 20px;
    border: 1px solid #ccc;
    padding: 10px;
}

.preview-question h2 {
    font-weight: bold;
}

.preview-question p {
    margin: 5px 0;
}

#userScore {
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 20px;
}
.circle-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-image: url('../../Images/winner.png');
    background-size: cover;
    margin-left: 10px; 
    align-items: center;
    justify-content: center;
}
#score_result_image {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
</style>
</head>
<body>
<!-- modal for quiz rules-->
<div class="modal fade" id="quiz_rules" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
            <div class="modal-body">
            <form class="">
                <label class="form-check-label" >
                    <h5 class="text-center fw-bold fs-large">Rules Of Quiz or GuideLines</h5>
                    <ul style="list-style-type:disc" class="mb-3 p-3">
                        <li>Accurate Responses: Users receive one point for each accurate answer.</li>
                        <li>Unanswered Questions: Incorrect answers are assigned to unanswered questions.</li>
                        <li>Incorrect Answers: Inaccurate answers do not receive any points.</li>
                        <li> There is a predetermined 5-minute time limit for quizzes.</li>
                        <li> Each quiz follows this standard count, with a total of 10 questions.</li>
                        <li>Users will see a preview right away after submitting the quiz.</li>
                    </ul>
                </label>
                <div class="mb-3">
                            <input type="checkbox" id="starting_quiz" name="starting_quiz" value="I read all the rules">  I Read all rules
                </div>
            </form>
            </div>
            <div class="modal-footer justify-content-center">
                    <a href="../../Main/User/quiz_section.php" class="w-25"><button type="button" class="btn btn-outline-primary "  id="back_to_home">Back</button></a>
                    <button type="button" style="display: none;" class="btn btn-outline-primary " id="start_quiz" name="start_quiz" data-bs-dismiss="modal">Start</button>
            </div>
            </div>
        </div>
    </div>
<!-- main body -->
    <div class="main">
        <div class="row justify-content-center">
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
           <div class="d-flex row" style="display: none;">
                <div class="col-lg-7 col-md-7 justify-content-center align-item-center m-auto my-0" >
                    <h1 class="fs-1 text-center m-auto" id="quiz_job_profile"></h1><br>
                    <h2 class="fs-2" id="username" style="display: none;"><?php echo($user_name); ?> </h2>
                </div>
                <div id="countdown" class="fs-5 fw-10 text-center col-lg-7 col-md-7 m-auto my-0"></div>
            </div>
            <!-- question and options div -->
            <div id="quizContainer" class="col-lg-6 col-md-8 m-auto " style="border-radius: 10px;background-color:white;color:black;display:none">
                <div id="question" class="mt-2 fs-4 fw-50 text-center fw-bold"></div>
                <div id="options" class="mt-2 mx-5 fs-6 fw-50"></div>
                <div class="d-flex">
                    <button id="prevButton" class="btn btn-primary m-auto" style="display: none;">Previous</button>
                    <button id="nextButton" class="btn btn-primary m-auto"  style="display: none;">Next</button>
                    <button id="submitButton" class="btn btn-primary m-auto" style="display: none;">Submit</button>
                </div>
            </div>
        <!--   preview div -->
                <div id="quizPreview" class="col-lg-7 col-md-8 m-auto bg-light" style="display: none;border-radius:10px">
                    <!-- <div id="score_result_image"> -->
                        <!-- <div id="result_image" class="circle-image"> </div> -->
                        <div id="userScore" class="text-center"></div>
                        <div id="attainedQ" class="text-center"></div>
                        <div id="incorrectQ" class="text-center"></div>
                    <!-- </div> -->
                    <div id="previewQuestions"></div>
                </div>
    </div>
</div>
<script>
    window.onload = function() {
    $('#quiz_rules').modal('show'); // Show the modal on page load
};
const startingQuizCheckbox = document.getElementById('starting_quiz');
const startButton = document.getElementById('start_quiz');
startingQuizCheckbox.addEventListener('change', function() {
    if (startingQuizCheckbox.checked) {
        startButton.style.display = 'block';
    } else {
        startButton.style.display = 'none';
    }
});
</script>
</body>
</html>