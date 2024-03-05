<?php
session_start();
// phpinfo();
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
    if(strlen($username)<255){
        if(strlen($full_name)<255){
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
        else{
            echo "The input exceeds the character limit of option Name ";
        }
    }
    else{
        echo "The input exceeds the character limit of option Username field";
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
    $password = mysqli_real_escape_string($con,$_POST["password_login"]);
    $user_info_query = "SELECT * FROM `user` WHERE user_name = '$username'";
    $result_of_user_info = mysqli_query($con, $user_info_query);
    if (mysqli_num_rows($result_of_user_info) > 0) {
        $row = mysqli_fetch_assoc($result_of_user_info);
        $hashed_password = $row['pwd'];
        $new_hash=password_hash($password,PASSWORD_DEFAULT);
        if (password_verify($password, $hashed_password)) {
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
            echo ("Password not match");
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
//code to reset password
if(!empty($_POST['reset_password'])&& !empty($_POST['user_name']) ){
    $username = mysqli_real_escape_string($con, $_POST['user_name']);
    $password = mysqli_real_escape_string($con, $_POST['reset_password']);
    $secure_pass=password_hash($password,PASSWORD_DEFAULT);
    $change_user_password = "UPDATE `user` SET `pwd` = '$secure_pass' WHERE `user`.`user_name` = '$username' ";
    if(mysqli_query($con,$change_user_password))
    {
        echo('Password Reset');
    }
    else{
        echo("2");
    }
}
//code for getting questions when quiz starts
if(!empty($_POST['job_profile_name_for_quiz']) && !empty($_POST['difficulty_level_for_quiz'])){
    $job_profile_name_for_quiz=mysqli_real_escape_string($con,$_POST['job_profile_name_for_quiz']);
    $difficulty_level_for_quiz=mysqli_real_escape_string($con,$_POST['difficulty_level_for_quiz']);
    $get_questions_for_quiz = "SELECT * FROM `question_answer` WHERE job_profile_name='$job_profile_name_for_quiz' AND difficulty_level='$difficulty_level_for_quiz' ORDER BY rand() LIMIT 0,10";
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
                'answer_option'=>$question_answer_row['answer_option'],
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
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true); 
if(!empty($data['score']) 
&& !empty($data['IncorrectQuestions']) 
&& !empty($data['attainedQuestions'])
&& !empty($data['job_profile_name_for_quiz'])
&& !empty($data['no_of_questions'])
&& !empty($data['questionids'])
&& !empty($data['all_question_track'])
&& !empty($data['username_for_quiz'])
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
    $score=mysqli_real_escape_string($con,$data['score']);
    $IncorrectQuestions=mysqli_real_escape_string($con,$data['IncorrectQuestions']);
    $attainedQuestions=mysqli_real_escape_string($con,$data['attainedQuestions']);
    $job_profile_name_for_quiz=mysqli_real_escape_string($con,$data['job_profile_name_for_quiz']);
    $no_of_questions=mysqli_real_escape_string($con,$data['no_of_questions']);
    $questionids=$data['questionids'];
    $result_id = generateUniqueResultID();
    $total_real_questions=intval($score)+intval($IncorrectQuestions);
    $username=mysqli_real_escape_string($con,$data['username_for_quiz']);
    $all_question_track = $data['all_question_track'];
    $query_to_insert_result="INSERT into `result`(result_id,score,user_name,correct_ans,incorrect_ans,attained_questions)
     values ('$result_id','$score','$username','$score','$IncorrectQuestions','$total_real_questions')";
     $currentdate = date('Y-m-d');
     echo("hello I will work here only");
    if(mysqli_query($con,$query_to_insert_result)){
        // echo ("result set");
        $query_to_insert_quiz_data="INSERT INTO `quiz` (quiz_id,quiz_date,no_of_questions,result_id,job_profile_name,user_name) 
        values ('$quiz_id','$currentdate','$no_of_questions','$result_id','$job_profile_name_for_quiz','$username')";
        if(mysqli_query($con,$query_to_insert_quiz_data)){
            // echo(" quiz data set");
            foreach( $questionids as $question_id){
                $category_result=$all_question_track[$question_id];
                $query_to_insert_quiz_question_data="INSERT into `quiz_questions`(quiz_id,question_id,category_result) 
                values ('$quiz_id','$question_id','$category_result')";
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
    $secure_pass=password_hash($update_password,PASSWORD_DEFAULT);
    $update_email=mysqli_real_escape_string($con,$_POST['update_email']);
    $query_to_update_user_data = "UPDATE `user` 
                             SET `name` = '$update_full_name', 
                                 `email` = '$update_email', 
                                 `pwd` = '$secure_pass' 
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
//code to fetch dates when user will select job profile
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
//code to return total score and attained questions when user selects job profile
// if(!empty($_POST['ka_nahi_hot_he'])){
//     $var=mysqli_real_escape_string($con,$_POST['ka_nahi_hot_he']);
//     echo($var);
// }
if(!empty($_POST['job_profile_view_analysis'])
&& !empty($_POST['view_analysis_user'])){
    $job_profile=mysqli_real_escape_string($con,$_POST['job_profile_view_analysis']);
    $username=mysqli_real_escape_string($con,$_POST['view_analysis_user']);
    //query for getting results id
    $total_questions_array=[];
    $total_score_array=[];
    //storing result id for getting analysis data
    $result_id_array=[];
    $query_to_get_result_id="SELECT result_id FROM `quiz` WHERE `job_profile_name` ='$job_profile' and user_name='$username'";
    if(mysqli_query($con,$query_to_get_result_id)){
        $result_id_result=mysqli_query($con,$query_to_get_result_id);
        if(mysqli_num_rows($result_id_result)>0){
            while($result_id=mysqli_fetch_assoc($result_id_result)){
                $result_id_array[]=$result_id['result_id'];
                $id=$result_id['result_id'];
                //query for getting score and total questions
                $query_score_questions="SELECT attained_questions,score from `result` where result_id='$id' ";
                $result=mysqli_query($con,$query_score_questions);
                if(mysqli_num_rows($result)>0) {
                while ($row_for_data = mysqli_fetch_assoc($result)) {
                    $total_questions_array[]=$row_for_data['attained_questions'];
                    $total_score_array[]=$row_for_data['score'];
                }
            }
           
        }
        $score_question_data = array(
            'attained_questions' => array_sum($total_questions_array),
            'acheived_score' => array_sum($total_score_array)
        );
        
        // print_r($result_id_array);
        //from each result id find quiz id and from quiz id find category and category_result
        $question_id_array=[];
        //array for storing question_id as key and category_result as value
        $question_result_array=[];
        
            foreach($result_id_array as $analysis_result){
                //query for quiz id
                $query_for_quiz_id="SELECT quiz_id from `quiz` where result_id='$analysis_result' ";
                $result_of_quiz=mysqli_query($con,$query_for_quiz_id);
                if(mysqli_num_rows($result_of_quiz)>0){
                    while($quiz_id_row=mysqli_fetch_assoc($result_of_quiz)){
                        $quiz_id=$quiz_id_row['quiz_id'];
                        //query for question id and category result
                        $query_for_question_id="SELECT question_id,category_result from `quiz_questions` where quiz_id='$quiz_id' ";     
                        $result_for_question_category=mysqli_query($con,$query_for_question_id);
                        while($question_category=mysqli_fetch_assoc($result_for_question_category)){
                           $question_result_array[$question_category["question_id"]]= $question_category["category_result"];
                            $question_id_array[]=$question_category['question_id'];
                        }
                    }
                }
            }
            $categories_question_id=[];
            foreach($question_id_array as $question_id){
                $query_for_getting_category="SELECT category,question_id from `question_answer` where question_id='$question_id' ";
                $result_for_categoty=mysqli_query($con,$query_for_getting_category);
                while($row=mysqli_fetch_assoc($result_for_categoty)){
                    $categories_question_id[$row['question_id']]=$row['category'];
                }
            }
            // print_r($question_result_array);
            // print_r($categories_question_id);
            //Now deal with category and it's count
            // Initialize an associative array to store counts for each category
            $category_counts = [];

                // Iterate over the question result array
            foreach ($question_result_array as $question_id => $correctness) {
                // Retrieve the category for the current question ID
                $category = $categories_question_id[$question_id];
                // If the category is not already initialized in $category_counts, initialize it
                if (!isset($category_counts[$category])) {
                    $category_counts[$category] = ['Y' => 0, 'N' => 0, 'total' => 0];
                }
                // Increment the count based on the correctness
                if ($correctness === 'Y') {
                    $category_counts[$category]['Y']++;
                } else {
                    $category_counts[$category]['N']++;
                }
                // Increment the total count for the category
                $category_counts[$category]['total']++;
            }
            // print_r($category_counts);
            // echo json_encode($score_question_data); //must uncomment
            // print_r($category_counts);
            $data_to_send = [
                'score_question_data' => $score_question_data,
                'category_counts' => $category_counts
            ];
            // Encode the data to JSON format
            $json_data = json_encode($data_to_send);
            // Send the JSON data to the client
            echo $json_data;
    }
    }
    else{
        echo("Do not analyse!!");
    }
   
}
//code to request render.com
if (!empty($_POST['job_profile_analysis']) 
&& isset($_POST['total_question']) 
&& isset($_POST['total_score'])
&& !empty($_POST['categoryData'])) {
    $job_profile = $_POST['job_profile_analysis'];
    $total_questions = $_POST['total_question'];
    $total_score = $_POST['total_score'];
    $category_wise_data=$_POST['categoryData'];
    if($total_questions=='0'){
        $total_questions=1;
    }
    if($total_score=='0'){
        $total_score=1;
    }
    // Debugging: Log received data
    error_log("Received data: job_profile=$job_profile, total_question=$total_questions, total_score=$total_score");
   // error_log(print_r($total_questions, true));
    $data_to_send = array(
        'job_profile_name_analysis' => $job_profile,
        'attained_questions_analysis' => $total_questions,
        'score_analysis' => $total_score,
        'category_performance_analysis' => json_encode($category_wise_data)
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://ml-640d.onrender.com/predict');
    // curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5000/predict');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_send));

    $response = curl_exec($ch);
    if ($response === false) {
        // Debugging: Log cURL error
        error_log('cURL Error: ' . curl_error($ch));
        echo 'Error: Internal server error occured here'; // Return generic error message
    } else {
        
        echo $response; // Return the response from the Flask app
       
    }
    // print_r($data_to_send);
    // echo "Average";
    curl_close($ch);
} 

?>