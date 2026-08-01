<?php include './frontend/header.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    
</head>
<body class="bg-blue">
    <?php 
        [$id , $role] = sessionstart(); 
        if($id && $role){
            header('Location: /profile');
        }
    ?>
    <div class="p-5 mt-5">

    
    <h3 class="damion-regular text-white text-center fs-2">Sign Up </h3>

        <div class="d-flex justify-content-center align-items-center ">
            <div class="card mt-3 w-25 p-4 shadow">
                    <div class="d-flex justify-content-center align-items-center pt-3 pb-3">

                        <form class="d-flex flex-column justify-content-center quicksand-regular" method="POST" action="../backend/auth.php">
                            <input type="hidden" name="form_type" value="signup"> 

                                <div class="flex justify-content-center">
                                    <div class="form-outline mb-2" data-mdb-input-init>
                                        <label class="form-label" for="input_pwd" style="font-size: 14px;">Username</label>
                                        <input class="form-control shadow" type="text" name="username"  style="font-size: 14px;" pattern="[A-Za-z._]{3,20}" title="3-20 characters: letters, dots, and underscores only" required>
                                    </div>

                                    <div class="form-outline mb-2" data-mdb-input-init>
                                        <label class="form-label" for="input_pwd" style="font-size: 14px;">Email</label>
                                        <input class="form-control shadow" type="text" name="email" style="font-size: 14px;" required>
                                    </div>

                                    <div class="form-outline mb-2" data-mdb-input-init>
                                        <label class="form-label" for="input_pwd" style="font-size: 14px;">Password</label>
                                        <div class="d-flex align-items-center gap-1">
                                            <input class="form-control shadow" type="password" id="input_pwd" name="pwd" style="font-size: 14px;" required>
                                            <button class="btn bg-blue text-white" type="button" id="showpwd">
                                                <i class="bi bi-eye"> </i>
                                            </button> 
                                        </div>
                                    </div>

                                    <div class="form-outline mb-2" data-mdb-input-init>
                                        <label class="form-label" for="input_pwd" style="font-size: 14px;">Confirm password</label>
                                        <div class="d-flex align-items-center gap-1">
                                            <input class="form-control shadow" type="password" id="input_confirmpwd" name="confirmpwd" style="font-size: 14px;" required>
                                            <button class="btn bg-blue text-white" type="button" id="showconfirmpwd">
                                                <i class="bi bi-eye shadow"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                        
                            
                            
                            <a class="text-blue text-center pt-3 pb-3" style="font-size: 11px;" href="/login">You already have an account?</a>
                            
                            <input class="btn bg-blue text-white" type="submit" value="Sign up">
                        </form>

                </div>
            </div>
        </div>
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