<?php 
    include './frontend/header.php';
    include './backend/connect.php';
    include './backend/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body class="bg-blue">
    <div class="p-5 mt-5">
        <h3 class="damion-regular text-white text-center fs-2">Reset Password</h3>

        <?php 
            if(isset($_GET['token'])):
                $token = $_GET['token'];
                $fetch = check_token_pwd($db , $token);


                if(!empty($fetch)){
        ?>
                    <div class="d-flex justify-content-center align-items-center ">
                        <div class="card mt-3 w-25 p-4 shadow">
                            <div class="d-flex justify-content-center align-items-center pt-3 pb-3">

                                <form  class="d-flex flex-column justify-content-center quicksand-regular" method="POST" action="../../backend/auth.php" id="FormReset">
                                    <input type="hidden" name="form_type" value="resetform">
                                    <input type="hidden" name="form_token" value="<?php echo $token; ?>">

                                            
                                    <div class="form-outline pb-3">
                                        <label class="form-label" for="emailinput">New Password</label>
                                        <input class="form-control shadow" type="text" name="newpwd" placeholder="New password">
                                    </div>
                                            
                                    <div class="form-outline pb-3">
                                        <label class="form-label" for="emailinput">Confirm Password</label>
                                        <input class="form-control shadow" type="text" name="newpwd1" placeholder="Rewrite new password">
                                    </div>
                                    <input class="btn bg-blue text-white" type="submit" value="Reset">
                                </form>
                            </div>
                        </div>
                    </div>
        <?php 
                }
                else{
        ?>
                    <div class="d-flex justify-content-center align-items-center ">
                        <div class="card mt-3 w-25 p-4 shadow">
                            <div class="d-flex justify-content-center align-items-center pt-3 pb-3">

                                <form  class="d-flex flex-column justify-content-center quicksand-regular" method="POST" action="../../backend/auth.php" id="FormEmail">
                                    <input type="hidden" name="form_type" value="emailform">


                                    <div class="form-outline pb-3">
                                        <label class="form-label" for="emailinput">Email</label>
                                        <input class="form-control" type="email" name="user_email" id="emailinput" placeholder="Type your email">
                                    </div>
                                    <input class="btn bg-blue text-white" type="submit" value="Reset">
                                </form>
                            </div>
                        </div>
                    </div>
        
        <?php 
                }
            else:
        ?>
            <div class="d-flex justify-content-center align-items-center ">
                <div class="card mt-3 w-25 shadow">
                    <div class="d-flex justify-content-center align-items-center pt-5 pb-5">

                        <form  class="d-flex flex-column justify-content-center w-150 quicksand-regular" method="POST" action="../../backend/auth.php" id="FormEmail">
                            <input type="hidden" name="form_type" value="emailform">

                            <div class="form-outline pb-3">
                                <label class="form-label" for="emailinput">Email</label>
                                <input class="form-control" type="email" name="user_email" id="emailinput" placeholder="Type your email">
                            </div>
                            <input class="btn bg-blue text-white" type="submit" value="Reset">
                        </form>
                    </div>
                </div>
            </div>

        <?php 
            endif;
        ?>

    
    </div>
</body>
</html>