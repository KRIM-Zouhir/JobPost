
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"  type="image/png"  href="./assets/img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">   
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

</body>
</html>
