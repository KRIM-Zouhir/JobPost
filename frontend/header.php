<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

    <?php 
        function sessionstart(){
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }
            $id = $_SESSION['user_id'] ?? null;
            $role = $_SESSION['role'] ?? null; 
            return [$id, $role];
        }

        [$id, $role] = sessionstart();
    ?> 

    <nav id="mainNav" class="navbar navbar-expand-lg navbar-dark bg-transparent fixed-top py-3">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand fs-2 damion-regular" href="/home">
                JobPost
            </a>

            <button
                class="navbar-toggler navbar-toggler-right"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive"
                aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navbarResponsive" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">

                    <li class="nav-item">
                        <a class="nav-link fs-6 quicksand-regular" href="/jobs">
                            Jobs
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fs-6 quicksand-regular" href="/aboutus">
                            About
                        </a>
                    </li>

                    <?php 
                        if(isset($_SESSION['user_id'])): 
                    ?>
                        <?php 
                            if($role == "user"):
                        ?>
                            <li class="nav-item">
                                <a class="nav-link fs-6 quicksand-regular" href="/offers-status">
                                    Offers
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-6 quicksand-regular" href="/presets">
                                    Presets
                                </a>
                            </li>


                        <?php 
                            endif;
                        ?>
                        <li class="nav-item">
                            <a class="nav-link fs-6 quicksand-regular" href="/profile">
                                Profile
                            </a>
                        </li>
                    <?php 
                        else: 
                    ?>
                        <li class="nav-item">
                            <a class="nav-link fs-6 quicksand-regular" href="/login">
                                Login
                            </a>
                        </li>
                    <?php 
                        endif; 
                    ?>
                </ul>
            </div>
        </div>
    </nav>




    <script>
            const navbar = document.getElementById('mainNav');

            window.addEventListener('scroll', function () {
                if(window.scrollY > 50){
                    navbar.classList.remove('bg-transparent');
                    navbar.classList.remove('navbar-light');
                    navbar.classList.add('navbar-dark');
                    navbar.classList.add('bg-blue');

                }else{
                    navbar.classList.remove('bg-blue');
                    navbar.classList.add('bg-transparent');
                }
            })
    </script>

    <style>
        #mainNav {
            transition: background-color 1s ease;
            transition: navbar 0.5s ease;
            
        }
        

    </style>    


</body>
</html>