<!DOCTYPE html>
<html lang="en">
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
    <title>Job Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="image/png" sizes="16x16" rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.8W1AqXk8aZfMEIyeyOwvAwAAAA&pid=Api&P=0&h=180" />
    <style>
    /* For hovering */
    .rounded:hover {
        transform: translateY(-10px); 
        box-shadow: 0 5px 15px rgba(0, 0, 0.3, 0.3); 
    }
    /* For arrow shape containers */
    .arrow-box {
    position: relative;
    padding: 20px;
    margin: 20px 0;
    border: 1px solid #ccc;
    background-color: transparent;
    text-align: center;
    font-weight: bold;
}

.left-arrow {
    clip-path: polygon(0 50%, 10% 0, 100% 0, 100% 100%, 10% 100%);
}

.right-arrow {
    clip-path: polygon(100% 50%, 90% 0, 0 0, 0 100%, 90% 100%);
}
/* for task images */
.circle-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-image: url('../../Images/tasks.png');
    background-size: cover;
    margin-left: 10px; 
}
.parent-container {
            position: relative;
        }

        .go-back-container {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1;
            display: block; /* Show by default */
        }

        .go-back-container img {
            height: 50px;
            width: 50px;
        }

        #infoColumn {
            margin-top: 50px; /* Adjust top margin to create space for the overlapping container */
        }
@media (min-width: 768px) {
            .go-back-container {
                position: static; /* Revert to default flow */
                display: block; /* Hide for larger screens */
            }
            #infoColumn {
                margin-top: 0; /* Remove top margin on larger screens */
            }
        }
</style>
</head>
<body>
<div class="main">
        <div class="row justify-content-center">
            <?php
            require_once('../admin/reduced_navbar.html');
            ?>
            
                <?php
                require_once('../connection/connect.php');
                if (isset($_GET['profile_job'])) {
                $selectedProfileName = $_GET['profile_job'];
                $get_job_profile_info="SELECT * from `job_profile` where job_profile_name='$selectedProfileName'";
                $get_job_tasks_info="SELECT distinct * FROM `job_tasks` where job_profile_name='$selectedProfileName' and task<>'' ";
                $get_job_tech_info="SELECT distinct * FROM `job_technologies` where job_profile_name='$selectedProfileName' and technology<>'' ";
                $result_of_job_profile_info = mysqli_query($con,$get_job_profile_info);
                $result_of_job_tasks_info=mysqli_query($con,$get_job_tasks_info);
                $result_of_job_tech_info=mysqli_query($con,$get_job_tech_info);

                if(mysqli_num_rows($result_of_job_profile_info)>0 )
                {
                    while($row_of_query = mysqli_fetch_assoc($result_of_job_profile_info))
                    {
                        ?>
                        <div class="d-flex justify-content-center parent-container">
                        <div class="go-back-container"><a href="javascript:history.back()"><img src="https://tse3.mm.bing.net/th?id=OIP.3WDg3dO3K_fFvzpULWYoIgHaHa&pid=Api&P=0&h=180" alt="" style="height:50px;width:50px"></a></div>
                        <div class="col-lg-8  col-md-6 mb-5" id="infoColumn">
                            <div class="rounded p-3  text-dark" style="cursor: pointer; transition: all 0.3s;background-color:white">
                                <div style="color:black;background-color:yellow" class="d-flex justify-content-center align-items-center" >
                                    <h4 class="card-title" style="text-align: center;" ><?php echo $row_of_query['job_profile_name']; ?></h4>
                                    <img src="../../Images/database administrator.png" alt="job_profile_related_image" style="height:150px;width:150px" >
                                </div>
                                <p class="card-text">
                                    <span  style="font-size:large;" class="fw-bolder">Description:</span>
                                    <?php echo $row_of_query['role']; ?>
                                </p>
                                <p class="card-text">
                                    <span  style="font-size:large;" class="fw-bolder">Last Update Date:</span>
                                    <?php echo date("d M Y", strtotime($row_of_query['update_date'])); ?>
                                </p>
                                <p class="card-text">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span style="font-size: large;" class="fw-bolder text-center">Tasks</span>
                                    <div class="circle-image"></div>
                                </div>
                                <br>
                                <?php
                                if(mysqli_num_rows($result_of_job_tasks_info) > 0) {
                                    $index = 0;
                                    $backgrounds = [
                                        'linear-gradient(to bottom right, #FFA500, #FF4500)',
                                        'linear-gradient(to bottom right, #ff69b4, #ff0000)',
                                        'linear-gradient(to bottom right, #ba55d3, #da70d6 ,#9932cc,#8a2be2, #9400d3)',
                                        'linear-gradient(to bottom right, #87CEEB, #0000FF)',
                                        'linear-gradient(to bottom right, #ccff66, #54d911)'
                                    ];
                                    while($row_of_tasks = mysqli_fetch_assoc($result_of_job_tasks_info)) {
                                        $background_style = isset($backgrounds[$index]) ? $backgrounds[$index] : $backgrounds[0];
                                        ?>
                                        <div class="arrow-box <?php echo ($index % 2 == 0) ? 'left-arrow' : 'right-arrow'; ?>" style="background: <?php echo $background_style; ?>">
                                            <?php echo $row_of_tasks['task']; ?>
                                        </div>
                                        <?php
                                        $index = ($index + 1) % count($backgrounds);
                                    }
                                }
                                ?>
                                <!-- Now styling skills -->
                            <p class="card-text">
                            <span  style="font-size:large;" class="fw-bolder">Skills Required:</span><br>
                            <ul>
                            <?php
                            if(mysqli_num_rows($result_of_job_tech_info)>0 )
                            {
                            while($row_of_tech = mysqli_fetch_assoc($result_of_job_tech_info))
                            {    
                                ?>
                                       <li><?php echo $row_of_tech['technology']; ?></li> 
                            <?php
                                }
                            ?>
                            </ul>
                            </p>
                            <?php
                            }
                    ?>    
                <?php
                    }
                }
                ?>
                  </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
</div>
<script>
      const imageUrls = [
        "../../Images/register.PNG",
        "../../Images/back.png",
        "../../Images/back3.png",
        "../../Images/back4.png",
        "../../Images/back2.png"
    ];

    // Shuffle the array to randomize the image sequence
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    // Shuffle the image URLs
    const shuffledImages = shuffleArray(imageUrls);

    // Get the reference to the image and information columns
    const imageColumn = document.getElementById('imageColumn');
    const infoColumn = document.getElementById('infoColumn');

    // Function to set the image column's height equal to the info column's height
    function setEqualHeight() {
        const infoHeight = infoColumn.offsetHeight;
        const numImages = shuffledImages.length;
        const imageHeight = infoHeight / numImages;
        
        // Set the height for each image in the column
        shuffledImages.forEach(imageUrl => {
            const img = document.createElement('img');
            img.src = imageUrl;
            img.alt = 'Image';
            img.style.height = `${imageHeight}px`;
            img.style.width = '100%';
            imageColumn.appendChild(img);
        });
    }

    setEqualHeight();
</script>
</body>
</html>
<!-- 
    <div class="row">
    <div class="col-md-6">
        <p class="card-text">
            <span style="font-size:large;" class="fw-bolder">Skills Required:</span><br>
            <ul>
            <?php
            $count = 0; // Initialize counter
            if(mysqli_num_rows($result_of_job_tech_info) > 0)
            {
                while($row_of_tech = mysqli_fetch_assoc($result_of_job_tech_info))
                {
                    // Display skill
                    echo '<li>' . $row_of_tech['technology'] . '</li>';
                    $count++; // Increment counter
                    // Display image after every 4 skills
                    if ($count % 4 == 0) {
                        echo '</ul></p></div><div class="col-md-2 img-fluid"><img src="../../Images/skill1.avif" alt="Image"></div><div class="col-md-6"><p class="card-text"><span style="font-size:large;" class="fw-bolder">Skills Required:</span><br><ul>';
                    }
                }
            }
            ?>
            </ul>
        </p>
    </div>
</div>
 -->