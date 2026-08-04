<?php 
        include './frontend/header.php' ;
        include './backend/post.php';
        include './backend/apply.php';
        include './backend/search.php';
        include_once './frontend/helpers/session-init.php';

        $start= 0;
        $rows_per_page = 9;
        $alljobs = getpost($db , $start, $rows_per_page);
        $post_ids = user_applied($db, $id);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body class="bg-blue">
 

    <div class="bg-blue mt-2 gap-2" style="padding-top: 10rem; padding-right: 5rem; padding-left:5rem; padding-bottom: 5rem;">

        <div class="bg-blue mt-5 text-white d-flex justify-content-between">
            <h3 class="damion-regular fs-2">Jobs</h3>
            <form method="GET" action="/jobs">
                <div class="search-container">
                    <input  type="text" 
                            name="search"
                            id="searchinput"
                            class="form-control search-input" 
                            value="<?php if(isset($_GET['search'])){ echo $_GET['search'];} ?>" 
                            placeholder="Type ...">
                    
                    <button type="button" id="clearbtn" class="clear-btn">
                        <i class="bi bi-eraser-fill clear-icon"></i>
                    </button>

                    <button type="submit" class="search-btn">
                        <i class="fas fa-search search-icon"></i>
                    </button>

                </div>
            </form>
        </div>
    
        <br><br>
    
    
        <div class="row g-4">
            <?php 
    
                if(!isset($_GET['search'])){
                    if(empty($alljobs)) {echo "No jobs offers";} 
                    else{
                        foreach($alljobs as $job){
            ?>
        
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow">
                    
                    <div class="card-body">

                        <?php $post_id = $job['postid'] ?>

                        <h5 class="card-title fw-bold">
                            <?php echo htmlspecialchars($job['title']); ?>
                        </h5>
    
                        <h6 class="card-subtitle mb-1">
                            <?php echo htmlspecialchars($job['company']); ?>
                        </h6>
    
                        <p class="mb-1">
                            <strong>Location:</strong>
                            <?php echo htmlspecialchars($job['location']); ?>
                        </p>
    
                        <p class="mb-1">
                            <strong>Type:</strong>
                            <?php echo htmlspecialchars($job['type']); ?>
                        </p>
    
                        <p class="card-text mb-1">
                            <?php echo htmlspecialchars($job['description']); ?>
                        </p>
    
                        <p class="fw-bold">
                            <?php  echo htmlspecialchars(number_format($job['salary']));  ?> $
                        </p>
    
                    </div>
    
                    <?php
                        $alr_applied = false;
                        if($post_ids){
                            foreach($post_ids as $postid){
                                $postid = $postid['post_id'];
                            
                                if($postid == $post_id){
                                    $alr_applied = true;
                                    break;
                                }
                        }}
                    ?>
    
                    <div class="card-footer border-0 d-flex justify-content-left gap-2 mb-2">
                            <a href="/jobs/<?php echo $job['postid']; ?>" class="btn stroke-blue text-blue">
                                Info
                            </a>
                            <?php if ($alr_applied) { ?>
                                <button class="btn stroke-gray text-gray" disabled>
                                    Applied
                                </button>
                            <?php } else { ?>
                                <button class="btn bg-blue text-white BtnApplyJob"
                                        data-id="<?php echo $post_id; ?>">
                                    Apply
                                </button>
                            <?php } ?>
                    </div>
                </div>  
            </div>
            
            
            <?php  
                        }   
                    }
                }else{
                    $search_value =  htmlentities($_GET['search']) ?? '';
                    $allsearch  = search_posts($db, '%' . $search_value . '%', $start , $rows_per_page);
    
                    if(empty($allsearch)){echo "No job found !";}
                    else{
                        foreach($allsearch as $job){
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow">
                    
                    <div class="card-body">
                        <?php $post_id = $job['postid'] ?>

                        <h5 class="card-title fw-bold">
                            <?php echo htmlspecialchars($job['title']); ?>
                        </h5>
    
                        <h6 class="card-subtitle mb-1">
                            <?php echo htmlspecialchars($job['company']); ?>
                        </h6>
    
                        <p class="mb-1">
                            <strong>Location:</strong>
                            <?php echo htmlspecialchars($job['location']); ?>
                        </p>
    
                        <p class="mb-1">
                            <strong>Type:</strong>
                            <?php echo htmlspecialchars($job['type']); ?>
                        </p>
    
                        <p class="card-text mb-1">
                            <?php echo htmlspecialchars($job['description']); ?>
                        </p>
    
                        <p class="fw-bold">
                            <?php 
                                echo htmlspecialchars(number_format($job['salary'])); 
                            ?> 
                            $
                        </p>
    
                    </div>
    
                    <?php                    
                        $alr_applied = false;
                        if($post_ids){
                            foreach($post_ids as $postid){
                                $postid = $postid['post_id'];
                            
                                if($postid == $post_id){
                                    $alr_applied = true;
                                    break;
                                }
                        }}
                    ?>
    
                    <div class="card-footer border-0 d-flex justify-content-left gap-2 mb-2">
                            <a href="/jobs/<?php echo $job['postid']; ?>" class="btn stroke-blue text-blue">
                                Info
                            </a>
                            <?php if ($alr_applied) { ?>
                                <button class="btn stroke-gray text-gray" disabled>
                                    Applied
                                </button>
                            <?php } else { ?>
                                <button class="btn bg-blue text-white BtnApplyJob"
                                        data-id="<?php echo $post_id; ?>"
                                        data-title="<?php echo $job['title'];?>">
                                    Apply
                                </button>
                            <?php } ?>
                    </div>
                </div>  
            </div>
            <?php 
                }}}
            ?>
                
        </div>

    </div>


    <div id="modalOverlay" style="display: none;"></div>
    <div class=" d-flex align-items-center justify-content-center">
        <div class="card p-5" id="FormApplyJob"  style="display: none;">

            <button class="btn btn-close " id="btnclose" type="button" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            
            <?php 
                if($id && $role){ ?>
                    <form class="d-flex flex-column justify-content-center align-items-center quicksand-regular" method="POST" action="../backend/apply.php" enctype="multipart/form-data">
                        <input type="hidden" name="form_type" value="apply">
                        <input type="hidden" name="user_id" value="<?php echo $id?>">
                        <input type="hidden" name="postid">
                        <input type="hidden" name="post_title">


                        

                        <div class="pb-5">

                            <label for="cvfile" >Drop your CV *</label>
    
                            <label for="images" class="drop-container" id="dropcontainer">
                                <span class="drop-title">Drop files here</span>
                                or
                                <input type="file" id="images"  name="cvfile" required>
                            </label>
                        </div>
                        
                        <div class="pb-5">
                            <label for="coverfile">Drop your Cover letter</label>
    
                            <label for="images" class="drop-container" id="dropcontainer">
                                <span class="drop-title">Drop files here</span>
                                or
                                <input type="file" id="images" name="coverfile">
                            </label>

                        </div>

                        <!-- <input type="file" name="cvfile" required> -->

                        <!-- <label for="coverfile">Drop your Cover letter</label> -->

                        <!-- <input type="file" name="coverfile"> -->

                        <input class="btn bg-blue text-white" type="submit" name="Apply">
    
                    </form>
    
            <?php } ?>
        </div>
    </div>
    

    <div>
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
    <div class="bg-blue p-5">

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
            <div class="text-white quicksand-regular mb-1">
                <?php   if(isset($_GET['page-nr'])){ 
                            echo $_GET['page-nr'];}
                        else{ 
                            echo "1"; } ?> / <?php echo $pages;?>
            </div>

            <div class="pagination d-flex align-items-center justify-content-center gap-2">
                <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?>1" class="btn bg-white text-blue">First</a>

                <?php if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){?>
                    <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $_GET['page-nr'] - 1; ?>" class="btn bg-white text-blue"><i class="bi bi-caret-left-fill"></i></a>
                <?php  }else{?>
                    <a href="" class="btn bg-white  text-blue"><i class="bi bi-caret-left-fill"></i></a>
                <?php } ?>

                

                <div class="page-numbers">
                <?php  
                        if(empty($pages)){
                ?>
                            <a href="">No pages</a>
                <?php 
                        }else{

                            $actual = isset($_GET['page-nr']) ? $_GET['page-nr'] : 1 ;

                            $before = max(1, $actual - 1);
        
                            $next = min($pages, $actual + 1);

                            if($actual == 1) $next = min($pages, 3);
                            if($actual == $pages) $before = max(1, $actual - 2);

                ?>

                <?php
                        }for($i = $before; $i <= $next; $i++){
                            if(isset($_GET['page-nr']) && $i == $_GET['page-nr']){
                ?>
                                <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $i ?>" class="btn stroke-white text-white"><?php echo $i ?></a>
                <?php
                            }else{
                ?>
                            <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $i ?>" class="btn bg-white text-blue"><?php echo $i ?></a>
                <?php  
                            }}      
                ?>
                </div>



                <?php 
                    if(!isset($_GET['page-nr'])){
                        if($pages > 1){?>
                            <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?>2" class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php   }elseif($pages <= 1 ){ ?>
                            <a href="" class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php   }
                
                    }else{
                            if($_GET['page-nr'] >= $pages):?>
                        <a href="" class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php       else: ?> 
                        <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $_GET['page-nr'] + 1 ?>" class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php       endif; ?>
            
                <?php 
                    } ?>

                
                

                <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $pages;?>" class="btn bg-white text-blue">Last</a>
            </div>
        </div>
    </div>


    <?php 
        include './frontend/footer.php';
    ?>
    
    <script>
        const dropContainer = document.getElementById("dropcontainer")
        const fileInput = document.getElementById("images")

        dropContainer.addEventListener("dragover", (e) => {
            // prevent default to allow drop
            e.preventDefault()
        }, false)

        dropContainer.addEventListener("dragenter", () => {
            dropContainer.classList.add("drag-active")
        })

        dropContainer.addEventListener("dragleave", () => {
            dropContainer.classList.remove("drag-active")
        })

        dropContainer.addEventListener("drop", (e) => {
            e.preventDefault()
            dropContainer.classList.remove("drag-active")
            fileInput.files = e.dataTransfer.files
        })
            


        const clearbtn = document.getElementById('clearbtn');
        const overlay = document.getElementById('modalOverlay');

        clearbtn.addEventListener('click', function(){
            document.getElementById('searchinput').value = '';

        })

        document.addEventListener('click', function(e){
            if(e.target.classList.contains('BtnApplyJob')){
                const postId = e.target.dataset.id;
                const posttitle = e.target.dataset.title;

                const postidInput = document.querySelector('#FormApplyJob [name="postid"]');
                if(postidInput) postidInput.value = postId;
                if(posttitleInput) posttitleInput.value = posttitle;
                

                const form = document.getElementById('FormApplyJob') || document.getElementById('FormLogin');
                overlay.style.display = form.style.display === 'none' ? 'block' : 'none';
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        })


        const closebtn = document.getElementById('btnclose');
        const form2 = document.getElementById('FormApplyJob') || document.getElementById('FormLogin');

        closebtn.addEventListener('click', function(){
            overlay.style.display = form2.style.display === 'block' ? 'none' : 'block';
            form2.style.display = form2.style.display === 'block' ? 'none' : 'block';

        })


    </script>

    <style>
        
        #FormApplyJob{
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            max-height: 90vh;
            overflow-y: auto;
        }

        #modalOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .btn-close{
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .card-body:hover{
            color:#000;
        }
        .search-btn {
            position: absolute;
            top: 50%;
            right: 50px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            padding: 0;
        }
        .clear-btn {
            position: absolute;
            top: 50%;
            right: 5px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            padding: 0;
        }
        .search-btn:hover {
            color: #000;
        }
        
        .search-container {
            position: relative;
        }
        
        .search-input {
            height: 40px;
            width: 600px;
            border-radius: 30px;
            padding-left: 15px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .search-icon {
            height: 13px;
            width: 13px;
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #888;
        }
        
        .search-icon:hover {
            color: #000;
        }

        .clear-icon {
            
            position: absolute;
            top: 50%;
            right: 45px;
            transform: translateY(-50%);
            color: #888;
        }
        
        .clear-icon:hover {
            color: #000;
        }
        
        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #2D2D2D;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }
        
        .drop-container:hover,
        .drop-container.drag-active {
            background: #eee;
            border-color: #1d1d1d;
        }
        
        .drop-container:hover .drop-title,
        .drop-container.drag-active .drop-title {
            color: #1d1d1d;
        }
        
        .drop-title {
        color: #2D2D2D;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        transition: color .2s ease-in-out;
        }
        
        input[type=file] {
            width: 350px;
            max-width: 100%;
            color: #2D2D2D;
            padding: 5px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #1d1d1d;
        }
        
        input[type=file]::file-selector-button {
            margin-right: 20px;
            border: none;
            background: #10367D;
            padding: 10px 20px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }
        
        input[type=file]::file-selector-button:hover {
            background: rgb(5, 37, 92);
        }
    </style>

    

</body>
</html>