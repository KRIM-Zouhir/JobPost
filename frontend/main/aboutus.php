<?php include './frontend/header.php' ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
</head>
<body class="bg-blue">

    <div class="bg-blue d-flex flex-column justify-content-center align-items-center" style="padding-top: 10rem;">
        <h3 class="damion-regular fs-2 text-white text-center">About Us</h3>
        <img class="img-logo" src="/assets/img/fulllogo.png" alt="fulllogo">
    </div>

    <div class="container-fluid hero bg-white rounded p-5">
        <h3 class="damion-regular text-blue text-center fs-1">Idea</h3>
        <p class="quicksand-regular text-blue text-center pt-3 fs-3 ">Welcome to JobPost, a platform designed to make finding jobs and hiring talent simpler, faster, and more accessible.
            We believe that connecting the right people with the right opportunities shouldn't be complicated.
            Whether you're looking for your next career move or searching for the perfect candidate,
            JobPost provides a straightforward and reliable place to make those connections.
        </p>
    </div>



    <div class="bg-blue p-5">
        <h3 class="damion-regular text-white text-center fs-1">Our Mission</h3>
        <p class="quicksand-regular text-white text-center pt-3 fs-3 ">
            Our mission is to bridge the gap between employers and
            job seekers by providing an easy-to-use platform where opportunities meet talent.
        </p>

        <div class="d-flex align-items-start justify-content-center gap-5 m-5">  

            <div class="card big-card rounded p-5">
                <h4 class="damion-regular text-center text-blue fs-2">
                    For Employers
                </h4>
                <p class="quicksand-regular text-blue text-left  pt-4" style="font-size: 20px;" >
                    ⪼ Reach qualified candidates<br><br>
                    ⪼ Create and manage job listings<br><br>
                    ⪼ Review applications efficiently<br><br>
                    ⪼ Connect with potential employees in one place<br><br>
                </p>
            </div>


            <div class="card big-card rounded-left p-5">
                <h4 class="damion-regular text-center text-blue fs-2">
                    For Job Seekers
                </h4>
                <p class="quicksand-regular text-blue text-left  pt-4" style="font-size: 20px;" >
                    ⪼ Connect directly with employers<br><br>
                    ⪼ Apply to jobs quickly and easily<br><br>
                    ⪼ Browse job opportunities across different industries<br><br>
                    ⪼ Discover new career opportunities that match your skills<br><br>
                </p>
            </div>


            <div class="card big-card rounded-right p-5">
                <h4 class="damion-regular text-center text-blue fs-2">
                    Why JobPost?
                </h4>
                <p class="quicksand-regular text-blue text-left  pt-4" style="font-size: 20px;" >
                    ⪼ Simple and user-friendly interface<br><br>
                    ⪼ Fast job posting and application process<br><br>
                    ⪼ Secure platform for employers and applicants<br><br>
                    ⪼ Designed to help people connect with confidence<br><br>
                </p>
            </div>

        </div>

    </div>

    <div class="bg-gray" style="padding-bottom: 10rem; padding-top: 5rem;">
        <h3 class="damion-regular text-white text-center fs-1">Our Vision</h3>

        <div class="d-flex justify-content-center align-items-start g-5 pt-5" style="gap: 10rem;">

            <div class="card bg-white" style="width: 22rem;">
                <img src="/assets/img/card4.webp" style="height: 350px; object-fit: cover;" class="card-img-top">
                <div class="card-body bg-white ps-5 pe-5 card-move">
                    <p class="quicksand-regular fs-3 text-gray text-center">Connect People</p>
                    <p class="quicksand-regular card-reveal text-gray text-left m-0 border-0">Bringing talented professionals and employers together through meaningful opportunities.</p>
                    <!-- <a href="#" class="btn damion-regular fs-5 bg-gray text-white d-flex justify-content-center">Sign Up</a> -->
                </div>
            </div>

        
            <div class="card bg-white" style="width: 22rem; margin-top: 10rem;">
                <img src="/assets/img/card5.webp" style="height: 350px; object-fit: cover;" class="card-img-top">
                <!-- <div class="card-img-overlay bg-black bg-opacity-25"></div> -->
                <div class="card-body bg-white ps-5 pe-5 card-move">
                    <p class="quicksand-regular fs-3 text-gray text-center">Empower Careers</p>
                    <p class="quicksand-regular card-reveal text-gray text-left m-0 border-0">Helping job seekers discover roles that match their skills, goals, and ambitions.</p>
                    <!-- <a href="#" class="btn damion-regular fs-5 bg-gray text-white d-flex justify-content-center">Sign Up</a> -->
                </div>
            </div>


            <div class="card bg-white " style="width: 22rem;">
                <img src="/assets/img/card6.webp" style="height: 350px; object-fit: cover;" class="card-img-top">
                <div class="card-body bg-white ps-5 pe-5 card-move">
                    <p class="quicksand-regular fs-3 text-gray text-center">Build the Future</p>
                    <p class="quicksand-regular card-reveal text-gray text-left m-0 border-0">Creating a trusted platform where businesses grow, careers flourish, and lasting professional connections begin.</p>
                    <!-- <a href="#" class="btn damion-regular fs-5 bg-gray text-white d-flex justify-content-center">Sign Up</a> -->
                </div>
            </div>

        </div>
    </div>

    <?php 
        include './frontend/footer.php';
    ?>
    
    <style>
        .img-logo{
            max-width: 600px;
            height: auto;
            transform: translateY(-75px); 

        }

        .big-card {
            width: 600px;
            height: auto;
            transition: transform 0.3s ease-in-out;

        }
        
        .big-card:hover {
            transform: scale(1.03);
        }


        .card {
            overflow: hidden;
        }

        .card-move{
            transition: transform 0.3s ease-in-out;
        }
        .card-reveal{
            opacity: 0;
            max-height: 0;
            overflow: hidden;

            transform: translateY(20px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, max-height 0.3s ease-in-out;
        }

        .card-move:hover {
            transform: translateY(-50px);
        }

        .card:hover .card-reveal{
            opacity: 1;
            max-height: 100px;
            transform: translateY(0px);

        }

        


    </style>
</body>
</html>

