<?php include './frontend/header.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    
</head>
<body class="bg-black">
    <?php 
        [$id , $role] = sessionstart(); 
        if($id && $role){
            header('Location: /profile');
        }
    ?>
    <div class="p-5 mt-5 text-white">
        <h3>SIGN UP</h3>


        <form method="POST" action="../backend/auth.php">
            <input type="hidden" name="form_type" value="signup"> 


            <input type="text" name="username" placeholder="Username" pattern="[A-Za-z._]{3,20}" title="3-20 characters: letters, dots, and underscores only" required>
            <br>
            <input type="text" name="email" placeholder="Email" required>
            <br>
            <input type="password" id="input_pwd" name="pwd" placeholder="Password" required>
            <button type="button" id="showpwd">
                <i class="bi bi-eye"> </i>
            </button>
            <br>
            <input type="password" id="input_confirmpwd" name="confirmpwd" placeholder="Confirm Password" required>
            <button type="button" id="showconfirmpwd">
                <i class="bi bi-eye"> </i>
            </button>
            
            <br>
            <a href="/login">You already have an account?</a>
            <br><br>
            <input type="submit" value="Sign up">
        </form>
    </div>
    

    <script>

        const input_pwd = document.getElementById('input_pwd');
        const input_confirmpwd = document.getElementById('input_confirmpwd');

        const showpwd = document.getElementById('showpwd');
        const showconfirmpwd = document.getElementById('showconfirmpwd');


        showpwd.onclick = function(){
            input_pwd.type = input_pwd.type === 'password' ? 'text' : 'password';
        }

        showconfirmpwd.onclick = function(){
            input_confirmpwd.type = input_confirmpwd.type === 'password' ? 'text' : 'password';
        }

        function check_pwd(){
            if(input_pwd.value !== input_confirmpwd.value){
                input_confirmpwd.setCustomValidity("Passwords do not match");
            } else {
                input_confirmpwd.setCustomValidity("");
            }
        }
        
        input_pwd.addEventListener('input' , check_pwd);
        input_confirmpwd.addEventListener('input' , check_pwd);
        </script>

</body>
</html>