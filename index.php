<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"  type="image/png"  href="./assets/img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Damion&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body >
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php 
        
        $routes = []; 


        function route(string $path, callable $callback) {
            global $routes;
            $routes[$path] = $callback;
        }

        function run() {
            global $routes; 
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri = $uri === '' ? '/' : $uri;
            $found = false; 

            foreach($routes as $path => $callback){
                $pattern = '#^' . $path . '$#';
                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches);
                    $callback(...$matches);
                    return;
                }}
            $routes['/404']();

        }
        
        route('/', function(){
            include   './frontend/main/home.php';
        });
        route('/404', function () {
            include './frontend/error-page.php';
        });

        route('/home', function () {
            include './frontend/main/home.php';
        });

        route('/jobs' , function(){
            include './frontend/main/job.php';
        });

        route('/login', function() {
            include './frontend/auth/login.php';
        });
        
        route('/signup' , function(){
            include './frontend/auth/signup.php';
        });
        
        route('/verify-email' , function(){
            include './frontend/auth/verify-email.php';
        });

        route('/verified' , function() {
            include './frontend/auth/verified.php';
            });
            
        route('/profile', function () {
            include './frontend/main/profile.php';
        });

        route('/logout' , function(){
            include './frontend/auth/logout.php';
        });
                
        route('/reset-password', function () {
            include './frontend/auth/reset-pwd.php';
        });

        route('/aboutus' , function() {
            include './frontend/main/aboutus.php';
        });

        route('/offers-status' , function(){
            include './frontend/user/offers-status.php';
        });

        route('/presets' , function(){
            include './frontend/user/presets.php';
        });


        route('/admin/admin-posts' , function() {
            include './frontend/admin/admin-posts.php';
        });

        route('/admin/applications' , function() {
            include './frontend/admin/applications.php';
        });

        route('/admin/users' , function() {
            include './frontend/admin/users.php';
        });

        route('/loading' , function() {
            include './frontend/helpers/loading.php';
        });


        route('/jobs/([0-9]+)', function($id){
            $_GET['job_id'] = $id;
            include './frontend/default/job-default.php';
        } );

        route('/admin/applications/([0-9]+)', function($id){
            $_GET['job_id'] = $id;
            include './frontend/default/app-default.php';
        } );


        run(); 
        

    ?>

    <style>
        .damion-regular {
            font-family: "Damion", cursive;
            font-size: 80px;
            font-weight: 400;
            font-style: normal;
        }
        .quicksand-regular {
            font-family: "Quicksand", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }

        .hero {
            height: 50vh;
        }
        .footer {
            height: 50vh;
        }

        .bg-white {
            background-color: #F4F3F1 !important; /* Bootstrap blue */
        }
        .bg-blue {
            background-color: #10367D !important; /* Bootstrap blue */
        }
        .bg-gray {
            background-color: #111827 !important; /* Bootstrap blue */
        }
        .bg-danger {
            background-color: #b10b0b !important; /* Bootstrap blue */
        }
        .bg-success {
            background-color: #02823c !important; /* Bootstrap blue */
        }
        .bg-light-gray {
            background-color: #535353ff !important; /* Bootstrap blue */
        }
        .text-white{
            color:  #F4F3F1;
        }
        .text-blue{
            color:  #10367D;
        }
        .text-gray{
            color:  #2D2D2D;
        }
        .text-danger{
            color:  #b10b0b;
        }
        .text-success{
            color:  #02823c;
        }
        .text-light-gray {
            color: #535353ff;
        }

        .stroke-white{
            border: 2px solid #F4F3F1;
        }
        .stroke-blue{
            border: 2px solid #10367D;
        }
        .stroke-gray{
            border: 2px solid #2D2D2D;
        }
        .stroke-danger{
            border: 2px solid #b10b0b;
        }
        .stroke-success{
            border: 2px solid #02823c;
        }
        .stroke-light-gray {
            border: 2px solid #535353ff; 
        }

        .mt-6 {
            margin-top: 6rem !important;
        }
        .mt-12 {
            margin-top: 12rem !important;
        }

        .fs-buttons{
            font-size: 18px;
        }

        .links-rm{
            text-decoration: none;
        }

        .search-btn {
            position: absolute;
            top: 50%;
            right: 50px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            padding: 0;
        }
        .clear-btn {
            position: absolute;
            top: 50%;
            right: 5px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            padding: 0;
        }
        .search-btn:hover {
            color: #000;
        }
        
        .search-container {
            position: relative;
        }
        
        .search-input {
            height: 40px;
            width: 600px;
            border-radius: 30px;
            padding-left: 15px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .search-icon {
            height: 13px;
            width: 13px;
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #888;
        }
        
        .search-icon:hover {
            color: #000;
        }

        .clear-icon {
            
            position: absolute;
            top: 50%;
            right: 45px;
            transform: translateY(-50%);
            color: #888;
        }
        
        .clear-icon:hover {
            color: #000;
        }

        
        
        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #2D2D2D;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }
        
        .drop-container:hover,
        .drop-container.drag-active {
            background: #eee;
            border-color: #1d1d1d;
        }
        
        .drop-container:hover .drop-title,
        .drop-container.drag-active .drop-title {
            color: #1d1d1d;
        }
        
        .drop-title {
        color: #2D2D2D;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        transition: color .2s ease-in-out;
        }
        
        input[type=file] {
            width: 350px;
            max-width: 100%;
            color: #2D2D2D;
            padding: 5px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #1d1d1d;
        }
        
        input[type=file]::file-selector-button {
            margin-right: 20px;
            border: none;
            background: #10367D;
            padding: 10px 20px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }
        
        input[type=file]::file-selector-button:hover {
            background: rgb(5, 37, 92);
        }


    </style>

    <script>
        // import { Input, initMDB } from "mdb-ui-kit";

        // initMDB({ Input });

    </script>

</body>
</html>
