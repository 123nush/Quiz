$('document').ready(function(){
    var job_profile_from_which_date_retrived;
    var view_history_user;
    $('#job_profile_quiz_view').on('change',function(e){
        e.preventDefault();
        job_profile_from_which_date_retrived=$('#job_profile_quiz_view').val();
        view_history_user=$('#username').val();
        console.log(job_profile_from_which_date_retrived);
        console.log(view_history_user);
        $.ajax({
            type:'POST',
            url:'ajax_work.php',
            data:{job_profile_from_which_date_retrived:job_profile_from_which_date_retrived,view_history_user:view_history_user},
            success:function(data){
                // console.log(data);
                if(data=='No result'){
                    $('#date_of_quiz').append('<option selected>No Quiz Performed</option>');   
                    document.getElementById('submit_to_see_preview').style.display = 'none';//to hide and display the Next button
                }
                else{
                document.getElementById('submit_to_see_preview').style.display = 'block';
                dataArray=JSON.parse(data);
                console.log(typeof(dataArray));
                console.log(typeof(data));
                $('#date_of_quiz').empty(); // To Clear previous options
                $('#date_of_quiz').append('<option selected>Select Date</option>'); 
                dataArray.forEach(function (item) {
                    $('#date_of_quiz').append($('<option>', {
                        value: item.quiz_date,
                        text: item.quiz_date 
                    }));
                });
                }
            },
            error:function(xhr,status,error){
            }
        })
        e.preventDefault();
    })
   $('#submit_to_see_preview').on('click',function(e){
    e.preventDefault();
    $job_profile=$('#job_profile_quiz_view').val();
    $date=$('#date_of_quiz').val();
    $username=$('#username').val();
    window.location.href="../User/all_quiz_history.php?job_profile="+$job_profile+"&date="+$date+"&username="+$username;
    e.preventDefault();
   })
})