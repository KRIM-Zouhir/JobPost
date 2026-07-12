<?php 
    include './frontend/header.php';
    include './backend/apply.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
</head>
<body class="bg-black text-white">
    <?php 
        [$id , $role] = sessionstart(); 
        if($id === null && $role === null){
            header('Location: /login');
        }
        // User profile view
        if($role === "admin"):
        $jobID = $_GET['job_id'] ?? null;
    ?>
    <div class="p-5 mt-5">
        <h3>
           <?php echo $jobID ?> Applications 
        </h3>

        <?php 

            $application = get_application_byid($db , $jobID);
            if(empty($application)){ 
                echo "No applications found";
            }else{
                echo $application['id'] . "<br>";
                echo $application['user_id'] . "<br>";
                echo $application['post_id'] . "<br>";
                echo $application['cv_filename'] . "<br>";
                echo $application['cover_note'] . "<br>";
                echo $application['status'] . "<br>";
                echo $application['applied_at'] . "<br>";

                echo "<br>";
                
                if($application['status'] == "accepted"){
                    echo '<input type="submit" value="Accept" disabled>';
                }
                else{
                    echo '<form method="POST" action="../../backend/apply.php" >';
                        echo '<input type="hidden" name="form_type" value="accept">';
                        echo '<input type="hidden" name="id" value="' . $application['id'] . '">';
                        echo '<input type="submit" value="Accept" >';
                    echo '</form>';

                }
                
                if($application['status'] == "pending"){
                    echo '<input type="submit" value="Pending" disabled>';
                }else{
                    echo '<form method="POST" action="../../backend/apply.php" >';
                        echo '<input type="hidden" name="form_type" value="pending">';
                        echo '<input type="hidden" name="id" value="' . $application['id'] . '">';
                        echo '<input type="submit" value="Pending">';
                    echo '</form>';
                }


                if($application['status'] == "rejected"){
                    echo '<input type="submit" value="Deny" disabled>';
                }else{
                    echo '<form method="POST" action="../../backend/apply.php" >';
                        echo '<input type="hidden" name="form_type" value="deny">';
                        echo '<input type="hidden" name="id" value="' . $application['id'] . '">';
                        echo '<input type="submit" value="Deny">';
                    echo '</form>';

                }


            }

           

        
        ?>

    </div>
    <?php endif; ?>
    
</body>
</html>