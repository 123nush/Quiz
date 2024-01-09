<?php
session_start();
require "../connection/connect.php";
//code to insert registered data
if (!empty($_POST['full_name']) &&
    !empty($_POST['email']) &&
    !empty($_POST['username_register']) &&
    !empty($_POST['password'])
) {
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $username = mysqli_real_escape_string($con, $_POST['username_register']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $secure_pass=password_hash($password,PASSWORD_DEFAULT);
    $insert_user_info = "INSERT INTO `user` (user_name,name,email,pwd,user_type) VALUES ('$username','$full_name','$email','$secure_pass','o') ";
    if (mysqli_query($con, $insert_user_info)) {
        echo("Register");
    }
    else
    // if(mysqli_error($con))
    {
        echo ("2");
       echo ("Error description: " . mysqli_error($con));
    }
}
//code to see whether email is already refisterde or not
if(!empty($_POST['sign_up_email']))
{
    $email = $_POST['sign_up_email'];
    $query_to_search_email = "SELECT * FROM `user` WHERE email= '$email'";
    if(mysqli_num_rows(mysqli_query($con,$query_to_search_email))>0)
    {
        echo("Email is already registered");
    }else{
        echo("New Email is getting registered");
    }
}
//code to see wheather username alredy exists or not
if(!empty($_POST['username']))
{
    $username = $_POST['username'];
    $query_to_search_username = "SELECT * FROM `user` WHERE user_name= '$username'";
    if(mysqli_num_rows(mysqli_query($con,$query_to_search_username))>0)
    {
        echo("User Name already Exists");
        
    }else{
        echo("New Unique User Name");
    }
}
//code for login
if (!empty($_POST['username_login']) && !empty($_POST['password_login'])) {
    $username = mysqli_real_escape_string($con, $_POST["username_login"]);
   // $password = mysqli_real_escape_string($con,$_POST["password_login"]);
    $password=$_POST['password_login'];
    $user_info_query = "SELECT * FROM `user` WHERE user_name = '$username'";
    $result_of_user_info = mysqli_query($con, $user_info_query);
    if (mysqli_num_rows($result_of_user_info) == 1) {
        $row = mysqli_fetch_assoc($result_of_user_info);
        $hashed_password = $row['pwd'];
       // $new_hash=password_hash($password,PASSWORD_DEFAULT);
        // echo "Stored Hash: " . $hashed_password . "<br>";
        // echo "User Input: " . $new_hash . "<br>";
        //var_dump($hashed_password);
       // echo("Is password hash matching:"); 
        // echo("\nPassword is:". $password);
        // echo("\nHashed Password: ". $hashed_password);
        // echo("\nIs hash working:". password_verify($password, $hashed_password) ?' \nIts true':'\nfalse');
        // echo("\nType is: ". gettype(password_verify($password, $hashed_password)));
        // echo("\nVar dump of password verify:");
        // var_dump(password_verify($password, $hashed_password));
       // var_dump(password_hash($password, PASSWORD_DEFAULT)); 
        if (password_verify($password, $hashed_password)) {
            // Passwords match
            $user_name = $row["user_name"];
            $full_name = $row["name"];
            $user_type = $row["user_type"];
            $user_email = $row['email'];

            if ($user_type == "o") {
                echo ("1");
            } elseif ($user_type == "a") {
                echo ("2");
            }

            $_SESSION["user_name"] = $user_name;
            $_SESSION["user_full_name"] = $full_name;
            $_SESSION["user_type"] = $user_type;
            $_SESSION['user_email'] = $user_email;
        } else {
            // Password doesn't match
            echo ("\nPassword not match");
        }
    } else {
        echo ("no");
    }
}


//code to see whether username and email both matches with each other when user clicks forgot passsword
if(!empty($_POST['forgot_password_email']) && !empty($_POST['forgot_password_username']))
{
    $email = mysqli_real_escape_string($con, $_POST['forgot_password_email']);
    $username= mysqli_real_escape_string($con, $_POST['forgot_password_username']);
    $verify_user = "SELECT * from `user` where user_name='$username' and email='$email' ";
    if(mysqli_query($con,$verify_user))
    {
        $result=mysqli_query($con,$verify_user);
        if(mysqli_num_rows($result)>0){
            echo("User and Email Matched");
        }
        else{
            echo("2");
            echo ('mysqli error:'.mysqli_error($con));
        }
        //echo(mysqli_query($con,$verify_user));
    }
}
// else{
//     echo("Invalid data");
// }
//code to reset password
if(!empty($_POST['reset_password'])&& !empty($_POST['user_name']) ){
    $username = mysqli_real_escape_string($con, $_POST['user_name']);
    $password = mysqli_real_escape_string($con, $_POST['reset_password']);
    $change_user_password = "UPDATE `USER` SET `pwd` = '$password' WHERE `USER`.`user_name` = '$username' ";
    if(mysqli_query($con,$change_user_password))
    {
        echo('Password Reset');
       // echo("Hello");
        // if(mysqli_num_rows($result)==1){
            //echo("1");
        // }
    }
    else{
        echo("2");
    }
}
//code for getting questions when quiz starts
if(!empty($_POST['job_profile_name_for_quiz']) && !empty($_POST['difficulty_level_for_quiz'])){
    $job_profile_name_for_quiz=mysqli_real_escape_string($con,$_POST['job_profile_name_for_quiz']);
    $difficulty_level_for_quiz=mysqli_real_escape_string($con,$_POST['difficulty_level_for_quiz']);
    $get_questions_for_quiz = "SELECT * FROM `question_answer` WHERE job_profile_name='$job_profile_name_for_quiz' AND difficulty_level='$difficulty_level_for_quiz' ORDER BY rand() LIMIT 0,3";
    $result_for_getting_questions = mysqli_query($con, $get_questions_for_quiz);
    if(mysqli_num_rows($result_for_getting_questions)>0) {
        $question_answer = array(); 
        while ($question_answer_row = mysqli_fetch_assoc($result_for_getting_questions)) {
            $question_answer[] = array(
                'question' => $question_answer_row['question'],
                'option_1' => $question_answer_row['option_1'],
                'option_2' => $question_answer_row['option_2'],
                'option_3' => $question_answer_row['option_3'],
                'option_4' => $question_answer_row['option_4'],
                'question_id'=>$question_answer_row['question_id'],
                'correct_answer_description' => $question_answer_row['correct_answer_description']
            );
        }
        echo json_encode(array('total' => mysqli_num_rows($result_for_getting_questions), 'questions' => $question_answer));
    }
    else{
        echo("Try Again!!!".mysqli_error($con));
    }
}
//code to insert data in result table and quiz , quiz_question table
if(!empty($_POST['score']) 
&& !empty($_POST['IncorrectQuestions']) 
&& !empty($_POST['attainedQuestions'])
&& !empty($_POST['job_profile_name_for_quiz'])
&& !empty($_POST['no_of_questions'])
&& !empty($_POST['questionids'])
&& !empty($_POST['username_for_quiz'])
){
    function generateUniqueResultID() {
        $id = mt_rand(1, 4999);
        while (in_array($id, $_SESSION['generated_ids'] ?? [])) {
            $id = mt_rand(1, 4999);
        }
        $_SESSION['generated_ids'][] = $id; // Store the generated ID
        return $id;
    }
     function generateUniqueQuizID() {
        $id = mt_rand(5000, 9999);
        while (in_array($id, $_SESSION['generated_ids'] ?? [])) {
            $id = mt_rand(5000, 9999);
        }
        $_SESSION['generated_ids'][] = $id; // Store the generated ID
        return $id;
    }
    $quiz_id=generateUniqueQuizID();
    $score=mysqli_real_escape_string($con,$_POST['score']);
    $IncorrectQuestions=mysqli_real_escape_string($con,$_POST['IncorrectQuestions']);
    $attainedQuestions=mysqli_real_escape_string($con,$_POST['attainedQuestions']);
    $job_profile_name_for_quiz=mysqli_real_escape_string($con,$_POST['job_profile_name_for_quiz']);
    $no_of_questions=mysqli_real_escape_string($con,$_POST['no_of_questions']);
    $questionids=$_POST['questionids'];
    $result_id = generateUniqueResultID();
    $username=mysqli_real_escape_string($con,$_POST['username_for_quiz']);
    $query_to_insert_result="INSERT into `result`(result_id,score,user_name,correct_ans,incorrect_ans,attained_questions)
     values ('$result_id','$score','$username','$score','$IncorrectQuestions','$attainedQuestions')";
     $currentdate = date('Y-m-d');
    //  echo("hello I will work");
    if(mysqli_query($con,$query_to_insert_result)){
        // echo ("result set");
        $query_to_insert_quiz_data="INSERT INTO `quiz` (quiz_id,quiz_date,no_of_questions,result_id,job_profile_name,user_name) 
        values ('$quiz_id','$currentdate','$no_of_questions','$result_id','$job_profile_name_for_quiz','$username')";
        if(mysqli_query($con,$query_to_insert_quiz_data)){
            // echo(" quiz data set");
            foreach( $questionids as $question_id){
            $query_to_insert_quiz_question_data="INSERT into `quiz_questions`(quiz_id,question_id) 
            values ('$quiz_id','$question_id')";
            mysqli_query($con,$query_to_insert_quiz_question_data);
            }
            echo("result, quiz,quiz_question data set");
        }
    }
    else{
        echo("result not set");
        echo("Error".mysqli_error($con));
    }
}
//code to insert reviews 
if (
    isset($_POST['suggested_job_profileArray']) &&
    isset($_POST['reason_for_job_profile']) &&
    isset($_POST['suggestion_for_system']) &&
    isset($_POST['username_review'])
) {
    // Your function to generate unique ID
    function generateUniqueReviewID()
    {
        $id = mt_rand(70000, 99999);
        while (in_array($id, $_SESSION['generated_ids'] ?? [])) {
            $id = mt_rand(70000, 99999);
        }
        $_SESSION['generated_ids'][] = $id; // Store the generated ID
        return $id;
    }
    $review_id = generateUniqueReviewID();
    $suggested_job_profile = $_POST['suggested_job_profileArray'];
    $suggestedJobProfileString = implode(', ', $suggested_job_profile);
    $reason_for_job_profile = mysqli_real_escape_string($con, $_POST['reason_for_job_profile']);
    $suggestion_for_system = mysqli_real_escape_string($con, $_POST['suggestion_for_system']);
    $username_review = mysqli_real_escape_string($con, $_POST['username_review']);
    $query_to_insert_review = "INSERT into `review` (review_id, suggested_job_profile, reason_for_job_profile, suggestion_for_system, user_name) 
                               values ('$review_id', '$suggestedJobProfileString', '$reason_for_job_profile', '$suggestion_for_system', '$username_review')";
    if (mysqli_query($con, $query_to_insert_review)) {
        echo "Review inserted successfully";
    } else {
        echo "Error: " . $query_to_insert_review . "<br>" . mysqli_error($con);
    }
} 
//code to check wheather mail is already exists when user want's to update their profile
if(!empty($_POST['update_user_email'])){
    $email=mysqli_real_escape_string($con,$_POST['update_user_email']);
    $query_to_search_email_and_username = "SELECT * FROM `user` WHERE email = '$email'";
    if(mysqli_num_rows(mysqli_query($con,$query_to_search_email_and_username))>0)
    {
        echo("Email already exists");
    }else{
        echo("New email");
    }
}
//code to change user data when user want's to update their profile
if(!empty($_POST['update_full_name'])
&& !empty($_POST['update_email'])
&& !empty($_POST['update_password'])
&& !empty($_POST['update_username'])){
    $username=mysqli_real_escape_string($con,$_POST['update_username']);
    $update_full_name=mysqli_real_escape_string($con,$_POST['update_full_name']);
    $update_password=mysqli_real_escape_string($con,$_POST['update_password']);
    $update_email=mysqli_real_escape_string($con,$_POST['update_email']);
    $query_to_update_user_data = "UPDATE `user` 
                             SET `name` = '$update_full_name', 
                                 `email` = '$update_email', 
                                 `pwd` = '$update_password' 
                             WHERE `user_name` = '$username'";
            if (mysqli_query($con, $query_to_update_user_data)) {
                // $affectedRows = mysqli_affected_rows($con);
                // if ($affectedRows > 0) {
                    echo "User Data updated successfully";
                // } else {
                //     echo "No changes made to user data.";
                // }
            } else {
                echo "Error updating user data: " . mysqli_error($con);
            }
}
if(!empty($_POST['job_profile_from_which_date_retrived'])
&& !empty($_POST['view_history_user'])){
    $job_profile=mysqli_real_escape_string($con,$_POST['job_profile_from_which_date_retrived']);
    $username=mysqli_real_escape_string($con,$_POST['view_history_user']);
    $query_to_find_dates="SELECT distinct  quiz_date FROM `quiz` WHERE `job_profile_name` ='$job_profile' and user_name='$username'";
    $result=mysqli_query($con,$query_to_find_dates);
    $dates = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $dates[] = [
                'quiz_date' => $row['quiz_date'] 
            ];
        }
        echo json_encode($dates);
    } else {
        echo("No result");
    }
}
?>