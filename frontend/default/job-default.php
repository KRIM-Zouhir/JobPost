<?php  
    include './frontend/header.php' ;
    include './backend/connect.php';  
    include './backend/post.php';
    include './backend/apply.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job</title>
</head>
<body class="bg-black">
    <div class="p-5 mt-5 text-white">
        <?php 
            // [$id , $role] = sessionstart(); 
            $jobID = $_GET['job_id'] ?? null;
            $post_ids = user_applied($db, $id);



            if($jobID){
                $jobinfo = getpsotbyid($db , $jobID);
                if(empty($jobinfo)){
                    header("Location: /404");
                }
                else{
                    $post_id = $jobinfo['id'];
                    echo $jobinfo['title'] . "<br>";
                    echo $jobinfo['company'] . "<br>";
                    echo $jobinfo['location'] . "<br>";
                    echo $jobinfo['type'] . "<br>";
                    echo $jobinfo['description'] . "<br>";
                    echo $jobinfo['salary'] . "<br>";
                }

                $alr_applied = false;
                if($post_ids){
                    foreach($post_ids as $postid){
                        $postid = $postid['post_id'];
                        if($postid == $post_id){
                            $alr_applied = true;
                            break;}
                    }
                }
                if($alr_applied){
                    echo '<button type="button" disabled> Applied </button>';
                }else{
                    echo '<button type="button" class="BtnApplyJob" data-id="'. $post_id . '"> Apply </button>';
                }
            }

        ?>
    </div>

    

    <div class="p-5 text-white">
        <?php 
            if($id && $role){ ?>
                <form method="POST" action="../backend/apply.php" id="FormApplyJob" enctype="multipart/form-data" style="display: none;">
                    <input type="hidden" name="user_id" value="<?php echo $id?>">
                    <input type="hidden" name="postid">
                    
                    <label for="cvfile" >Drop your CV *</label>
                    <br>
                    <input type="file" name="cvfile" required>
                    <br>
                    <label for="coverfile">Drop your Cover letter</label>
                    <br>
                    <input type="file" name="coverfile">
                    <br><br>
                    <input type="submit" name="Apply">

                </form>

        <?php } ?>

        
        <?php     
            if(empty($id) && empty($role)){?>
                <form id="FormLogin" style="display: none;">
                    <h1>Login First then apply</h1>
                    <a href="/login">
                        <button>Login</button>
                    </a>
                </form>
        <?php } ?>
    </div>

    
    <script>

        document.addEventListener('click', function(e){
            if(e.target.classList.contains('BtnApplyJob')){
                const postId = e.target.dataset.id;

                const postidInput = document.querySelector('#FormApplyJob [name="postid"]');
                if(postidInput) postidInput.value = postId;

                const form = document.getElementById('FormApplyJob') || document.getElementById('FormLogin');
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        })


    </script>
    
</body>
</html>