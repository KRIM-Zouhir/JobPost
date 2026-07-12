<?php include './frontend/header.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    
</head>
<body class="bg-black">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <?php 
        if($id && $role){
            header('Location: /profile');
        }
        
        $checkbox = isset($_COOKIE['userinfo']) AND isset($_COOKIE['pwdinfo']) ? true : false;
        $userinfo = $_COOKIE['userinfo'] ?? '';
        $pwdinfo = $_COOKIE['pwdinfo'] ?? '';
    ?>
    <div class="p-5 mt-5 text-white">
        <h3>LOG IN</h3>
        
        <?php if (isset($_SESSION['success'])) {
            echo "<div class='success'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        } ?>
        <form method="POST" action="../backend/auth.php">
            <br>
            <input type="hidden" name="form_type" value="login"> 

            <input type="text" name="username" placeholder="Username / Email" value="<?php echo $userinfo ?>" required>  
            <br><br>
            <input type="password" name="pwd" id="input_pwd" placeholder="Password" value="<?php echo $pwdinfo ?>" required>
            <button type="button" id="showpwd">
                <i class="bi bi-eye"> </i>
            </button>

            <br><br>


            <input type="checkbox" name="saveinfo" <?php if ($checkbox === true){echo 'checked'; } ?>>
            <label for="saveinfo">Save Login info</label>

            <br>
            <a href="/signup">Create an account ?</a>
            <br>
            <a href="/reset-password">Forgot your password ?</a>
            <br><br>


            <input type="submit" value="Login">
        </form>

    </div>


    <script>

        const input_pwd = document.getElementById('input_pwd');
        const showpwd = document.getElementById('showpwd');

        showpwd.onclick = function(){
            input_pwd.type = input_pwd.type === 'password' ? 'text' : 'password';

        }

        // showpwd.addEventListener('click', function(){
        // })

    </script>
    

</body>
</html>