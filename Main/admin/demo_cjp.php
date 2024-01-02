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
    /* Additional CSS */
    .rounded:hover {
        transform: translateY(-10px); /* Example of a pop-up effect */
        box-shadow: 0 5px 15px rgba(0, 0, 0.3, 0.3); /* Example of a shadow effect */
        background-color: #073763; /* Example of a color change on hover */
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
                $get_job_tasks_info="SELECT * FROM `job_tasks` where job_profile_name='$selectedProfileName' and task<>'' ";
                $get_job_tech_info="SELECT * FROM `job_technologies` where job_profile_name='$selectedProfileName' and technology<>'' ";
                $result_of_job_profile_info = mysqli_query($con,$get_job_profile_info);
                $result_of_job_tasks_info=mysqli_query($con,$get_job_tasks_info);
                $result_of_job_tech_info=mysqli_query($con,$get_job_tech_info);

                if(mysqli_num_rows($result_of_job_profile_info)>0 )
                {
                    while($row_of_query = mysqli_fetch_assoc($result_of_job_profile_info))
                    {
                        ?>
                        <div class="col-lg-6  col-md-6 mb-5" id="infoColumn">
                            <div class="rounded p-3  text-white" style="cursor: pointer; transition: all 0.3s;background-color: #100a4d;">
                                <!-- Your card content -->
                                <h4 class="card-title" style="text-align: center;color:black;background-color:yellow" ><?php echo $row_of_query['job_profile_name']; ?></h4>
                                <p class="card-text">
                                    <span  style="font-size:large;" class="fw-bolder">Description:</span>
                                    <?php echo $row_of_query['role']; ?>
                                </p>
                                <p class="card-text">
                                    <span  style="font-size:large;" class="fw-bolder">Last Update Date:</span>
                                    <?php echo date("d M Y", strtotime($row_of_query['update_date'])); ?>
                                </p>
                                <p class="card-text">
                                <span  style="font-size:large;" class="fw-bolder"> Tasks:</span><br>
                                <ul>
                                <?php
                            if(mysqli_num_rows($result_of_job_tasks_info)>0 )
                            {
                            while($row_of_tasks = mysqli_fetch_assoc($result_of_job_tasks_info))
                            {    
                                ?>
                                        <li><?php echo $row_of_tasks['task']; ?></li>
                            <?php
                                }
                            ?>
                             </ul>
                            </p> 
                            <?php
                            }
                            ?>
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
            <div class="col-lg-5  col-md-6 mb-5" id="imageColumn">
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