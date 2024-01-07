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
</head>
<body>
<div class="main">
    <div class="row justify-content-center">
          <!-- code for navbar -->
              <?php
              require_once('../connection/connect.php');
              require_once('../User/user_navbar.html');
              ?>
            <div class="col-md-10 col-lg-10 mx-auto">
                <div class="col-lg-8 col-md-6 m-auto" style="background-color: white;">
                <?php
                if(isset($_GET['job_profile'])&& isset($_GET['date'])&& isset($_GET['username'])){
                    $job_profile=$_GET['job_profile'];
                    $date=$_GET['date'];
                    $username=$_GET['username'];
                    $scores=[];
                    $attained_questions=[];
                    $incorrect_ans=[];
                    $counter=-1;
                    $query_to_quiz_id="SELECT quiz_id,result_id FROM `quiz` where quiz_date='$date' and quiz.user_name='$username' and  `quiz`.`job_profile_name` like '%$job_profile%'";
                    $result_of_quiz_id=mysqli_query($con,$query_to_quiz_id);
                   if(mysqli_num_rows($result_of_quiz_id)>0){
                    while($row_of_quiz_id=mysqli_fetch_assoc($result_of_quiz_id)){
                        $quiz_id=$row_of_quiz_id['quiz_id'];
                        $result_id=$row_of_quiz_id['result_id'];
                        //query to get each question id
                        $query_for_questions_id="SELECT question_id from quiz_questions where quiz_id='$quiz_id'";
                        $query_for_score="SELECT * from `result` where result_id='$result_id' ";
                        $score_result=mysqli_query($con,$query_for_score);
                        $result_of_question_id=mysqli_query($con,$query_for_questions_id);
                        if(mysqli_num_rows($result_of_question_id)>0 && mysqli_num_rows($score_result)>0){
                            while($row_score=mysqli_fetch_assoc($score_result)){
                                 $scores[]=$row_score['score'];
                                 $attained_questions[]=$row_score['attained_questions'];
                                 $incorrect_ans[]=$row_score['incorrect_ans'];
                                 $counter++;
                                }
                                echo("Score:".$scores[$counter]."Attained Questions".$attained_questions[$counter]."Incoorect Questions".$incorrect_ans[$counter]);
                            while($row_of_question_id=mysqli_fetch_assoc($result_of_question_id)){
                                $question_id=$row_of_question_id['question_id'];
                                $query_for_questions="SELECT * from question_answer where question_id='$question_id'";
                                $result_of_questions=mysqli_query($con,$query_for_questions);
                                $query_for_score="SELECT * from result where result_id='$result_id' ";
                                if(mysqli_num_rows($result_of_questions)>0){
                                    while($questions=mysqli_fetch_assoc($result_of_questions)){
                                        $question=$questions['question'];
                                        ?>
                                        <div class="col-lg-8 col-md-6 m-auto my-2">
                                            <!-- <p>attained qustions</p> -->
                                            <h3><?php echo $questions['question'];?></h3>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                        <!-- Here I have to do spacing so that will be in 2 seperate quiz -->
                        <div class="my-5"></div>
                    <?php    
                    }
                   }

                }
                ?>
                </div>
            </div>
    </div>
</div>

</body>
</html>

