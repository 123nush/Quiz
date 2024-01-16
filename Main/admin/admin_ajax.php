<?php
require_once('../connection/connect.php');
//code to job profile data is already there in database
if(!empty($_POST['job_profile_name_to_check'])){
    $job_profile_name_to_check=mysqli_real_escape_string($con,$_POST['job_profile_name_to_check']);
    $query="SELECT * from `job_profile` where job_profile_name='$job_profile_name_to_check' ";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)>0){
        echo('Job Profile Name already exists');
    }
}
//code to insert job profile data in database
if (
    !empty($_POST['job_profile_name']) &&
    !empty($_POST['job_profile_information']) &&
    !empty($_POST['technologies']) &&
    !empty($_POST['tasks'])&&
    isset($_FILES['job_profile_pic'])
) {
    $max_length = 255;
    $JobPic = $_FILES['job_profile_pic'];
    $pic_name=$JobPic['name'];
    $pic_path=$JobPic['tmp_name'];
    $pic_error=$JobPic['error'];
    $destination='../../Images/'.$pic_name; 
    move_uploaded_file($pic_path,$destination);
    $job_profile_name = mysqli_real_escape_string($con, $_POST['job_profile_name']);
    $job_profile_information = mysqli_real_escape_string($con, $_POST['job_profile_information']);
    $technologiesArray =json_decode($_POST['technologies'],true);
    $tasksArray =json_decode($_POST['tasks'],true);
    $currentdate = date('Y-m-d');
    if (strlen($job_profile_name) <= 255) {
        //checking each value of technology whether exceds or not
        foreach ($technologiesArray as $technology) {
            if (mb_strlen($technology) > $max_length) {
                echo "Error: Technology name '$technology' exceeds maximum length of $max_length characters. Data not inserted.";
                exit;
            }
        }
        //checking each value of task whether exceeds or not
        foreach ($tasksArray as $task) {
            if (mb_strlen($task) > $max_length) {
                echo "Error: Task name '$task' exceeds maximum length of $max_length characters. Data not inserted.";
                exit;
            }
        }
        $qurey_to_insert_job_profile_info = "INSERT INTO `job_profile` (job_profile_name, role,job_pic, update_date) VALUES ('$job_profile_name', '$job_profile_information','$destination', '$currentdate')";
        
        if (mysqli_query($con, $qurey_to_insert_job_profile_info)) {
            $job_profile_id = mysqli_insert_id($con); // Get the inserted job_profile_id
            
            // Loop through and insert each technology
            foreach ($technologiesArray as $technology) {
                $sanitizedTechnology = mysqli_real_escape_string($con, $technology);
                $insert_technology_query = "INSERT INTO `job_technologies` (job_profile_name, technology) VALUES ('$job_profile_name', '$sanitizedTechnology')";
                mysqli_query($con, $insert_technology_query);
            }
            foreach ($tasksArray as $task) {
                $sanitizedTask = mysqli_real_escape_string($con, $task);
                $insert_task_query = "INSERT INTO `job_tasks` (job_profile_name, task) VALUES ('$job_profile_name', '$sanitizedTask')";
                mysqli_query($con, $insert_task_query);
            }
            
            echo "Job Profile Data Inserted";
        } else {
            echo("Error:".mysqli_error($con));
            echo "Data Not Inserted";
        }
    } else {
        // Value exceeds the character limit
        echo "The input exceeds the character limit of job profile name";
    }
   
}
//code to delete job profile information from database
if (!empty($_POST['profileName'])){
    $profileName = mysqli_real_escape_string($con, $_POST['profileName']);

    // Delete from job_tasks table
    $queryToDeleteTasks = "DELETE FROM `job_tasks` WHERE job_profile_name='$profileName'";
    if(mysqli_query($con, $queryToDeleteTasks)) {
        // Delete from job_technologies table
        $queryToDeleteTechnology = "DELETE FROM `job_technologies` WHERE job_profile_name='$profileName'";
        if(mysqli_query($con, $queryToDeleteTechnology)) {
            // Finally, delete from job_profile table
            $queryToDeleteProfile = "DELETE FROM `job_profile` WHERE job_profile_name='$profileName'";
            if(mysqli_query($con, $queryToDeleteProfile)) {
                echo 'Job Profile Data Deleted';
            } else {
                echo 'Data Not Deleted';
                echo 'Error Is: ' . mysqli_error($con);
            }
        } else {
            echo 'Data Not Deleted';
            echo 'Error Is: ' . mysqli_error($con);
        }
    } else {
        echo 'Data Not Deleted';
        echo 'Error Is: ' . mysqli_error($con);
    }
}
//code to display data during update of job profile
if (!empty($_POST['profileNameUpdate'])){
    $selectedProfileName=mysqli_real_escape_string($con,$_POST['profileNameUpdate']);
    $get_job_profile_info="SELECT * from `job_profile` where job_profile_name='$selectedProfileName'";
    $result_of_job_profile=mysqli_query($con,$get_job_profile_info);
    $get_job_tasks="SELECT * from `job_tasks` where job_profile_name='$selectedProfileName' and task<>' ' ";
    $result_of_job_tasks=mysqli_query($con,$get_job_tasks);
    $get_job_techs="SELECT * from `job_technologies` where job_profile_name='$selectedProfileName' and technology<>' '";
    $result_of_job_tech=mysqli_query($con,$get_job_techs);
    if(mysqli_num_rows($result_of_job_profile) > 0){
        $profile_name = mysqli_fetch_assoc($result_of_job_profile);
        $job_profile = [
            'job_profile_name' => $profile_name['job_profile_name'],
            'role' => $profile_name['role'],
            'photo'=>$profile_name['job_pic'],
            'tasks' => [],
            'technologies' => []
        ];
        if(mysqli_num_rows($result_of_job_tasks)){
            while($task = mysqli_fetch_assoc($result_of_job_tasks)){
                $job_profile['tasks'][] = $task;
            }
        }
    
        if(mysqli_num_rows($result_of_job_tech)){
            while($tech = mysqli_fetch_assoc($result_of_job_tech)){
                $job_profile['technologies'][] = $tech;
            }
        }
    
        echo json_encode($job_profile);
    }
}
//code to update job profile photo
if(isset($_FILES['update_job_profile_pic'])
&& !empty($_POST['photo_update_job_profile_name'])){
    $UpdateJobPic = $_FILES['update_job_profile_pic'];
    $pic_name=$UpdateJobPic['name'];
    $pic_path=$UpdateJobPic['tmp_name'];
    $pic_error=$UpdateJobPic['error'];
    $destination='../../Images/'.$pic_name; 
    move_uploaded_file($pic_path,$destination);
    $photo_update_job_profile_name = mysqli_real_escape_string($con, $_POST['photo_update_job_profile_name']);
    $qurey_to_update_job_profile_photo = "UPDATE `job_profile` set  job_pic='$destination' where job_profile_name='$photo_update_job_profile_name' ";
    if(mysqli_query($con,$qurey_to_update_job_profile_photo)){
        echo("Image replace");
    }
    else{
       echo("Not replace:".mysqli_error($con));
    }
}
//code to update data of job profile

if (
    !empty($_POST['update_job_profile_name']) &&
    !empty($_POST['update_job_profile_information']) &&
    !empty($_POST['updatetechnologies'])&&
    !empty($_POST['updatetasks'])
) {
    $update_job_profile_name = mysqli_real_escape_string($con, $_POST['update_job_profile_name']);
    $update_job_profile_information = mysqli_real_escape_string($con, $_POST['update_job_profile_information']);
    $updatetechnologiesArray = $_POST['updatetechnologies'];
    $updatetasksArray = $_POST['updatetasks'];
    $currentdate = date('Y-m-d');
    if (strlen($update_job_profile_name) <= 255) {
        $max_length=255;
        foreach ($updatetechnologiesArray as $technology) {
            if (mb_strlen($technology) > $max_length) {
                echo "Error: Technology name '$technology' exceeds maximum length of $max_length characters. Data not inserted.";
                exit;
            }
        }
        //checking each value of task whether exceeds or not
        foreach ($updatetasksArray as $task) {
            if (mb_strlen($task) > $max_length) {
                echo "Error: Task name '$task' exceeds maximum length of $max_length characters. Data not inserted.";
                exit;
            }
        }
        //getting data for updation
        $get_job_tasks="SELECT * from `job_tasks` where job_profile_name='$update_job_profile_name' and task<>' ' ";
        $result_of_job_tasks=mysqli_query($con,$get_job_tasks);
        $get_job_techs="SELECT * from `job_technologies` where job_profile_name='$update_job_profile_name' and technology<>' ' ";
        $result_of_job_tech=mysqli_query($con,$get_job_techs);
        $tasks=[];
        $technologies=[];
        if(mysqli_num_rows($result_of_job_tasks)){
            while($task = mysqli_fetch_assoc($result_of_job_tasks)){
                $tasks[] = $task;
            }
        }
        if(mysqli_num_rows($result_of_job_tech)){
            while($tech = mysqli_fetch_assoc($result_of_job_tech)){
                $technologies[] = $tech;
            }
        }
        // update job profile information
        $qurey_to_update_job_profile_info = "UPDATE `job_profile` set  role='$update_job_profile_information',update_date='$currentdate' where job_profile_name='$update_job_profile_name' ";
    
        if (mysqli_query($con, $qurey_to_update_job_profile_info)) {
            $job_profile_id = mysqli_insert_id($con); // Get the updated job_profile_id
            $count=count($technologies);
            for($i=0;$i<$count;$i++) {
            if(isset($updatetechnologiesArray[$i]) && isset($technologies[$i]['technology'])){
                $updatesanitizedTechnology = mysqli_real_escape_string($con, $updatetechnologiesArray[$i]);
                $sanitizedTechnology=mysqli_real_escape_string($con,$technologies[$i]['technology']);
                $update_technology_query = "UPDATE `job_technologies` SET technology='$updatesanitizedTechnology' WHERE job_profile_name='$update_job_profile_name' and technology='$sanitizedTechnology' ";
                mysqli_query($con, $update_technology_query);
            }
            }
            //code to add data during update
            if(count($updatetechnologiesArray)>count($technologies)){
                $data_to_update=count($updatetechnologiesArray)-count($technologies);
                for($i=count($technologies);$i<count($updatetechnologiesArray);$i++){
                    $sanitizedTechnology = mysqli_real_escape_string($con, $updatetechnologiesArray[$i]);
                    $insert_technology_query = "INSERT INTO `job_technologies` (job_profile_name, technology) VALUES ('$update_job_profile_name', '$sanitizedTechnology')";
                    mysqli_query($con, $insert_technology_query);
                }
            }
            // Loop through and update each task
            $count1=count($tasks);
            for($i=0;$i<$count1;$i++) {
                $updatesanitizedtask = mysqli_real_escape_string($con, $updatetasksArray[$i]);
                $sanitizedtask=mysqli_real_escape_string($con,$tasks[$i]['task']);
                $update_task_query = "UPDATE `job_tasks` SET task='$updatesanitizedtask' WHERE job_profile_name='$update_job_profile_name' and task='$sanitizedtask' ";
                mysqli_query($con, $update_task_query);
            }
            if(count($updatetasksArray)>count($tasks)){
                for($i=count($tasks);$i<count($updatetasksArray);$i++){
                    $sanitizedTask = mysqli_real_escape_string($con, $updatetasksArray[$i]);
                    $insert_task_query = "INSERT INTO `job_tasks` (job_profile_name, task) VALUES ('$update_job_profile_name', '$sanitizedTask')";
                    mysqli_query($con, $insert_task_query);
                }
                
            }
            echo "Job profile data updated";
        
            }
             else { 
            echo(mysqli_error($con));
            echo "Data Not updated";
        }
    }
    else {
        echo "The input exceeds the character limit of job profile name";
    }
}
//handling file also
// if (
//     !empty($_POST['update_job_profile_name']) &&
//     !empty($_POST['update_job_profile_information']) &&
//     !empty($_POST['updatetechnologies'])&&
//     !empty($_POST['updatetasks'])
//     && isset($_FILES['update_job_profile_pic'])
// ) {
//     $UpdateJobPic = $_FILES['job_profile_pic'];
//     $pic_name=$UpdateJobPic['name'];
//     $pic_path=$UpdateJobPic['tmp_name'];
//     $pic_error=$UpdateJobPic['error'];
//     $destination='../../Images/'.$pic_name; 
//     move_uploaded_file($pic_path,$destination);
//     $update_job_profile_name = mysqli_real_escape_string($con, $_POST['update_job_profile_name']);
//     $update_job_profile_information = mysqli_real_escape_string($con, $_POST['update_job_profile_information']);
//     $updatetechnologiesArray =json_decode($_POST['updatetechnologies'],true);
//     $updatetasksArray =json_decode($_POST['updatetasks'],true);
//     $currentdate = date('Y-m-d');
//     //getting data for updation
//     $get_job_tasks="SELECT * from `job_tasks` where job_profile_name='$update_job_profile_name' and task<>' ' ";
//     $result_of_job_tasks=mysqli_query($con,$get_job_tasks);
//     $get_job_techs="SELECT * from `job_technologies` where job_profile_name='$update_job_profile_name' and technology<>' ' ";
//     $result_of_job_tech=mysqli_query($con,$get_job_techs);
//     $tasks=[];
//     $technologies=[];
//     if(mysqli_num_rows($result_of_job_tasks)){
//         while($task = mysqli_fetch_assoc($result_of_job_tasks)){
//             $tasks[] = $task;
//         }
//     }
//     if(mysqli_num_rows($result_of_job_tech)){
//         while($tech = mysqli_fetch_assoc($result_of_job_tech)){
//             $technologies[] = $tech;
//         }
//     }
//     // update job profile information
//     $qurey_to_update_job_profile_info = "UPDATE `job_profile` set  role='$update_job_profile_information',update_date='$currentdate',job_pic='$destination' where job_profile_name='$update_job_profile_name' ";
    
//     if (mysqli_query($con, $qurey_to_update_job_profile_info)) {
//         $job_profile_id = mysqli_insert_id($con); // Get the updated job_profile_id
//         $count=count($technologies);

//         // Loop through and update each technology
//         for($i=0;$i<$count;$i++) {
//         if(isset($updatetechnologiesArray[$i]) && isset($technologies[$i]['technology'])){
//             $updatesanitizedTechnology = mysqli_real_escape_string($con, $updatetechnologiesArray[$i]);
//             $sanitizedTechnology=mysqli_real_escape_string($con,$technologies[$i]['technology']);
//             $update_technology_query = "UPDATE `job_technologies` SET technology='$updatesanitizedTechnology' WHERE job_profile_name='$update_job_profile_name' and technology='$sanitizedTechnology' ";
//             mysqli_query($con, $update_technology_query);
//         }
//         }
//         //code to add data during update
//         if(count($updatetechnologiesArray)>count($technologies)){
//             $data_to_update=count($updatetechnologiesArray)-count($technologies);
//             for($i=count($technologies);$i<count($updatetechnologiesArray);$i++){
//                 $sanitizedTechnology = mysqli_real_escape_string($con, $updatetechnologiesArray[$i]);
//                 $insert_technology_query = "INSERT INTO `job_technologies` (job_profile_name, technology) VALUES ('$update_job_profile_name', '$sanitizedTechnology')";
//                 mysqli_query($con, $insert_technology_query);
//             }
//         }
//         // Loop through and update each task
//         $count1=count($tasks);
//         for($i=0;$i<$count1;$i++) {
//             $updatesanitizedtask = mysqli_real_escape_string($con, $updatetasksArray[$i]);
//             $sanitizedtask=mysqli_real_escape_string($con,$tasks[$i]['task']);
//             $update_task_query = "UPDATE `job_tasks` SET task='$updatesanitizedtask' WHERE job_profile_name='$update_job_profile_name' and task='$sanitizedtask' ";
//             mysqli_query($con, $update_task_query);
//         }
//         if(count($updatetasksArray)>count($tasks)){
//             for($i=count($tasks);$i<count($updatetasksArray);$i++){
//                 $sanitizedTask = mysqli_real_escape_string($con, $updatetasksArray[$i]);
//                 $insert_task_query = "INSERT INTO `job_tasks` (job_profile_name, task) VALUES ('$update_job_profile_name', '$sanitizedTask')";
//                 mysqli_query($con, $insert_task_query);
//             }
             
//         }
//         echo "Job profile data updated";
        
//     } else { 
//         echo(mysqli_error($con));
//         echo "Data Not updated";
//     }
// }
// else{
//     echo("Data not found");
// }

//code to check if question like this already there in database
if(!empty($_POST['question_to_check'])){
    $question_to_check=mysqli_real_escape_string($con,$_POST['question_to_check']);
    $query="SELECT * from `question_answer` where question='$question_to_check' ";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)>0){
        echo('Question already exists');
    }
}

//code to add question in data base
if(!empty($_POST['job_profile_question'])&&
        !empty($_POST['difficulty_level_for_question']) &&
        !empty($_POST['question']) &&
        !empty($_POST['category'])&&
        !empty($_POST['option1'])&&
        !empty($_POST['option2'])&&
        !empty($_POST['option3'])&&
        !empty($_POST['option4'])&&
        !empty($_POST['answer_option'])&&
        !empty($_POST['answer_description'])){
            function generateUniqueID() {
                $id = mt_rand(10000, 69999);
                while (in_array($id, $_SESSION['generated_ids'] ?? [])) {
                    $id = mt_rand(10000, 69999);
                }
                $_SESSION['generated_ids'][] = $id; // Store the generated ID
                return $id;
            }
            
            // Example usage
        $question_id = generateUniqueID();
        $job_profile_question=mysqli_real_escape_string($con,$_POST['job_profile_question']);
        $difficulty_level_for_question=mysqli_real_escape_string($con,$_POST['difficulty_level_for_question']);
        $question=mysqli_real_escape_string($con,$_POST['question']);
        $category=mysqli_real_escape_string($con,$_POST['category']);
        $option1=mysqli_real_escape_string($con,$_POST['option1']);
        $option2=mysqli_real_escape_string($con,$_POST['option2']);
        $option3=mysqli_real_escape_string($con,$_POST['option3']);
        $option4=mysqli_real_escape_string($con,$_POST['option4']);
        $answer_option=mysqli_real_escape_string($con,$_POST['answer_option']);
        $answer_description=mysqli_real_escape_string($con,$_POST['answer_description']);
        if(strlen($answer_option) <= 255){
            if(strlen($option1) <= 255){
                if(strlen($option2) <= 255){
                    if(strlen($option3) <= 255){
                        if(strlen($option4) <= 255){
                            $query_to_inset_question="INSERT into `question_answer` (question_id,difficulty_level,question,category,option_1,option_2,option_3,option_4,answer_option,correct_answer_description,job_profile_name) 
                            values ('$question_id','$difficulty_level_for_question','$question','$category','$option1','$option2','$option3','$option4','$answer_option','$answer_description','$job_profile_question')";
                            $result_of_question_insert=mysqli_query($con,$query_to_inset_question);
                            if(mysqli_affected_rows($con)>0){
                                echo('question inserted successsfully');
                            }
                            else{
                                echo("Error:".mysqli_error($con));
                            }
                        }
                        else{
                            echo "The input exceeds the character limit of option 4"; 
                        }
                    }
                    else{
                        echo "The input exceeds the character limit of option 3";   
                    }
                }
                else{
                    echo "The input exceeds the character limit of option 2"; 
                }
            }
            else{
                echo "The input exceeds the character limit of option 1"; 
            }
        }
        else{
            echo "The input exceeds the character limit of Answer option"; 
        }
}
//code to delete question from database
if (!empty($_POST['question_id_to_delete'])){
    $question_id=mysqli_real_escape_string($con,$_POST['question_id_to_delete']);
    $query_to_delete_questions="DELETE FROM `question_answer` WHERE question_id='$question_id'";
    //$result_of_query_to_delete_question=mysqli_query($con,$query_to_delete_questions);
    if(mysqli_query($con,$query_to_delete_questions)){
        echo ('Question Deleted');
    }
    else{
        echo(mysqli_error($con));
    }
}
//code to get all data related to questions in order to show in update question modal
if (!empty($_POST['question_id_to_update'])&&
    !empty($_POST['dynamic_job_profile'])){
    $selected_question_id=mysqli_real_escape_string($con,$_POST['question_id_to_update']);
    $job_select=mysqli_real_escape_string($con,$_POST['dynamic_job_profile']);
    
    $get_question_info="SELECT * from `question_answer` where question_id='$selected_question_id'";
    // $query_for_skills="SELECT  distinct technology from `job_technologies` where technology<>'' and job_profile_name='$job_profile_for_which_category_to_derived'  ";
    $result_of_question=mysqli_query($con,$get_question_info);
    if(mysqli_num_rows($result_of_question) > 0){
        $Question_Answer = mysqli_fetch_assoc($result_of_question);
        $Questions= [
            'job_profile_name' => $Question_Answer['job_profile_name'],
            'difficulty_level'=> $Question_Answer['difficulty_level'],
            'question' =>$Question_Answer['question'],
            'category' =>$Question_Answer['category'],
            'option_1' =>$Question_Answer['option_1'],
            'option_2' =>$Question_Answer['option_2'],
            'option_3' =>$Question_Answer['option_3'],
            'option_4' =>$Question_Answer['option_4'],
            'answer_option'=>$Question_Answer['answer_option'],
            'answer_description'=>$Question_Answer['correct_answer_description'],
            'job_profiles' => [],
            'skills'=>[],
        ];
        $get_all_jobs="SELECT job_profile_name from `job_profile`";
        $result_of_job_profile=mysqli_query($con,$get_all_jobs);
        if(mysqli_num_rows($result_of_job_profile)){
            while($job = mysqli_fetch_assoc($result_of_job_profile)){
                $Questions['job_profiles'][] = $job;
            }
        }
        echo($job);
        $get_all_skills="SELECT  distinct technology from `job_technologies` where technology<>'' and job_profile_name='$job_select' ";
        $result_of_skills=mysqli_query($con,$get_all_skills);
        if(mysqli_num_rows($result_of_skills)){
            while($skill = mysqli_fetch_assoc($result_of_skills)){
                $Questions['skills'][] = $skill;
            }
        }
        echo json_encode($Questions);
    }
}
//code to update question data
if(!empty($_POST['question_id']) &&
        !empty($_POST['update_job_profile_question'])&&
        !empty($_POST['update_difficulty_level_for_question']) &&
        !empty($_POST['update_question']) &&
        !empty($_POST['update_category'])&&
        !empty($_POST['update_option1'])&&
        !empty($_POST['update_option2'])&&
        !empty($_POST['update_option3'])&&
        !empty($_POST['update_option4'])&&
        !empty($_POST['update_answer_option'])&&
        !empty($_POST['update_answer_description'])){
        $question_id =mysqli_real_escape_string($con,$_POST['question_id']);
        $update_job_profile_question=mysqli_real_escape_string($con,$_POST['update_job_profile_question']);
        $update_difficulty_level_for_question=mysqli_real_escape_string($con,$_POST['update_difficulty_level_for_question']);
        $update_question=mysqli_real_escape_string($con,$_POST['update_question']);
        $update_category=mysqli_real_escape_string($con,$_POST['update_category']);
        $update_option1=mysqli_real_escape_string($con,$_POST['update_option1']);
        $update_option2=mysqli_real_escape_string($con,$_POST['update_option2']);
        $update_option3=mysqli_real_escape_string($con,$_POST['update_option3']);
        $update_option4=mysqli_real_escape_string($con,$_POST['update_option4']);
        $update_answer_option=mysqli_real_escape_string($con,$_POST['update_answer_option']);
        $update_answer_description=mysqli_real_escape_string($con,$_POST['update_answer_description']);
        $query_to_update_question="UPDATE `question_answer` set difficulty_level='$update_difficulty_level_for_question',
        question='$update_question',category='$update_category',option_1='$update_option1',option_2='$update_option2',
        option_3='$update_option3',option_4='$update_option4',answer_option='$update_answer_option',correct_answer_description='$update_answer_description',
        job_profile_name='$update_job_profile_question' where question_id='$question_id'";
        if(mysqli_query($con,$query_to_update_question)){
            echo('question updated successsfully');
        }
        else{
            // echo("Hello");
            echo("Error:".mysqli_error($con));
        }
}
if(!empty($_POST['job_profile_for_which_category_to_derived'])){
    $job_profile_for_which_category_to_derived=mysqli_real_escape_string($con,$_POST['job_profile_for_which_category_to_derived']);
    $query_to_find_skills="SELECT  distinct technology from `job_technologies` where technology<>'' and job_profile_name='$job_profile_for_which_category_to_derived' ";
    $result_of_skills=mysqli_query($con,$query_to_find_skills);
    $skills = [];
    if (mysqli_num_rows($result_of_skills) > 0) {
        while ($row = mysqli_fetch_assoc($result_of_skills)) {
            $skills[] = [
                'technology' => $row['technology'] 
            ];
        }
        echo json_encode($skills);
    } else {
        echo("No Skills");
    }
}
?>