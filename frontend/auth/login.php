<?php 
        include_once './frontend/helpers/session-init.php';
        if($id && $role){
            header('Location: /profile');
        }


        include './frontend/header.php';
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    
</head>
<body class="bg-blue">

    <div class="p-5 mt-5 text-white">
        <?php 
            
            $checkbox = isset($_COOKIE['userinfo']) AND isset($_COOKIE['pwdinfo']) ? true : false;
            $userinfo = $_COOKIE['userinfo'] ?? '';
            $pwdinfo = $_COOKIE['pwdinfo'] ?? '';
        
            if (isset($_SESSION['success'])) {
                echo "<div class='success'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            } 
        ?>


        <h3 class="damion-regular fs-2 text-center">Log in</h3>
        
        <div class="d-flex justify-content-center align-items-center">
            <div class="card mt-3 w-25 p-4 shadow">
                <div class="d-flex justify-content-center align-items-center pt-3 pb-3">

                    <form  class="d-flex flex-column justify-content-center align-items-center quicksand-regular" method="POST" action="../backend/auth.php">
                        <input type="hidden" name="form_type" value="login">


                        <div class="flex justify-content-center">

                        <?php 
                            if( (isset($_SESSION['error']))):
                        ?>
                            <div class="alert alert-danger text-center" style="font-size: 14px;">
                                <?php echo htmlentities($_SESSION['error']);  ?>
                            </div>
                            
                            <?php unset($_SESSION['error']); ?>
                        <?php 
                            endif;
                        ?>
                            <div class="form-outline mb-2" data-mdb-input-init>
                                <label class="form-label" for="input_user">Username / Email</label>
                                <input class="form-control shadow " type="text" name="username" id="input_user" style="font-size: 14px;" value="<?php echo $userinfo ?>" required>  
                            </div>

                            <div class="form-outline mb-2" data-mdb-input-init>
                                <label class="form-label" for="input_pwd">Password</label>

                                <div class="d-flex align-items-center gap-1">
                                    <input class="form-control input-group-3 shadow" type="password" name="pwd" id="input_pwd"  style="font-size: 14px;" value="<?php echo $pwdinfo ?>"  required>
                                    <button class="btn bg-blue text-white shadow" type="button" id="showpwd" >
                                        <i class="bi bi-eye shadow"> </i>
                                    </button>
                                </div>

                            </div>
                        </div>
        
                        <div class="d-flex align-items-center gap-1 mb-2">
                            <input class="checkbox" type="checkbox" name="saveinfo" <?php if ($checkbox === true){echo 'checked'; } ?>>
                            <label for="saveinfo" style="font-size: 15px">Save Login info</label>
                        </div>
            
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <a href="/signup" class="text-blue" style="font-size: 11px;">Create an account ?</a>
                            <a class="text-blue" style="font-size: 10px;">/</a>
                            <a href="/reset-password" class="text-blue" style="font-size: 11px;" class="">Forgot your password ?</a>
                        </div>

                        <input type="submit" value="Login" class="btn bg-blue text-white">
                    </form>

                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        const input_pwd = document.getElementById('input_pwd');
        const showpwd = document.getElementById('showpwd');

        showpwd.onclick = function(){
            input_pwd.type = input_pwd.type === 'password' ? 'text' : 'password';

        }


    </script>
    

</body>
</html>