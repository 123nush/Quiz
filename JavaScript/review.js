$('document').ready(function(){
    $('#more_job_profile').on('click', function(e) {
        e.preventDefault();
        var newSuggestedJobProfile = '<input type="text" class="form-control suggested_job_profile" name="suggested_job_profile[]">';
        $('#suggested_job_profileContainer').append(newSuggestedJobProfile);
        e.preventDefault();
    });
    $('#submit').on('click',function(e){
        e.preventDefault();
        var suggested_job_profileArray = [];
            $('.suggested_job_profile').each(function() {
                 job_profile = $(this).val().trim();
                if (job_profile !== '') {
                    suggested_job_profileArray.push(job_profile);
                }
            });
        // var suggested_job_profile=$('#suggested_job_profile').val();
        var reason_for_job_profile=$('#reason_for_job_profile').val();
        var suggestion_for_system=$('#suggestion_for_system').val();
        var username_review=$('#username').val();
        console.log(suggested_job_profileArray+"\n"+reason_for_job_profile+"\n"+suggestion_for_system+"\n"+username_review);
        if(suggested_job_profileArray.length!==0){
            $.ajax({
                type: 'POST',
                url: 'ajax_work.php',
                data: {
                    suggested_job_profileArray: suggested_job_profileArray,
                    reason_for_job_profile: reason_for_job_profile,
                    suggestion_for_system: suggestion_for_system,
                    username_review: username_review
                },
                success: function (data) {
                    // console.log("Success: " + data);
                    if(data=="Review inserted successfully"){
                        alert("Your Response stored successfully!!");
                        window.location.href="quiz_section.php";
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", error);
                    console.error("Status: ", status);
                    console.error("Response Text: ", xhr.responseText);
                }
            });
            }else{
                alert("suggest job profile on which you like to give quiz");
            }
        e.preventDefault();
    })
})