$(document).ready(function(){
    var tasksArray;
    var technologiesArray;
    var technologyValue;
    var taskValue ;
    var job_profile_pic={};
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
                console.log("Received data from AJAX call 1:", data);
                // console.log(data);
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
    //trying different approach for insertion
    $('#submit_info').on('click', function(e) {
        e.preventDefault();
        var job_profile_name = $('#job_profile_name').val();
        var job_profile_information = $('#job_profile_role').val();
        job_profile_pic = [document.getElementById('job_profile_pic').files[0]];
        console.log((job_profile_pic[0]));
        //slight diffrent approach because it is an image and input type is file
        var technologiesArray = [];
        $('.technologies').each(function() {
            technologyValue = $(this).val().trim();
            if (technologyValue !== '') {
                technologiesArray.push(technologyValue);
            }
        });
        var tasksArray = [];
        $('.tasks').each(function() {
            taskValue = $(this).val().trim();
            if (taskValue !== '') {
                tasksArray.push(taskValue);
            }
        });
    
        var job_profile_name_to_check = $('#job_profile_nameVerify').text();
        if(job_profile_name!=='' || job_profile_name.length<255){
        if (job_profile_name_to_check !== 'Job Profile Name Alredy Exists!') {
            if (job_profile_information !== '') {
                if (tasksArray.length !== 0 && technologiesArray.length !== 0) {
                    if (typeof job_profile_pic[0] !== 'undefined') {
                    var formData = new FormData();
                    formData.append('job_profile_name', job_profile_name);
                    formData.append('job_profile_information', job_profile_information);
                    formData.append('technologies', JSON.stringify(technologiesArray));
                    formData.append('tasks', JSON.stringify(tasksArray));
                    formData.append('job_profile_pic', job_profile_pic[0]);
                    $.ajax({
                        type: 'POST',
                        url: 'admin_ajax.php',
                        data: formData,
                        contentType: false,//this is important to handle form with files
                        processData: false,//this is important to handle form with files
                        cache: false,
                        success: function(data) {
                            console.log('Response', data);
                            if (data === 'Job Profile Data Inserted') {
                                alert("Data Inserted Successfully");
                                window.location.href = '../admin/admin_home.php';
                            } else {
                                alert("Try again later  " + data);
                                window.location.href = '../admin/admin_home.php';
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert("Error occurred. Please check the console for details.");
                        },
                    });
                }
                else{
                    alert("Upload a Job profile picture");
                }
                } else {
                    alert("Add at least one skill or one task");
                }
            } else {
                alert("Enter Job Profile Role");
            }
        } else {
            alert("Enter a new Job Profile Name");
        }
        }
        else{
            alert("Job profile name field is empty or exceeds the limit");
        }
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
                // console.log(data);
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
                        console.log(data);
                        var parsedData = JSON.parse(data);
                        // console.log(parsedData);
                        $('#show_job_update').text(parsedData.job_profile_name);
                        $('#update_job_profile_name').val(parsedData.job_profile_name);
                        $('#update_job_profile_role').val(parsedData.role);
                        $('#update_job_profile_pic_name').val(parsedData.photo);
                        // Populate tasks container
                        var tasksContainer = $('#updatetasksContainer');
                        tasksContainer.empty(); // Clear previous tasks
                        parsedData.tasks.forEach(function(task) {
                            tasksContainer.append(`<input type="text" class="form-control updatetasks" name="updatetasks[]" value="${task.task}">`);
                           
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
    // another diff approach
    $('#update_job_profile').on('click',function(e){
        $update_job_profile_name=$('#update_job_profile_name').val();
        $update_job_profile_information=$('#update_job_profile_role').val();
        var updatetechnologiesArray = [];
            $('.updatetechnologies').each(function() {
                var updatetechnologyValue = $(this).val().trim();
                    updatetechnologiesArray.push(updatetechnologyValue);
            });
        var updatetasksArray = [];
            $('.updatetasks').each(function() {
                var updatetaskValue = $(this).val().trim();
                    updatetasksArray.push(updatetaskValue);
            });
            var profile_pic = [document.getElementById('update_job_profile_pic').files[0]];
            if (typeof profile_pic[0] !== 'undefined') {
                console.log(profile_pic[0]);
            
                var formData = new FormData();
                formData.append('update_job_profile_pic', profile_pic[0]);
                formData.append('photo_update_job_profile_name', $update_job_profile_name);
            
                $.ajax({
                    type: 'POST',
                    url: 'admin_ajax.php',
                    data: formData,
                    cache: false,
                    contentType: false, // Set to false to prevent jQuery from messing with the content type
                    processData: false, // Set to false because FormData already encodes the data
                    success: function (data) {
                        console.log(data);
                        if (data === 'Image replace') {
                            // alert('Data Updated successfully');
                            // window.location.href = '../admin/admin_home.php';
                        } else {
                            // alert('Try again Later');
                            // window.location.href = '../admin/admin_home.php';
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    },
                });
            }        
       //calling ajax for rest of the data
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
    $('#job_profile_question').on('change',function(e){
        e.preventDefault();
        job_profile_for_which_category_to_derived=$('#job_profile_question').val();
        console.log(job_profile_for_which_category_to_derived);
        $.ajax({
            type:'POST',
            url:'admin_ajax.php',
            data:{job_profile_for_which_category_to_derived:job_profile_for_which_category_to_derived},
            success:function(data){
                console.log(data);
                if(data=='No Skills'){
                    $('#category').append('<option selected>No Category listed</option>');   
                }
                else{
                dataArray=JSON.parse(data);
                console.log(typeof(dataArray));
                console.log(typeof(data));
                $('#category').empty(); // To Clear previous options
                $('#category').append('<option selected>Select Category</option>'); 
                dataArray.forEach(function (item) {
                    $('#category').append($('<option>', {
                        value: item.technology,
                        text: item.technology 
                    }));
                });
                }
            },
            error:function(xhr,status,error){
            }
        })
        e.preventDefault();
    })


    $('#submit_question').on('click',function(e){
        e.preventDefault();
        var answer_option='';
        var verify_question=$('#quetionVerify').text();
        var job_profile_question=$('#job_profile_question').val();
        var difficulty_level_for_question=$('#difficulty_level_for_question').val();
        var question=$('#question').val();
        var category=$('#category').val();
        var option1=$('#option1').val();
        var option2=$('#option2').val();
        var option3=$('#option3').val();
        var option4=$('#option4').val();
        let radios = document.querySelectorAll('input[name="answer_option"]');
        let isChecked = Array.from(radios).some(radio => radio.checked);
        if (!isChecked) {
            console.log("Select a Correct  Answer's Option first");
        } else {
            radios.forEach(radio => {
                if (radio.checked) {
                    answer_option=radio.value;
                }
            })
        };
        console.log(answer_option);
        // var answer_option=$('#answer_option').val();
        var answer_description=$('#answer_description').val();
        // var number
        // if(answer_option.trim().match(/\d+/)==''){
        //     number=0;
        // }else{
        //     number=parseInt(answer_option.trim().match(/\d+/));
        // } 
        // console.log(number);
        if(job_profile_question!=='Select Job Profile'){
            if(difficulty_level_for_question!=='Select Difficulty Level'){
                if(verify_question!=='Seems like question like this already exists!'){
                    if(category!==''){
                        if(answer_description!==''){
                            if( option1 !== option2 &&option1 !== option3 &&option1 !== option4 &&option2 !== option3 &&
                                option2 !== option4 &&option3 !== option4 &&option1 !== '' &&option2 !== '' &&option3 !== '' &&
                                option4 !== ''){
                                if(answer_option!==''){
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
                                        answer_option:answer_option,
                                        answer_description:answer_description},
                                        success:function(data){
                                            console.log(data);
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
                                    alert("Select a Correct  Answer's Option first");
                                }
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
        e.preventDefault();
    })
})