<?php 
    include './frontend/header.php';
    include './backend/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
</head>
<body class="bg-black">
    <div class="p-5 mt-5 text-white text-center">
        <h3>Verify using your email !</h3>

        <p>The link in your email will expired in 10 minutes (Check Spam/Bin)</p>
        
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <p id="counter"></p>
        <br>
        <a href="">You didnt receive an email ?</a>
        <br><br>
    </div>
    
</body>
    <script>
        
        let i = 60;
        const intervalId = setInterval(counter, 1000);

        function counter(){
            if(i>=0){
                document.getElementById('counter').innerHTML = i;
                i--;
            }else{
                clearInterval(intervalId);

            }
        }


    </script>
</html>