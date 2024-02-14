$('document').ready(function(){
    var job_profile_view_analysis;
    var view_analysis_user;
    $('#job_profile_view_analysis').on('change',function(e){
        e.preventDefault();
        job_profile_view_analysis=$('#job_profile_view_analysis').val();
        view_analysis_user=$('#username').val();
        console.log(job_profile_view_analysis);
        console.log(view_analysis_user);
        $.ajax({
            type:'POST',
            url:'ajax_work.php',
            data:{job_profile_view_analysis:job_profile_view_analysis,view_analysis_user:view_analysis_user},
            success:function(data){
                // console.log(data);
                if (data == 'Do not analyse!!') {
                    $('#attained_questions').val('No Quiz Performed'); 
                    $('#acheived_score').val('No Quiz Performed');
                    $('#submit_to_see_performance').hide(); // to hide the button
                } else {
                    $('#submit_to_see_performance').show(); // to show the button
                    var dataArray = JSON.parse(data);
                    // console.log(dataArray);
                    $('#attained_questions').val(dataArray.attained_questions);
                    $('#acheived_score').val(dataArray.acheived_score);
                }
            },
            error:function(xhr,status,error){
            }
        })
        e.preventDefault();
    })
    $('#submit_to_see_performance').on('click',function(e){
        e.preventDefault();
        console.log('I"m clicked');
        job_profile_analysis=$('#job_profile_view_analysis').val();
        total_question= $('#attained_questions').val();
        total_score= $('#acheived_score').val();
        user=$('#username').val();
        e.preventDefault();
        $.ajax({
            type:'POST',
            url:'ajax_work.php',
            data:{job_profile_analysis:job_profile_analysis,
                total_question:total_question,
                total_score:total_score},
            success:function(data){
                console.log(data);
                $('#analyseModalLabel').text("Hello "+user+" your performance for "+job_profile_analysis+" is "+data);
            },
            error:function(xhr,status,error){
            }
        })
        
    })
   
})