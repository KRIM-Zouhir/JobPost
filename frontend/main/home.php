<?php
    include './frontend/header.php' ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobPost</title>
</head>
<body>
    
    <div id="carouselExampleCaptions" class="carousel slide" style="height: 100dvh;">

        <div class="carousel-inner h-100">
            <div class="carousel-item active h-100 ">
                <img src="../../assets/img/Slide1.webp" class="card-img d-block w-100 h-100 object-fit-cover " alt="...">
                <div class="card-img-overlay bg-black bg-opacity-25"></div>
                <div class="carousel-caption d-none d-md-block quicksand-regular">
                    <h5>JobPost</h5>
                    <p>The only way to find your dream !</p>
                </div>
            </div>

            <div class="carousel-item h-100">
                <img src="../../assets/img/Slide2.webp" class="card-img d-block w-100 h-100 object-fit-cover" alt="...">
                <div class="card-img-overlay bg-black bg-opacity-25"></div>
                <div class="carousel-caption d-none d-md-block quicksand-regular">
                    <h5>JobPost</h5>
                    <p>Your library of offers !</p>
                </div>
            </div>

            <div class="carousel-item  h-100">
                <img src="../../assets/img/Slide3.webp" class="card-img d-block w-100 h-100 object-fit-cover" alt="...">
                <div class="card-img-overlay bg-black bg-opacity-25"></div>
                <div class="carousel-caption d-none d-md-block quicksand-regular">
                    <h5>JobPost</h5>
                    <p>No more staying at home !</p>
                </div>
            </div>  
        </div>
        

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
    </div>



    <div class="d-flex flex-column bg-blue" style="height: 50dvh">
        <div class="text-white">
            <h1 class="text-center mt-6 damion-regular">Where you find your dream !</h1>
            <p class="text-center mt-2 quicksand-regular">Follow your dream !</p>
            <div class="d-flex mt-5 gap-2 justify-content-center">
                <a href="/jobs">
                    <button class="btn btn-lg bg-white text-blue-500 ">Jobs</button>
                </a>
                <a href="/login">
                    <button class="btn btn-lg bg-white text-blue-500">Connect</button>
                </a>
            </div>

        </div>
    </div>



    <div class="bg-gray d-flex flex-column vh-100 p-1">
        <h1 class="text-center text-white damion-regular mt-5 ">Your Guid !</h1>
        <p class="text-center text-white quicksand-regular ">Follow these stream_socket_pair</p>

        <div class="d-flex justify-content-center align-items-start g-5 m-5" style="gap: 10rem;">

            <div class="card" style="width: 22rem;">
                <img src="/assets/img/card1.webp" style="height: 350px; object-fit: cover;" class="card-img-top">
                <div class="card-img-overlay bg-black bg-opacity-25"></div>
                <div class="card-body">
                    <a href="#" class="btn damion-regular fs-5 bg-gray text-white d-flex justify-content-center">Sign Up</a>
                </div>
            </div>

        
            <div class="card" style="width: 22rem; margin-top: 10rem;">
                <img src="/assets/img/card2.webp" style="height: 350px; object-fit: cover;" class="card-img-top">
                <div class="card-img-overlay bg-black bg-opacity-25"></div>
                <div class="card-body">
                    <a href="#" class="btn damion-regular fs-5 bg-gray text-white d-flex justify-content-center">Apply</a>
                </div>
            </div>


            <div class="card" style="width: 22rem;">
                <img src="/assets/img/card3.webp" style="height: 350px; object-fit: cover;" class="card-img-top">
                <div class="card-img-overlay bg-black bg-opacity-25"></div>
                <div class="card-body">
                    <a href="#" class="btn damion-regular fs-5 bg-gray text-white d-flex justify-content-center">Track</a>
                </div>
            </div>

        </div>

    </div> 

    <style>
        #mainNav {
            transition: background-color 0.5s ease;
        }

    </style>
</body>
</html>

<?php 
    include './frontend/footer.php';
?>