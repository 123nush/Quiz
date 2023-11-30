$(document).ready(function(){
    $('.delete-question').on('click', function(e) {
        e.preventDefault();
        var profileID = $(this).data('profile-id');
        $('#yes_delete_quetion').data('profile-id', profileID);
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
        e.preventDefault();
        $.ajax({
                    type: 'POST',
                    url: 'admin_ajax.php', 
                    data: { question_id_to_update: question_id_to_update },
                    // dataType: 'json', 
                    success: function(data) {
                        // console.log(data);
                        var parsedData = JSON.parse(data);
                        // console.log(parsedData);
                        $('#update_job_profile_question').text(parsedData.job_profile_name);
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
    });
})