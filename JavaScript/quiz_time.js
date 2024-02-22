$('document').ready(function(){
    var difficulty_level_for_quiz;
    var job_profile_name_for_quiz;
    var buttonId;
    $("[id^=take_a_quiz").on('click',function(e){
        e.preventDefault();
        buttonId = $(this).attr('id');
        job_profile_name_for_quiz = buttonId.replace('take_a_quiz', '');
        // $("#getting_job_profile").val(job_profile_name_for_quiz);
        e.preventDefault();
    })
    $('#show_rules_of_quiz').on('click', function(e) {
        e.preventDefault();
        let radios = document.querySelectorAll('input[name="options"]');
        let isChecked = Array.from(radios).some(radio => radio.checked);
        if (!isChecked) {
            alert('Select a difficulty level first');
        } else {
            radios.forEach(radio => {
                if (radio.checked) {
                    difficulty_level_for_quiz=radio.value;
                    // $("#getting_difficulty_level_for_quiz").val(difficulty_level_for_quiz);
                }
            })
            window.location.href = "../User/quiz_page.php?job_profile=" + job_profile_name_for_quiz + "&difficulty=" + difficulty_level_for_quiz;
        };
        e.preventDefault();
    });
    //code to fetch values from URL
    var  urlParams = new URLSearchParams(window.location.search);
    var  jobProfileParam = urlParams.get('job_profile');
    var  difficultyParam = urlParams.get('difficulty');
    if (jobProfileParam && difficultyParam) {
        job_profile_name_for_quiz = jobProfileParam;
        difficulty_level_for_quiz = difficultyParam;
    }
   //code to show questions and option when user clicks start button
    $('#start_quiz').on('click', function(e) {
        e.preventDefault();
        // console.log("Hello Anushka");
        // console.log(job_profile_name_for_quiz);
        // console.log(difficulty_level_for_quiz);
        $('#quiz_job_profile').text("Quiz On "+ job_profile_name_for_quiz+"  ");
        $.ajax({
            type:'POST',
            url:'ajax_work.php',
            data:{job_profile_name_for_quiz:job_profile_name_for_quiz,
                difficulty_level_for_quiz:difficulty_level_for_quiz},
            success:function(data){
                // console.log(data);
                if(data=="Try Again!!!"){
                    $('#quiz_job_profile').text("Quiz On "+ job_profile_name_for_quiz+" Not Available ");
                }
                var parsedData = JSON.parse(data);
                        // console.log(parsedData);
                        var all_question_track=[];
                        var totalCorrect;
                        let countdown; // Declare the countdown variable outside the interval function
                        var userAnswers = [];
                        var currentQuestion = 0;
                        var totalQuestions = parsedData.total; // Assuming parsedData contains questions
                        var attainedQuestions=0;
                        var IncorrectQuestions=0;
                        var questionids=[];
                        console.log(totalQuestions);
                        function displayQuestion() {
                            var quizContainer = document.getElementById('quizContainer');
                            quizContainer.style.display = 'block';
                            var questionDiv = document.getElementById('question');
                            var optionsDiv = document.getElementById('options');
                            var currentQuizData = parsedData.questions[currentQuestion];
                            questionDiv.textContent = currentQuizData.question;
                            optionsDiv.innerHTML = '';
                            //dealing with question id issue
                            // questionids[currentQuestion]=currentQuizData.question_id;
                            // if (questionids.length < totalQuestions) {
                            //     console.log(questionids.length);
                            //     questionids[currentQuestion] =currentQuizData.question_id;
                            // }
                            for (var i = 1; i <= 4; i++) {
                                var optionContainer = document.createElement('div');
                                optionContainer.classList.add('option-container');
                        
                                var optionNumber = document.createElement('span');
                                optionNumber.textContent = i + ". "; // Add numbers before option
                                optionNumber.classList.add('option-number');
                        
                                var optionText = document.createElement('span');
                                optionText.textContent = currentQuizData['option_' + i];
                                optionText.classList.add('option-text');
                        
                                optionContainer.appendChild(optionNumber);
                                optionContainer.appendChild(optionText);
                                optionsDiv.appendChild(optionContainer);
                            }
                            //to keep selected option heighlighted 
                            var selectedOptionIndex = userAnswers[currentQuestion];
                            if (selectedOptionIndex !== undefined && selectedOptionIndex !== '') {
                                var options = document.querySelectorAll('.option-container');
                                options.forEach(function(option) {
                                    var optionNumber = option.querySelector('.option-number').textContent.trim().replace('.', '');
                                    if (optionNumber === selectedOptionIndex) {
                                        option.classList.add('selected');
                                    }
                                });
                            }
                            var options = document.querySelectorAll('.option-container');
                            options.forEach(function(option) {
                                option.addEventListener('click', function(event) {
                                    options.forEach(function(opt) {
                                        opt.classList.remove('selected');
                                    });
                                    event.currentTarget.classList.add('selected');
                                });
                            });
                        
                            var prevButton = document.getElementById('prevButton');
                            var nextButton = document.getElementById('nextButton');
                            var submitButton = document.getElementById('submitButton');
                        
                            if (currentQuestion === 0) {
                                prevButton.style.display = 'none';
                            } else {
                                prevButton.style.display = 'inline-block';
                            }
                        
                            if (currentQuestion === totalQuestions - 1) {
                                nextButton.style.display = 'none';
                                submitButton.style.display = 'inline-block';
                            } else {
                                nextButton.style.display = 'inline-block';
                                submitButton.style.display = 'none';
                            }
                        }
                        function selectOption(event) {
                            var selectedOption = document.querySelector('.option-container.selected');
                            var selectedOptionIndex = selectedOption ? selectedOption.querySelector('.option-number').textContent.trim() : '';
                        
                            if (currentQuestion < totalQuestions) {
                                userAnswers[currentQuestion] = selectedOptionIndex.replace(/\.$/, '');
                                currentQuestion++;
                                if (currentQuestion < totalQuestions) {
                                    displayQuestion();
                                } else {
                                    alert("Done");
                                    submitQuiz(); // Call submitQuiz if the last question is reached
                                }
                            }
                        }
                        function goPrevious() {
                            if (currentQuestion > 0) {
                                currentQuestion--;
                                displayQuestion();
                            }
                        }
                        function showQuizPreview() {
                            $('#quiz_job_profile').text("Preview of Quiz on " + job_profile_name_for_quiz + " ");
                            // document.getElementById('quiz_job_profile').style.background="white";
                            var quizContainer = document.getElementById('quizContainer');
                            quizContainer.style.display = 'none';
                            var quizPreviewSection = document.getElementById('quizPreview');
                            quizPreviewSection.style.display = 'block';
                            var previewQuestionsDiv = document.getElementById('previewQuestions');
                            previewQuestionsDiv.innerHTML = '';
                            var userScoreDiv = document.getElementById('userScore');
                            userScoreDiv.textContent = `Total Score: ${totalCorrect}`;
                            // var resultimage=document.getElementById('result_image');
                            // resultimage.style.display='block';
                            // var score_result_image=document.getElementById('score_result_image');
                            // score_result_image.style.display='block';
                           
                            for (let i = 0; i < totalQuestions; i++) {
                                var currentQuizData = parsedData.questions[i];
                                questionids.push(currentQuizData.question_id);
                                var questionDiv = document.createElement('div');
                                questionDiv.classList.add('preview-question');
                                var questionTitle = document.createElement('h2');
                                questionTitle.textContent = `Question ${i + 1}: ${currentQuizData.question.trim('')}`;
                                questionDiv.appendChild(questionTitle);
                                var correctAnswerIndex = parseInt(currentQuizData.answer_option.trim().match(/\d+/));
                                var userSelectedOption = userAnswers[i];
                                if (!userSelectedOption) {
                                    all_question_track[currentQuizData.question_id]="N";
                                    var noSelectionText = document.createElement('p');
                                    noSelectionText.innerHTML = `<b>Your Answer</b>: You did not select any option`;
                                    noSelectionText.style.color = 'red';
                                    questionDiv.appendChild(noSelectionText);
                                    var correctOption = document.createElement('p');
                                    correctOption.innerHTML = `<b>Correct Option</b>: ${currentQuizData[`option_${correctAnswerIndex}`]}`;
                                    correctOption.style.color = 'green';
                                    questionDiv.appendChild(correctOption);
                                    IncorrectQuestions++;
                                } else {
                                    attainedQuestions++;
                                    for (let j = 1; j <= 4; j++) {
                                        var optionText = currentQuizData[`option_${j}`];
                                        var optionNumber = j;
                                        var optionItem = document.createElement('p');
                                        var correctAnswerColor = 'green'; // Default color for correct answer
                            
                                        if (j === correctAnswerIndex) {
                                            
                                            optionItem.innerHTML = `<b>Correct Option</b>: ${optionText}`;
                                            if (userSelectedOption && parseInt(userSelectedOption) === j) {
                                                optionItem.style.color = 'green'; // User selected the correct option
                                                // console.log(currentQuizData.question_id);
                                                all_question_track[currentQuizData.question_id]="Y";
                                            } else {
                                                all_question_track[currentQuizData.question_id]="N";
                                                optionItem.style.color = 'green'; // Only correct option displayed, others are red
                                            }
                                        } else {
                                            if (userSelectedOption && parseInt(userSelectedOption) === j) {
                                                all_question_track[currentQuizData.question_id]="N";
                                                optionItem.innerHTML = `<b>Your Answer</b>: ${optionText}`;
                                                optionItem.style.color = 'red'; // Incorrect user selection
                                                IncorrectQuestions++;
                                            }
                                        }
                                        questionDiv.appendChild(optionItem);
                                        // console.log("Attained"+attainedQuestions+"  "+"In"+IncorrectQuestions);
                                    }
                                }
                                var correctAnswerDescription = currentQuizData.correct_answer_description.trim('');
                                var answerDescription = document.createElement('p');
                                answerDescription.innerHTML = `<b>Answer Description</b>: ${correctAnswerDescription}`;
                                questionDiv.appendChild(answerDescription);
                                previewQuestionsDiv.appendChild(questionDiv);
                                
                                // console.log(questionids);
                            }
                            // console.log("Track is here:"+ all_question_track[]);
                            for (var key in all_question_track) {
                                console.log("key " + key + " has value " + all_question_track[key]);
                              }
                        }
                         //code to show countdown of time 
                         function startCountdown() {
                            document.getElementById('countdown').style.display = 'block';
                            let duration = 30; // 10 minutes * 60 seconds = 600 seconds
                            const countdownElement = document.getElementById('countdown');
                            // Update the countdown timer every second
                            countdown = setInterval(function() {
                                const minutes = Math.floor(duration / 60);
                                let seconds = duration % 60; 
                                // Display the remaining time
                                countdownElement.innerHTML = `<br><b>Time Remains:</b>${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                                // Decrease the duration by 1 second
                                duration--;  
                                // Stop the countdown when it reaches 0
                                if (duration < 0) {
                                    clearInterval(countdown);
                                    countdownElement.textContent = 'Time is up!';
                                    submitQuiz();
                                }
                            }, 1000);
                            //it will give alert kind of prompt when user refresh
                            // used to prompt users with a confirmation dialog before they leave a page.
                            window.addEventListener('beforeunload', function (e) {
                                e.preventDefault();
                                e.returnValue = ''; // For Chrome compatibility
                            });
                        }
                        function submitQuiz() {
                            clearInterval(countdown);
                            document.getElementById('countdown').style.display = 'none';//to hide countdown
                            totalCorrect = 0;
                            if (userAnswers.length < totalQuestions) {
                                var selectedOption = document.querySelector('.option-container.selected');
                                var selectedOptionIndex = selectedOption ? selectedOption.querySelector('.option-number').textContent.trim() : '';
                                userAnswers[currentQuestion] = selectedOptionIndex.replace(/\.$/, '');
                            }
                            for (var i = 0; i < totalQuestions; i++) {
                                var currentQuizData = parsedData.questions[i];
                                var correctAnswerDescription = currentQuizData.correct_answer_description.split('\n');
                                var correctAnswerIndex = parseInt(currentQuizData.answer_option.trim().match(/\d+/));
                                var userAnswerIndex = parseInt(userAnswers[i]);
                                if (!isNaN(userAnswerIndex) && userAnswerIndex === correctAnswerIndex) {
                                    totalCorrect++;
                                    console.log("Question " + (i + 1) + ": Correct Answer!");
                                } else {
                                    console.log("Question " + (i + 1) + ": Incorrect Answer!");
                                }
                            }
                            // console.log(userAnswers);
                            console.log("Total correct answers: " + totalCorrect);
                            showQuizPreview();
                            var username=$('#username').text();
                            console.log(username);
                            console.log(all_question_track);
                            console.log(questionids);
                            //code to dynamically set attainedQuestion and incorectQuestion information in html
                            var attainedQ=document.getElementById("attainedQ");
                            var incorectQ=document.getElementById("incorrectQ");
                            attainedQ.textContent=`Attained Questions: ${attainedQuestions}`;
                            incorectQ.textContent=`Incorrect Questions: ${IncorrectQuestions}`
                            //code to set data in result as well as quiz, quiz_question table
                            // total=attainedQuestions+IncorrectQuestions
                            $.ajax({
                                type:'POST',
                                url:'ajax_work.php',
                                contentType: 'application/json',
                                data:JSON.stringify({score:totalCorrect,
                                    IncorrectQuestions:IncorrectQuestions,
                                    attainedQuestions:attainedQuestions,
                                    job_profile_name_for_quiz:job_profile_name_for_quiz,
                                    no_of_questions:totalQuestions,
                                    questionids:questionids,
                                    all_question_track:all_question_track,
                                    username_for_quiz:username}),
                                success:function(data){
                                    console.log(data);
                                    console.log("Hii");
                                },
                                error: function(xhr, status, error) {
                                    console.error("AJAX Error: ", error);
                                    console.error("Status: ", status);
                                    console.error("Response Text: ", xhr.responseText);
                                }
                            })
                            
                        }
                        document.getElementById('prevButton').addEventListener('click', goPrevious);
                        document.getElementById('nextButton').addEventListener('click', selectOption);
                        document.getElementById('submitButton').addEventListener('click', submitQuiz);
                        startCountdown();
                        displayQuestion();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
                console.error("Status: ", status);
                console.error("Response Text: ", xhr.responseText);
            }
        })
        
        e.preventDefault();
    });  
})