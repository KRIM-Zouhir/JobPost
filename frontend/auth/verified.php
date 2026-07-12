<?php 
    include './frontend/header.php';
    include './backend/verify.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verified</title>
</head>
<body class="bg-black"> 
    <div class="p-5 mt-5 text-white">

    <?php 
        if(!isset( $_GET['token'])){
            // header("Location: /home");
        }else{
            if(!verify($db)):
    ?>
                <br>
                <a class="text-white no-underline d-flex justify-content-center">
                    <button onclick="<?php resend_token($db); ?>">Resend a new token</button>
                </a>
    <?php 
            else:
    ?>

                <br>
                <a href="/profile" class="text-white no-underline d-flex justify-content-center">
                    <button class="btn btn-dark">Log in</button>
                </a>
    <?php 
            endif;
        }

    
    ?>
    </div>

    
</body>
</html>