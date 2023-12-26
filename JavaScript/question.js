$(document).ready(function(){
    $('.delete-question').on('click', function(e) {
        e.preventDefault();
        var profileID = $(this).data('profile-id');
        $('#yes_delete_quetion').data('profile-id', profileID);
        e.preventDefault();
    });
    var difficulty_level_to_view_questions;
    var job_profile_name_to_see_question;
    var buttonId;
    $("[id^=view_questions").on('click',function(e){
        e.preventDefault();
        buttonId = $(this).attr('id');
        job_profile_name_to_see_question= buttonId.replace('view_questions', '');
        e.preventDefault();
    })
    //code to select difficulty level to see questions
    $('#difficulty_level_selected').on('click', function(e) {
        e.preventDefault();
        let radios = document.querySelectorAll('input[name="options"]');
        let isChecked = Array.from(radios).some(radio => radio.checked);
        if (!isChecked) {
            alert('Select a difficulty level of questions first');
            console.log(job_profile_name_to_see_question);
        } else {
            console.log(job_profile_name_to_see_question);

            radios.forEach(radio => {
                if (radio.checked) {
                    difficulty_level_to_view_questions=radio.value;
                }
            })
            window.location.href = "../admin/view_questions.php?job_profile=" + job_profile_name_to_see_question + "&difficulty=" + difficulty_level_to_view_questions;
        };
        e.preventDefault();
    });
    // code to delete questions
    $('#yes_delete_quetion').on('click', function(e) {
        e.preventDefault();
        var question_id_to_delete = $(this).data('profile-id');
        console.log(question_id_to_delete);
        $.ajax({
            type: 'POST',
            url: 'admin_ajax.php',
            data: {question_id_to_delete : question_id_to_delete},
            success: function(data) {
                console.log(data);
                if(data=='Question Deleted')
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
    //code to display question_answer table data
    $('[id^="update_question_info"]').on('click', function(e) {
        e.preventDefault();
        var buttonId = $(this).attr('id');
        var question_id_to_update = buttonId.replace('update_question_info', '');
        console.log(question_id_to_update);
        $.ajax({
                    type: 'POST',
                    url: 'admin_ajax.php', 
                    data: { question_id_to_update: question_id_to_update },
                    // dataType: 'json', 
                    success: function(data) {
                        console.log(data);
                        var parsedData = JSON.parse(data);
                        var jobProfileSelect = $('#update_job_profile_question');
                        jobProfileSelect.empty(); // Clear existing options

                        // Add a default 'Select Job Profile' option
                        jobProfileSelect.append($('<option></option>')
                            .attr('value', '')
                            .text('Select Job Profile'));

                        // Add retrieved job profiles as options
                        $.each(parsedData.job_profiles, function(index, profile) {
                            jobProfileSelect.append($('<option></option>')
                                .attr('value', profile.job_profile_name)
                                .text(profile.job_profile_name)
                                .prop('selected', profile.job_profile_name === parsedData.job_profile_name));
                        });
                        // console.log(parsedData);
                        $('#question_id').val(question_id_to_update);
                        $('#update_job_profile_question').val(parsedData.job_profile_name);
                        $('#update_difficulty_level_for_question').val(parsedData.difficulty_level);
                        $('#update_question').val(parsedData.question);
                        $('#update_category').val(parsedData.category);
                        $('#update_option1').val(parsedData.option_1);
                        $('#update_option2').val(parsedData.option_2);
                        $('#update_option3').val(parsedData.option_3);
                        $('#update_option4').val(parsedData.option_4);
                        $('#update_answer_description').val(parsedData.answer_description);
                        $('#update_question_modal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        // Handle errors, if any
                        console.error(error);
                    }
                });
                e.preventDefault();
    });
    //code to avoid repeated question
    $('#update_question').on('input',function(){
        var question_to_check = $('#update_question').val();
        //console.log(username);
        $.ajax({
            type: 'POST',
            url: 'admin_ajax.php',
            data: {question_to_check : question_to_check},
            success: function(data) {
                console.log(data);
                if(data=='Question already exists')
                {
                    $('#update_questionVerify').text("Seems like question like this already exists!").css("color", "red");
            $('#update_question').css("border-color","red");
                }
                else{
                    $('#update_questionVerify').text("").css("color", "green");
                    $('#update_question').css("border-color","green");
                }
            },
            error: function() {
                console.log(response.status);
            },
        })
    })
    //code to update question
    $('#update_question_submit').on('click',function(e){
        e.preventDefault();
        console.log("Hello");
        var question_id=$('#question_id').val();
        var update_verify_question=$('#update_quetionVerify').text();
        var update_job_profile_question=$('#update_job_profile_question').val();
        var update_difficulty_level_for_question=$('#update_difficulty_level_for_question').val();
        var update_question=$('#update_question').val();
        var update_category=$('#update_category').val();
        var update_option1=$('#update_option1').val();
        var update_option2=$('#update_option2').val();
        var update_option3=$('#update_option3').val();
        var update_option4=$('#update_option4').val();
        var update_answer_description=$('#update_answer_description').val();
        console.log(update_question);
        if(update_job_profile_question!=='Select Job Profile'){
            if(update_difficulty_level_for_question!=='Select Difficulty Level'){
                if(update_verify_question!=='Seems like question like this already exists!'){
                    if(update_category!==''){
                        if(update_answer_description!==''){
                            if( update_option1 !== update_option2 &&update_option1 !== update_option3 &&update_option1 !== update_option4 &&update_option2 !== update_option3 &&
                                update_option2 !== update_option4 &&update_option3 !== update_option4 &&update_option1 !== '' &&update_option2 !== '' &&update_option3 !== '' &&
                                update_option4 !== ''){
                                    $.ajax({
                                        type:'POST',
                                        url:'admin_ajax.php',
                                        data:{
                                        question_id:question_id,
                                        update_job_profile_question:update_job_profile_question,
                                        update_difficulty_level_for_question:update_difficulty_level_for_question,
                                        update_question:update_question,
                                        update_category:update_category,
                                        update_option1:update_option1,
                                        update_option2:update_option2,
                                        update_option3:update_option3,
                                        update_option4:update_option4,
                                        update_answer_description:update_answer_description},
                                        success:function(data){
                                            //console.log(data);
                                        if(data=="question updated successsfully"){
                                            alert("Question Updated");
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