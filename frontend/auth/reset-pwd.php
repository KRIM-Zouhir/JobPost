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
<body class="bg-black">
    <div class="p-5 mt-5 text-white">
        <h3>Reset Password</h3>

        <?php 
            if(isset($_GET['token'])):
                $token = $_GET['token'];
                $fetch = check_token_pwd($db , $token);
                if(!empty($fetch)){
        ?>

                    <form method="POST" action="../../backend/auth.php" id="FormReset">
                        <input type="hidden" name="form_type" value="resetform">
                        <input type="hidden" name="form_token" value="<?php echo $token; ?>">
                        <input type="text" name="newpwd" placeholder="New password">
                        <br>
                        <input type="text" name="newpwd1" placeholder="Rewrite new password">
                        <br>
                        <input type="submit" value="Reset">
                    </form>
        <?php 
                }
                else{
        ?>
                    <form method="POST" action="../../backend/auth.php" id="FormEmail">
                        <input type="hidden" name="form_type" value="emailform">
                        <label for="emailinput">Email</label>
                        <br>
                        <input type="email" name="user_email" id="emailinput" placeholder="Type your email">
                        <br>
                        <input type="submit" value="Reset">
                    </form>
        
        <?php 
                }
            else:
        ?>

                    <form method="POST" action="../../backend/auth.php" id="FormEmail">
                        <input type="hidden" name="form_type" value="emailform">
                        <label for="emailinput">Email</label>
                        <br>
                        <input type="email" name="user_email" id="emailinput" placeholder="Type your email">
                        <br>
                        <input type="submit" value="Reset">
                    </form>

        <?php 
            endif;
        ?>
    
    </div>
</body>
</html>