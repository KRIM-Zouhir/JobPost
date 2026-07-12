<?php 
        include './frontend/header.php' ;
        include './backend/post.php';
        include './backend/apply.php';
        include './backend/search.php';

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
</head>
<body class="bg-black">
    <?php 
        $start= 0;
        $rows_per_page = 10;
        $alljobs = getpost($db , $start, $rows_per_page);
        $post_ids = user_applied($db, $id);
        
        
    ?>


    <div class="p-5 mt-5 text-white"> 

        <h3>JOBS</h3>
        <form method="GET" action="/jobs" id="FormSearch">
            <input type="text" name="search" value="<?php if(isset($_GET['search'])){ echo $_GET['search'];} ?>" placeholder="Type ...">
            <input type="submit" id="BtnSearch" value="Search">
        </form>
        <br><br>

        <?php 

            if(!isset($_GET['search'])){
                if(empty($alljobs)) {echo "No jobs offers";} 
                else{
                    foreach($alljobs as $job){
                        $post_id = $job['postid'];
                        echo $job['title'] . "<br>";
                        echo $job['company'] . "<br>";
                        echo $job['location'] . "<br>";
                        echo $job['type'] . "<br>";
                        echo $job['description'] . "<br>";
                        echo $job['salary'] . "<br>";

                        $alr_applied = false;
                        if($post_ids){
                            foreach($post_ids as $postid){
                                $postid = $postid['post_id'];
                                if($postid == $post_id){
                                    $alr_applied = true;
                                    break;}
                            }
                        }
                        echo '<a href="/jobs/' . $job['postid'] . '"><button type="button" id="InfoButton"> Info </button></a>';
                        if($alr_applied){
                            echo '<button type="button" disabled> Applied </button>';
                        }else{
                            echo '<button type="button" class="BtnApplyJob" data-id="'. $post_id . '"> Apply </button>';
                        }
                        
                        echo "<br><br> ";

                    }   
                }
            }else{
                $search_value =  htmlentities($_GET['search']) ?? '';
                $allsearch  = search_posts($db, '%' . $search_value . '%', $start , $rows_per_page);

                if(empty($allsearch)){echo "No job found !";}
                else{
                    foreach($allsearch as $job){
                        $post_id = $job['postid'];
                        echo $job['title'] . "<br>";
                        echo $job['company'] . "<br>";
                        echo $job['location'] . "<br>";
                        echo $job['type'] . "<br>";
                        echo $job['description'] . "<br>";
                        echo $job['salary'] . "<br>";

                        $alr_applied = false;
                        if($post_ids){
                            foreach($post_ids as $postid){
                                $postid = $postid['post_id'];
                                if($postid == $post_id){
                                    $alr_applied = true;
                                    break;
                                }
                            }
                        }
                        echo '<a href="/jobs/' . $job['postid'] . '"><button type="button" id="InfoButton"> Info </button></a>';
                        if($alr_applied){
                            echo '<button type="button" disabled> Applied </button>';
                        }else{
                            echo '<button type="button" class="BtnApplyJob" data-id="'. $post_id . '"> Apply </button>';
                        }
                        
                        echo "<br><br> ";

                    }

                }


            }
            
            
        ?>
    </div>




    <div class="p-5 text-white">
        <?php 
            if($id && $role){ ?>
                <form method="POST" action="../backend/apply.php" id="FormApplyJob" enctype="multipart/form-data" style="display: none;">
                    <input type="hidden" name="form_type" value="apply">
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





    <!-- Pagination -->

    <?php 
        global $pages;

        if(isset($_GET['page-nr']) && !isset($_GET['search'])){
            $search_value =  $_GET['search'] ?? '';
            $pages = calcul($db , $table = "posts" , $rows_per_page);

            $uri_search = '';
            $uri_page_nr = '/jobs?page-nr=';

        }elseif(isset($_GET['search'])){
            $search_value =  $_GET['search'];
            $pages = calcul_search($db, $table="posts", $rows_per_page , "title" , '%' . $search_value . '%');

            $uri_search = '/jobs?search=';
            $uri_page_nr = '&page-nr=';

        }else{
            $search_value =  $_GET['search'] ?? '';
            $pages = calcul($db , $table = "posts" , $rows_per_page);

            $uri_search = '';
            $uri_page_nr = '/jobs?page-nr=';

        }

    
    ?>
    <div class="text-center">
        <div class="text-white">
            Showing <?php if(isset($_GET['page-nr']))
                        { echo $_GET['page-nr'];}
                        else{ echo "1"; } ?> of <?php echo $pages;?>
        </div>

        <div class="pagination d-flex align-items-center justify-content-center ">
            <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?>1" class="btn btn-dark">First</a>

            <?php if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){?>
                <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $_GET['page-nr'] - 1; ?>" class="btn btn-dark">Previous</a>
            <?php  }else{?>
                <a href="" class="btn btn-dark">Previous</a>
            <?php } ?>

            

            <div class="page-numbers">
                <?php  
                    if(empty($pages)){
                    ?>
                        <a href="">No pages</a>
                <?php 
                    }
                    for($i = 1; $i <= $pages; $i++){
                    ?>
                        <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $i ?>" class="btn btn-dark"><?php echo $i ?></a>
                    <?php  
                    }           
                    ?>
            </div>



            <?php if(!isset($_GET['page-nr'])):
                    if($pages > 1){?>
                        <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?>2" class="btn btn-dark">Next</a>
                    <?php } elseif($pages <= 1 ){ ?>
                        <a href="" class="btn btn-dark">Next</a>
                    <?php } ?>
            <?php else:
                if($_GET['page-nr'] >= $pages):?>
                    <a href="" class="btn btn-dark">Next</a>
                <?php else: ?> 
                    <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $_GET['page-nr'] + 1 ?>" class="btn btn-dark">Next</a>
                <?php endif; ?>
        
            <?php endif; ?>

            
            

            <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $pages;?>" class="btn btn-dark">Last</a>
        </div>
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