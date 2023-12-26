<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Index Page</title>
    <!-- talwind link -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">

    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
    <!-- <link rel="stylesheet" href="../../Css/landing.css"> -->
    <!-- link for animation  with text-->
  <link href="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/cssanimation.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/cssanimation.min.css">
  <script src="../../JavaScript/animation.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/letteranimation.min.js"></script>
<!-- link for various effects with shape -->
<link rel="stylesheet" href="../../Css/shape.css">
  <!-- <link rel="stylesheet" href="../../Css/style.css"> -->
    <link rel="stylesheet" href="../../Css/tailstyle.css">
    <style>
      /* Media query for mobile */
      @media screen and (max-width: 768px) {
    .bg-image-container {
      background-size: cover;
      height: 50vw; /* Adjust the height for 50% viewport height */
      background-image: url('../../Images/mobile_shape1.PNG');
    }
      }
      .wave-image {
      clip-path: polygon(0 0, 100% 0, 100% 80%, 0 100%);
    }
    </style>
</head>
<body>
  <div class="row">
  

   <div class="col-lg-6 col-md-12 m-auto p-0" style="height: 100vh; overflow: hidden;">
      <!-- <div class="bg-image-container" style="height: 100%; background-image: url('../../Images/trail3.jpg'); background-size: contain; background-position: center; background-repeat: no-repeat;"> -->
        <div class="d-flex align-items-center justify-content-center h-100">
          <h1 style="text-align: center; color: white;">Skill Analysis Quiz</h1>
          <img class="wave-image" src="../../Images/trail3.jpg" alt="">
        </div>
      <!-- </div> -->
    </div> 
    <div class="col-lg-6 col-md-12 d-flex flex-column align-items-center justify-content-center">
      <div id="content-container" class="col-lg-8 col-md-5 d-flex flex-column align-items-center justify-content-center" style="border-radius: 10px; height: 300px; background: linear-gradient(to bottom right, #FFA500, #FF4500);">
        <h1 id="content-heading" class="fs-5 text-center" style="font-weight: bold;">Accessible</h1>
        <div id="heading-image" class="d-flex justify-content-center">
          <img src="https://cdn-icons-png.flaticon.com/128/4662/4662943.png" class="illusion" alt="" style="height: 50px; width: 50px; border-radius: 10px;">
        </div>
        <div id="quiz-content" class="fs-5 text-center">
          <p>Using our quizzes is easy! Just sign up or log in if you're already a user. Pick a quiz category you like, and begin testing what you know. Keep an eye on your progress and score points along the way.</p>
          <div id="login-register-buttons" style="display: none;">
            <button id="loginButton" class="btn btn-primary" onclick="login.php">Login</button>
            <button id="registerButton">Register</button>
          </div>
        </div>
      </div>
      <div class="mt-3">
        <input type="radio" id="content1" name="content" value="Content 1" checked>
        <label for="content1"></label>
        <input type="radio" id="content2" name="content" value="Content 2">
        <label for="content2"></label>
        <input type="radio" id="content3" name="content" value="Content 3">
        <label for="content3"></label>
        <input type="radio" id="content4" name="content" value="Content 4">
        <label for="content4"></label>
        <input type="radio" id="content5" name="content" value="Content 5">
        <label for="content5"></label>
      </div>
    </div>
  </div>

  <script>
    const contents = [
      "Using our quizzes is easy! Just sign up or log in if you're already a user. Pick a quiz category you like, and begin testing what you know. Keep an eye on your progress and score points along the way.",
      "Our quiz website is here for anyone keen on IT jobs. It's interactive, informative, and aimed at boosting your knowledge in this rapidly evolving field.",
      'Discover the most popular IT jobs and learn about the important skills and tasks. Understand why keeping up with new tech is so important for success in the fast-moving IT field.',
      'Explore diverse quiz categories that span IT fields. Test your knowledge in programming languages, cybersecurity, cloud computing, AI, and more! Take on engaging quizzes designed to boost your expertise in these areas.',
      'After each quiz, you\'ll get a full summary of how you did, like your score and how you did overall. Also, we\'d love to hear what you think so we can make our quizzes even better for you.'
    ];
    const headings = ['Accessible', 'Enriching', 'Innovative', 'Diverse', 'Evaluative'];
    const illusions = [
      'https://cdn-icons-png.flaticon.com/128/4662/4662943.png',
      'https://cdn-icons-png.flaticon.com/128/4370/4370748.png',
      'https://t4.ftcdn.net/jpg/06/76/30/81/240_F_676308105_fhU0d5nqdegqNSWJgxsjIpQA8EBlMZn3.jpg',
      'https://cdn-icons-png.flaticon.com/128/5691/5691422.png',
      'https://cdn-icons-png.flaticon.com/128/2782/2782163.png'
    ];
    const backgrounds = [
      'linear-gradient(to bottom right, #FFA500, #FF4500)',
      'linear-gradient(to bottom right, #ff69b4, #ff0000)',
      'linear-gradient(to bottom right, #ba55d3, #da70d6 ,#9932cc,#8a2be2, #9400d3)',
      'linear-gradient(to bottom right, #87CEEB, #0000FF)',
      'linear-gradient(to bottom right, #ccff66, #54d911)'
    ];
    const loginRegisterButtons = document.getElementById('login-register-buttons');
    const contentHeading = document.getElementById('content-heading');
    const headingImage = document.getElementById('heading-image');
    const illusionImage = document.querySelector('.illusion');
    const radios = document.querySelectorAll('input[name="content"]');
    let currentIndex = 0;
    let intervalId;

    function changeContent(index) {
      contentHeading.textContent = headings[index];
      document.getElementById('quiz-content').textContent = contents[index];
      document.getElementById('content-container').style.background = backgrounds[index];
      illusionImage.src = illusions[index];
      if (contents[index] === "Using our quizzes is easy! Just sign up or log in if you're already a user. Pick a quiz category you like, and begin testing what you know. Keep an eye on your progress and score points along the way.") {
        loginRegisterButtons.style.display = 'block';
      } else {
        loginRegisterButtons.style.display = 'none';
      }
    }

    radios.forEach((radio, i) => {
      radio.addEventListener('change', () => {
        clearInterval(intervalId);
        currentIndex = i;
        changeContent(i);
        intervalId = setInterval(() => {
          currentIndex = (currentIndex + 1) % contents.length;
          radios[currentIndex].checked = true;
          changeContent(currentIndex);
        }, 5000);
      });
    });
    intervalId = setInterval(() => {
      currentIndex = (currentIndex + 1) % contents.length;
      radios[currentIndex].checked = true;
      changeContent(currentIndex);
    }, 5000);
  </script>
</body>

</html>

<!-- https://cdn-icons-png.flaticon.com/128/4662/4662943.png(login) 
https://cdn-icons-png.flaticon.com/128/4370/4370748.png(popular)
https://t4.ftcdn.net/jpg/06/76/30/81/240_F_676308105_fhU0d5nqdegqNSWJgxsjIpQA8EBlMZn3.jpg(trending IT jobs)
https://cdn-icons-png.flaticon.com/128/5691/5691422.png(quiz)
https://cdn-icons-png.flaticon.com/128/2782/2782163.png(result and analysis)-->