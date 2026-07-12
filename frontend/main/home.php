<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobPost</title>
</head>
<body>
    <?php include './frontend/header.php' ?>
    <div class="container-fluid p-0 vh-100 d-flex flex-column">
        <div id="carouselExampleIndicators" class="carousel slide h-100" data-bs-ride="carousel">
            
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            
            <div class="carousel-inner h-100">
                
                <div class="carousel-item active">
                    <img src="./assets/img/Slide1.jpg" class="d-block w-100" alt="Slide 1">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);"></div>
                </div>

                <div class="carousel-item">
                    <img src="./assets/img/Slide2.jpg" class="d-block w-100" alt="Slide 2">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);"></div>
                </div>

                <div class="carousel-item">
                    <img src="./assets/img/Slide3.jpg" class="d-block w-100" alt="Slide 3">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);"></div>
                </div>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>




    <div class="container-fluid p-0 vh-100 d-flex flex-column bg-black">
        <div class="bg-black text-white">


        </div>
    </div>
</body>
</html>