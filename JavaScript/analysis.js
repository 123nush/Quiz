$('document').ready(function(){
    var job_profile_view_analysis;
    var view_analysis_user;
    var categoryData=[];
    var myChart; 
    $('#job_profile_view_analysis').on('change',function(e){
        e.preventDefault();
        job_profile_view_analysis=$('#job_profile_view_analysis').val();
        view_analysis_user=$('#username').val();
        console.log(job_profile_view_analysis);
        console.log(view_analysis_user);
        categoryData = [];
        $.ajax({
            type:'POST',
            url:'ajax_work.php',
            data:{
                job_profile_view_analysis: job_profile_view_analysis,
                view_analysis_user: view_analysis_user
            },
            success:function(data){
                if (data == 'Do not analyse!!') {
                    $('#attained_questions').val('No Quiz Performed'); 
                    $('#acheived_score').val('No Quiz Performed');
                    $('#submit_to_see_performance').hide(); // Hide the button
                } else {
                    $('#submit_to_see_performance').show(); // Show the button
                    var dataArray = JSON.parse(data);
                    var scoreQuestionData = dataArray.score_question_data;
                    $('#attained_questions').val(scoreQuestionData.attained_questions);
                    $('#acheived_score').val(scoreQuestionData.acheived_score);
                    var categoryCounts = dataArray.category_counts;
                    
                    // Loop through each category count and display it
                    for (var category in categoryCounts) {
                        if (categoryCounts.hasOwnProperty(category)) {
                            var counts = categoryCounts[category];
                            var categoryInfo = {
                                category: category,
                                Y: counts.Y,
                                N: counts.N,
                                total: counts.total
                            };
                            categoryData.push(categoryInfo); // Push category data to the array
                            $('#analysis_to_do_data').append(`<div>Category: ${category}, Y: ${counts.Y}, N: ${counts.N}, Total: ${counts.total}</div>`);
                        }
                    }
                    $('#analysis_to_do_data').hide();   
                }
            },
            error:function(xhr,status,error){
                // Handle error
            }
        });
        e.preventDefault();
    });
    


    $('#submit_to_see_performance').on('click',function(e){
        e.preventDefault();
       var  job_profile_analysis=$('#job_profile_view_analysis').val();
        var total_question= $('#attained_questions').val();
        var total_score= $('#acheived_score').val();
        // total_question=0;
        // total_score=0;
        e.preventDefault();
        if(job_profile_analysis!=='Select Job Profile'){
            $.ajax({
                type:'POST',
                url:'ajax_work.php',
                data:{
                    job_profile_analysis: job_profile_analysis,
                    total_question: total_question,
                    total_score: total_score,
                    categoryData: categoryData
                },
                success:function(data){
                    console.log(("Received data: "+data));
                    // writing code piechart
                    // console.log(categoryData);
                    console.log(typeof(total_question)+"  "+typeof(total_score));
                    const xValues = [];
                    const yValues = [];
                    const barColors = [];
                    categoryData.forEach(function(category_info) {
                        var y_count = category_info.Y;
                        var n_count = category_info.N;
                        var total_count = category_info.total;
                        var category_name = category_info.category;
                        var percent=Math.round((parseInt(y_count)/parseInt(total_count))*100,2)
                        const randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
                        barColors.push(randomColor);
                        xValues.push(category_name);
                        yValues.push(percent);
                    });
                //    console.log(xValues);
                //    console.log(yValues);
                function drawChart(chartType, xValues, yValues, barColors, title) {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    if (myChart) {
                        myChart.destroy();
                    }
                    myChart = new Chart(ctx, {
                        type: chartType,
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: title
                            }
                        }
                    });
                }
                drawChart('pie', xValues, yValues, barColors, "Skill Wise Performance");
                // making changes to see the data in table form
                $('#analyseModalLabel').html("Hello " + view_analysis_user+ "<pre>" + data + "</pre>");
                $('#analyseModal').modal('show');   
                },
                error:function(xhr,status,error){
                    console.log(error+" "+status);
                }
            });

        }
        else{
            alert("Select Job Profile for which you want to see analysis");
            $('#analyseModal').modal('hide');
        }
        
       
    });
});
