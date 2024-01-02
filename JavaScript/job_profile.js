$(document).ready(function(){
    var tasksArray;
    var technologiesArray;
    var technologyValue;
    var taskValue ;
    //code for dynamic height of textarea
    $('.auto-resize').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Trigger initial resize for existing content
    $('.auto-resize').each(function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    //code to display job profile modal
    $('#add_job_profile_button').on('click',function(e){
        e.preventDefault();
        $('#new_job_profile_modal').modal('show');
        e.preventDefault();
    })
    //code to dynamically display texbox for each technology and task ⬇️
    $('#more_tech').on('click', function(e) {
            e.preventDefault();
            var newTechnologiesInput = '<input type="text" class="form-control technologies" name="technologies[]">';
            $('#technologiesContainer').append(newTechnologiesInput);
            e.preventDefault();
    });
    
    $('#more_task').on('click', function(e) {
            e.preventDefault();
            var newTasksInput = '<input type="text" class="form-control tasks" name="tasks[]">';
            $('#tasksContainer').append(newTasksInput);
            e.preventDefault();
    });
    //code to see if job profile alredy exists in database
    $('#job_profile_name').on('input',function(){
        var job_profile_name_to_check = $('#job_profile_name').val();
        //console.log(username);
        $.ajax({
            type: 'POST',
            url: 'admin_ajax.php',
            data: {job_profile_name_to_check : job_profile_name_to_check},
            success: function(data) {
                console.log(data);
                if(data=='Job Profile Name already exists')
                {
                    $('#job_profile_nameVerify').text("Job Profile Name Alredy Exists!").css("color", "red");
            $('#job_profile_name').css("border-color","red");
                }
                else{
                    $('#job_profile_nameVerify').text("").css("color", "green");
                    $('#job_profile_name').css("border-color","green");
                }
            },
            error: function() {
                console.log(response.status);
            },
        })
    })
    
    //code to insert new job profile information in database
    $('#submit_info').on('click', function(e) {
        e.preventDefault();
        $job_profile_name=$('#job_profile_name').val();
        $job_profile_information=$('#job_profile_role').val();
        technologiesArray = [];
            $('.technologies').each(function() {
                 technologyValue = $(this).val().trim();
                if (technologyValue !== '') {
                    technologiesArray.push(technologyValue);
                }
            });
        tasksArray = [];
            $('.tasks').each(function() {
                taskValue = $(this).val().trim();
                if (taskValue !== '') {
                    tasksArray.push(taskValue);
                }
            });
    
        console.log(technologiesArray);
        var job_profile_name_to_check=$('#job_profile_nameVerify').text();
        if(job_profile_name_to_check!=='Job Profile Name Alredy Exists!'){
            if($job_profile_information!==''){
            console.log($job_profile_information);
            $.ajax({
                type: 'POST',
                url: 'admin_ajax.php',
                data: {job_profile_name : $job_profile_name,job_profile_information:$job_profile_information,technologies:technologiesArray,tasks:tasksArray},
                success: function(data) {
                    console.log(data);
                    if(data=='Job Profile Data Inserted')
                    {
                        alert("Data Inserted Successfully");
                        window.location.href = '../admin/admin_home.php';
                    }                                 
                    else 
                    {
                        alert("Try again later"+data);
                        window.location.href = '../admin/admin_home.php';

                    }
                },
                error: function() {
                    console.log(response.status);
                },
            })
            }
            else{
                alert("Enter  Job Profile Information");
            }
        }
        else{
            alert("Enter a new Job Profile Name");
        }
        e.preventDefault();
    });
    
//code to delete  job profile data from database
    $('.delete-job-profile').on('click', function(e) {
        e.preventDefault();
        var profileID = $(this).data('profile-id');
        $('#yes_delete_job_profile').data('profile-id', profileID);
        e.preventDefault();
    });

    $('#yes_delete_job_profile').on('click', function(e) {
        e.preventDefault();
        var profileName = $(this).data('profile-id');
        // Perform deletion using AJAX or form submission with profileID as a parameter
        console.log(profileName);
        $.ajax({
            type: 'POST',
            url: 'admin_ajax.php',
            data: {profileName : profileName},
            success: function(data) {
                console.log(data);
                if(data=='Job Profile Data Deleted')
                {
                    alert("Data Deleted Successfully");
                    window.location.href = '../admin/admin_home.php';
                }                              
                else 
                {
                    alert("Try again later"+data);
                    window.location.href = '../admin/admin_home.php';

                }
            },
            error: function() {
                console.log(response.status);
            },

        })
        e.preventDefault();
    });
    //code to show textbox during update
        $('#update_more_tech').on('click', function(e) {
        e.preventDefault();
        var updatenewTechnologiesInput = '<input type="text" class="form-control updatetechnologies" name="updatetechnologies[]">';
        $('#updatetechnologiesContainer').append(updatenewTechnologiesInput);
        e.preventDefault();
        });

        $('#update_more_task').on('click', function(e) {
                e.preventDefault();
                var updatenewTasksInput = '<input type="text" class="form-control updatetasks" name="updatetasks[]">';
                $('#updatetasksContainer').append(updatenewTasksInput);
                e.preventDefault();
        });
    //code to display information to update dynamically
    $('[id^="update_job_profile_info"]').on('click', function(e) {
        e.preventDefault();
        var buttonId = $(this).attr('id');
        var profileNameUpdate = buttonId.replace('update_job_profile_info', '');
        
        $.ajax({
                    type: 'POST',
                    url: 'admin_ajax.php', 
                    data: { profileNameUpdate: profileNameUpdate },
                    // dataType: 'json', 
                    success: function(data) {
                        // console.log(data);
                        var parsedData = JSON.parse(data);
                        // console.log(parsedData);
                        $('#show_job_update').text(parsedData.job_profile_name);
                        $('#update_job_profile_name').val(parsedData.job_profile_name);
                        $('#update_job_profile_role').val(parsedData.role);
                        // Populate tasks container
                        var tasksContainer = $('#updatetasksContainer');
                        tasksContainer.empty(); // Clear previous tasks

                        parsedData.tasks.forEach(function(task) {
                            tasksContainer.append(`<input type="text" class="form-control updatetasks" name="updatetasks[]" value="${task.task}">`);
                            // Use task.task instead of task.task_name
                        });

                        // Populate technologies container
                        var technologiesContainer = $('#updatetechnologiesContainer');
                        technologiesContainer.empty(); // Clear previous technologies

                        parsedData.technologies.forEach(function(tech) {
                            technologiesContainer.append(`<input type="text" class="form-control updatetechnologies" name="updatetechnologies[]" value="${tech.technology}">`);
                            // Use tech.technology instead of tech.technology_name
                        });
                        $('#update_job_profile_modal').modal('show');
                        
                    },
                    error: function(xhr, status, error) {
                        // Handle errors, if any
                        console.error(error);
                    }
                });
                e.preventDefault();
    });
    //code to update job_profile_data
    $('#update_job_profile').on('click',function(e){
        $update_job_profile_name=$('#update_job_profile_name').val();
        $update_job_profile_information=$('#update_job_profile_role').val();
        var updatetechnologiesArray = [];
            $('.updatetechnologies').each(function() {
                var updatetechnologyValue = $(this).val().trim();
                // if (updatetechnologyValue !== '') {
                    updatetechnologiesArray.push(updatetechnologyValue);
                // }
            });
        var updatetasksArray = [];
            $('.updatetasks').each(function() {
                var updatetaskValue = $(this).val().trim();
                // if (updatetaskValue !== '') {
                    updatetasksArray.push(updatetaskValue);
                // }
            });
            console.log(updatetechnologiesArray);
            console.log(updatetasksArray);
            
       $.ajax({
        type:'POST',
        url:'admin_ajax.php',
        data:{update_job_profile_name:$update_job_profile_name,
            update_job_profile_information:$update_job_profile_information,
            updatetechnologies:updatetechnologiesArray,
            updatetasks:updatetasksArray
            },
           
        success:function(data){
            console.log(data);
            if(data=='Job profile data updated'){
                alert("Job Profile Data Updated successfully");
                window.location.href = '../admin/admin_home.php';
            }
            else{
                console.log(data);
                alert("Try again Later");
                window.location.href = '../admin/admin_home.php';

            }

        },
        error:function(xhr,status,error){
            console.log(error);
        }
       })
    })
    //code to show modal of adding new question
    $('#add_question_button').on('click',function(e){
        e.preventDefault();
        $('#new_question_modal').modal('show');
        e.preventDefault();
    })
    //code to avoid repeated questions
    $('#question').on('input',function(){
        var question_to_check = $('#question').val();
        //console.log(username);
        $.ajax({
            type: 'POST',
            url: 'admin_ajax.php',
            data: {question_to_check : question_to_check},
            success: function(data) {
                console.log(data);
                if(data=='Question already exists')
                {
                    $('#questionVerify').text("Seems like question like this already exists!").css("color", "red");
            $('#question').css("border-color","red");
                }
                else{
                    $('#questionVerify').text("").css("color", "green");
                    $('#question').css("border-color","green");
                }
            },
            error: function() {
                console.log(response.status);
            },
        })
    })

    //code to add new question
    $('#submit_question').on('click',function(e){
        e.preventDefault();
        var verify_question=$('#quetionVerify').text();
        var job_profile_question=$('#job_profile_question').val();
        var difficulty_level_for_question=$('#difficulty_level_for_question').val();
        var question=$('#question').val();
        var category=$('#category').val();
        var option1=$('#option1').val();
        var option2=$('#option2').val();
        var option3=$('#option3').val();
        var option4=$('#option4').val();
        var answer_description=$('#answer_description').val();
        console.log(question);
        if(job_profile_question!=='Select Job Profile'){
            if(difficulty_level_for_question!=='Select Difficulty Level'){
                if(verify_question!=='Seems like question like this already exists!'){
                    if(category!==''){
                        if(answer_description!==''){
                            if( option1 !== option2 &&option1 !== option3 &&option1 !== option4 &&option2 !== option3 &&
                                option2 !== option4 &&option3 !== option4 &&option1 !== '' &&option2 !== '' &&option3 !== '' &&
                                option4 !== ''){
                                    $.ajax({
                                        type:'POST',
                                        url:'admin_ajax.php',
                                        data:{job_profile_question:job_profile_question,
                                        difficulty_level_for_question:difficulty_level_for_question,
                                        question:question,
                                        category:category,
                                        option1:option1,
                                        option2:option2,
                                        option3:option3,
                                        option4:option4,
                                        answer_description:answer_description},
                                        success:function(data){
                                            //console.log(data);
                                        if(data=="question inserted successsfully"){
                                            alert("Question Added");
                                            window.location.href = '../admin/admin_home.php';
                                        }
                                        else{
                                            alert("Error:"+data);
                                            window.location.href = '../admin/admin_home.php';
                                        }
                                        },
                                        error: function(xhr, status, error) {
                                            // Handle errors, if any
                                            console.error(error);
                                        }
                                    })

                            }
                            else{
                                alert("Options are repeated or kept empty");
                            }
                        }
                        else{
                            alert('Enter answer description');
                        }
                    }
                    else{
                        alert("Please enter category of question");
                    }
                }
                else{
                    alert("System already contains question like this!!");
                }
            }
            else{
                alert("Select Difficulty Level for question");
            }
        }
        else{
            alert("Select Job Profile for which you want to add question");
        }
        console.log(answer_description);
        console.log(question);
        e.preventDefault();
    })
})