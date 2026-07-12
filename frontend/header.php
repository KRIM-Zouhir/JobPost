<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav id="mainNav" class="navbar navbar-expand-lg navbar-dark fixed-top py-3">
    <div class="container px-4 px-lg-5">
        
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


        <a class="navbar-brand fs-2" href="/home">
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
                    <a class="nav-link" href="/jobs">
                        Jobs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/aboutus">
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
                            <a class="nav-link" href="/offers-status">
                                Offers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/presets">
                                Presets
                            </a>
                        </li>


                    <?php 
                        endif;
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">
                            Profile
                        </a>
                    </li>
                <?php 
                    else: 
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">
                            Login
                        </a>
                    </li>
                <?php 
                    endif; 
                ?>



            </ul>

        </div>
        <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.09) 0%, transparent 70%);pointer-events: none;"></div>
    </div>
</nav>



<script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>




</body>
</html>