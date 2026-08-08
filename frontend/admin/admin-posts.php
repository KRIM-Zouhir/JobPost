<?php 
        include './frontend/header.php' ;
        include './backend/connect.php';
        include './backend/post.php';
        include './backend/helper.php';
        include './backend/search.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Posts</title>
</head>
<body class="bg-blue">
    <?php 
        // Check if its user 
        [$id , $role] = sessionstart(); 
        if($id === null && $role === null){
            header('Location: /login');
        }
        if($role === "user"):
            header("Location: /home");

        elseif($role === "admin"):
            $start= 0;
            $rows_per_page = 9;

           
    ?>   

    <div class="p-5 mt-5">

        <div class="d-flex align-items-center justify-content-between mt-3">
            <h3 class="damion-regular text-white fs-2">Admin Posts</h3>
            <form method="GET" action="/admin/admin-posts">
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

            <button type="button" id="BtnNewJob" class="btn bg-white text-blue"><i class="bi bi-plus"></i>New Job</button>

        </div>

        <div class="row g-4 mt-3">
            <?php 
                if(!isset($_GET['search'])){
                    $alljobs = getpost($db , $start, $rows_per_page);
                
                }else{
                    $search_value =  htmlentities($_GET['search']) ?? '';
                    $alljobs  = search_posts($db, '%' . $search_value . '%', $start , $rows_per_page);
                }
                if(!empty($alljobs)){
                    foreach($alljobs as $job){
                        $admin_id = $job['admin_id'];
                ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-jobs h-100 shadow">


                                <div class="card-header mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-title fw-bold">
                                            <?php echo id_to_user($db , $admin_id);?>
                                        <p>
                                        
                                        <div>
                                            <?php 
                                                if($job['is_active'] === "1"){
                                            ?> 
                                                <button class="btn stroke-success fw-bold text-success">
                                                    Active
                                                </button>
                                            <?php 
                                                }else{
                                            ?> 
                                                <button class="btn stroke-danger fw-bold text-danger">
                                                    Not Active
                                                </button>
                                            <?php 
                                                }
                                            ?> 
                                        </div>
                                        
                                    </div>
                                </div>


                                <div class="card-body">
                                    
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
                                    
                                    <p class="card-subtitle mb-1">
                                        <?php echo htmlspecialchars(strtoupper($job['place'])); ?>
                                    </p>
    
                                    <p class="fw-bold">
                                        <?php  echo htmlspecialchars(number_format($job['salary']));  ?> $
                                    </p>
    
                
                                </div>
    
                                <div class="card-footer border-0 d-flex justify-content-left gap-2 mb-2">
                                    <?php 
                                        if($role == "user"):
                                            [$user , $email , $role] = profile_info($db, $id);  
                                    ?>
                                        <a href="/jobs/<?php echo $job['postid'] ?>" >
                                            <button class="btn bg-blue text-white" type="button">
                                                Info / Apply
                                            </button>
                                        </a>
                                    <?php
                                        elseif($role == "admin"):
                                    ?>
                                        <button type="button" class="btn bg-success text-white BtnEditJob"
                                                data-id="<?php echo  htmlentities($job['postid']) ?>"
                                                data-title="<?php echo  htmlentities($job['title']) ?>" 
                                                data-company= "<?php echo  htmlentities($job['company']) ?>" 
                                                data-location= "<?php echo  htmlentities($job['location']) ?>" 
                                                data-type="<?php echo  htmlentities($job['type']) ?>"
                                                data-description="<?php echo  htmlentities($job['description']) ?>"
                                                data-salary="<?php echo  htmlentities($job['salary']) ?>">
                                            Edit Post
                                        </button>
    
    
                                        <button class="btn bg-danger text-white BtnDeleteJob" type="button"
                                                data-id="<?php echo htmlentities($job['postid']) ?>"
                                                data-title="<?php echo htmlentities($job['title']) ?>">
                                            Delete Post
                                        </button>

                                        <a href="/admin/applications/<?php echo $job['postid'] ?>">
                                            <button type="button" class="btn BtnViewAppJob bg-blue text-white"
                                                data-id="<?php htmlentities($job['postid']) ?>"
                                                >
                                                View Applications
                                            </button>
                                        </a>
                                    
                                    <?php 
                                        endif;
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
                
        
                <?php
                    }
                }else{
                ?>
                    <h6 class="quicksand-regular text-white text-center mt-5">
                        No applications found.
                    </h6>
                <?php

                }
            ?>
        </div>
        
        <!-- FORM NEW JOB -->
        <div id="modalOverlay" style="display:none;"></div>
        <div class="d-flex align-items-center justify-content-center" >
            <div class="card p-5 w-25 Form" id="FormNewPost" style="display: none;">

                <button class="btn btn-close" id="btnclose" type="button" aria-label="Close">
                </button>
                
                <form class="d-flex flex-column justify-content-center align-items-center quicksand-regular" method="POST" action="../../backend/post.php" id="FormNewPost">
                    <input type="hidden" name="form_type" value="NewJob"> 
                    <input type="hidden" name="redirect_to" value="/profile"> 

                    <div class="form-outline w-75 mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_title">Job Title</label>
                        <input class="form-control shadow" type="text" name="Title" id="job_title" style="font-size: 14px;" required>  
                    </div>


                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_company">Company Name</label>
                        <input class="form-control shadow" type="text" name="Company" id="job_company" style="font-size: 14px;" required>  
                    </div>


                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_location">Job Location</label>
                        <input class="form-control shadow" type="text" name="Location" id="job_location" style="font-size: 14px;" required>  
                    </div>

                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_desc">Job Description</label>
                        <textarea class="form-control shadow" type="text" name="Description"  rows="5" id="job_desc" style="font-size: 14px;" required></textarea> 
                    </div>
                    
                    <div class="form-outline w-75">
                        <label class="form-label" for="JobType">Job Type</label>
                        <select class="form-select w-75  mb-2 shadow" name="JobType" id="JobType">
                            <option value="full-time">Full Time</option>
                            <option value="part-time">Part Time</option>
                            <option value="temp">Temporary</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>


                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_desc">Job Description</label>
                        <input class="form-control b-5 shadow" type="text" name="Description" id="job_desc" style="font-size: 14px;" required>  
                    </div>


                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_salary">Job Salary</label>
                        <input class="form-control b-5 shadow" type="text" name="Salary" id="job_salary" style="font-size: 14px;" required>  
                    </div>

                    <div class="form-outline w-75">
                        <label class="form-label" for="JobType">Job Place</label>
                        <select class="form-select w-75  mb-2 shadow" name="JobPlace" id="JobPlace">
                            <option value="presential">Presential</option>
                            <option value="telework">Telework</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>

                    <input class="btn bg-blue text-white mt-3" type="submit" value="Create">
                </form>
            </div>
        </div>


        
        <!-- FORM EDIT JOBS -->
        <div id="modalOverlay" style="display:none;"></div>
        <div class="d-flex align-items-center justify-content-center" >
            <div class="card p-5 w-25 Form" id="FormEditJob" style="display:none;">
                <button class="btn btn-close" id="btnclose1" type="button" aria-label="Close">
                </button>
                
                <form class="d-flex flex-column justify-content-center align-items-center quicksand-regular"  method="POST" action="../../backend/post.php">
                    <input type="hidden" name="form_type" value="EditJob"> 
                    <input type="hidden" name="redirect_to" value="/profile"> 
                    <input type="hidden" name="PostId">

                    
                    <div class="form-outline w-75 mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_title">Job Title</label>
                        <input class="form-control shadow" type="text" name="Title" id="job_title" style="font-size: 14px;" required>  
                    </div>


                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_company">Company Name</label>
                        <input class="form-control shadow" type="text" name="Company" id="job_company" style="font-size: 14px;" required>  
                    </div>


                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_location">Job Location</label>
                        <input class="form-control shadow" type="text" name="Location" id="job_location" style="font-size: 14px;" required>  
                    </div>

                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_desc">Job Description</label>
                        <textarea class="form-control shadow" type="text" name="Description"  rows="5" id="job_desc" style="font-size: 14px;" required></textarea> 
                    </div>
                    
                    <div class="form-outline w-75">
                        <label class="form-label" for="JobType">Job Type</label>
                        <select class="form-select w-75  mb-2 shadow" name="JobType" id="JobType">
                            <option value="full-time">Full Time</option>
                            <option value="part-time">Part Time</option>
                            <option value="temp">Temporary</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>


                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="job_salary">Job Salary</label>
                        <input class="form-control b-5 shadow" type="text" name="Salary" id="job_salary" style="font-size: 14px;" required>  
                    </div>

                    <div class="form-outline w-75">
                        <label class="form-label" for="JobType">Job Place</label>
                        <select class="form-select w-75  mb-2 shadow" name="JobPlace" id="JobPlace">
                            <option value="presential">Presential</option>
                            <option value="telework">Telework</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>
                    
                    <input class="btn bg-blue text-white mt-3" type="submit" value="Create">
                </form>
            </div>
        </div>


        

        <!-- FORM CONFIRM DELETE -->
        <div id="modalOverlay" style="display:none;"></div>
        <div class="d-flex align-items-center justify-content-center" >
            <div class="card p-5 w-25 Form" id="FormDeleteJob" style="display: none;">
                <button class="btn btn-close" id="btnclose2" type="button" aria-label="Close">
                </button>
                <form  class="d-flex flex-column justify-content-center align-items-center quicksand-regular" method="POST" action="../../backend/post.php">
                    <input type="hidden" name="form_type" value="DeleteJob"> 
                    <input type="hidden" name="redirect_to" value="/profile"> 
                    <input type="hidden" name="PostId">
                    <input type="hidden" name="PostTitle">

                    
                    <div class="form-outline w-75  mb-2" data-mdb-input-init>
                        <label class="form-label" for="confirm_delete">Type CONFIRM to delete</label>
                        <input class="form-control b-5 shadow" type="text" name="ConfirmDelete" id="confirm_delete" style="font-size: 14px;" required>  
                    </div>

                    <input class="btn bg-blue text-white mt-3" type="submit" value="Delete">
                </form>
            </div>
        </div>

    <!-- Pagination -->
    <div class="bg-blue p-5">
        <?php 
            global $pages;

            if(isset($_GET['page-nr']) && !isset($_GET['search'])){
                $search_value =  $_GET['search'] ?? '';
                $pages = calcul($db , $table = "posts" , $rows_per_page);

                $uri_search = '';
                $uri_page_nr = '/admin/admin-posts?page-nr=';

            }elseif(isset($_GET['search'])){
                $search_value =  $_GET['search'];
                $pages = calcul_search($db, $table="posts", $rows_per_page , "title" , '%' . $search_value . '%');

                $uri_search = '/admin/admin-posts?search=';
                $uri_page_nr = '&page-nr=';

            }else{
                $search_value =  $_GET['search'] ?? '';
                $pages = calcul($db , $table = "posts" , $rows_per_page);

                $uri_search = '';
                $uri_page_nr = '/admin/admin-posts?page-nr=';

            }

        
        ?>
        <div class="text-center">
            <div class="text-white quicksand-regular mb-1">
                <?php
                    if(isset($_GET['page-nr'])){
                        echo $_GET['page-nr'];
                    }else{ 
                        echo "1";
                    }
                ?> / <?php echo $pages;?>
            </div>

            <div class="pagination d-flex align-items-center justify-content-center gap-2">
                <?php if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){?>
                            <a  href="<?php echo $uri_search . $search_value . $uri_page_nr; ?>1"
                                class="btn bg-white text-blue"
                                >First
                            </a>
                <?php  }else{?>
                            <a class="btn bg-white text-blue">
                                First
                            </a>
                <?php } ?>

                <?php if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){?>
                            <a  href="<?php echo $uri_search . $search_value . $uri_page_nr . $_GET['page-nr'] - 1; ?>" 
                                class="btn bg-white text-blue">
                                    <i class="bi bi-caret-left-fill"></i>
                            </a>
                <?php  }else{?>
                            <a class="btn bg-white text-blue">
                                <i class="bi bi-caret-left-fill"></i>
                            </a>
                <?php } ?>

                

                <div class="page-numbers">
                    <?php
                        if(empty($pages)){
                    ?>
                            <a><button class="btn bg-white text-blue" disabled>No pages</button></a>
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
                                <a  href="<?php echo $uri_search . $search_value . $uri_page_nr . $i ?>" 
                                    class="btn stroke-white text-white"><?php echo $i ?>
                                </a>
                <?php
                            }else{
                                if(!empty($pages)){
                ?>
                                <a  href="<?php echo $uri_search . $search_value . $uri_page_nr . $i ?>" 
                                    class="btn bg-white text-blue"><?php echo $i ?>
                                </a>
                <?php  
                        }
                        }}
                        
                ?>
                </div>



                <?php
                    if(!isset($_GET['page-nr'])){
                        if($pages > 1){
                ?>
                            <a  href="<?php echo $uri_search . $search_value . $uri_page_nr; ?>2" 
                                class="btn bg-white text-blue"
                                ><i class="bi bi-caret-right-fill"></i>
                            </a>

                <?php
                        }elseif($pages <= 1 ){ 
                ?>
                            <a class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php   }
                
                    }else{
                        if($_GET['page-nr'] >= $pages){
                ?>
                            <a class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php
                        }else{
                ?>
                        <a  href="<?php echo $uri_search . $search_value . $uri_page_nr . $_GET['page-nr'] + 1 ?>" 
                            class="btn bg-white text-blue"
                            ><i class="bi bi-caret-right-fill"></i>
                        </a>
                <?php
                        }
                ?>
            
                <?php
                    } 
                ?>

                <?php
                    if($pages > 1 ){
                ?>
                    <a  href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $pages;?>"
                        class="btn bg-white text-blue"
                        >Last
                    </a>
                <?php
                    }elseif($pages == 1 OR $_GET['page-nr'] == $pages){
                ?>
                    <a  class="btn bg-white text-blue"
                        >Last
                    </a>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>


    

    <?php 
        else:
            header('Location: /home');
        endif; 
    ?>
        
    <script>
        // Form New Job
        const NewBtnJob = document.getElementById('BtnNewJob');
        const NewFormJob = document.getElementById('FormNewPost');
        const overlay = document.getElementById('modalOverlay');

        if(NewBtnJob){
            NewBtnJob.addEventListener('click' , function(){
                overlay.style.display = NewFormJob.style.display === 'none' ? 'block' : 'none';
                NewFormJob.style.display = NewFormJob.style.display === 'none' ? 'block' : 'none';
            });
        }


        const closebtn = document.getElementById('btnclose');

        closebtn.addEventListener('click', function(){
            overlay.style.display = NewFormJob.style.display === 'block' ? 'none' : 'block';
            NewFormJob.style.display = NewFormJob.style.display === 'block' ? 'none' : 'block';
        })





        // Form Edit Job
        document.addEventListener('click' , function(e){
            if(e.target.classList.contains('BtnEditJob')){
                const jobData={
                    postid: e.target.dataset.id,
                    title: e.target.dataset.title,
                    company: e.target.dataset.company,
                    location: e.target.dataset.location,
                    type: e.target.dataset.type,
                    description: e.target.dataset.description,
                    salary: e.target.dataset.salary
                };

                document.querySelector('#FormEditJob [name="PostId"]').value = jobData.postid;
                document.querySelector('#FormEditJob [name="Title"]').value = jobData.title;
                document.querySelector('#FormEditJob [name="Company"]').value = jobData.company;
                document.querySelector('#FormEditJob [name="Location"]').value = jobData.location;
                document.querySelector('#FormEditJob [name="JobType"]').value = jobData.type;
                document.querySelector('#FormEditJob [name="Description"]').value = jobData.description;
                document.querySelector('#FormEditJob [name="Salary"]').value = jobData.salary;

                const EditFormJob = document.getElementById('FormEditJob');
                const overlay = document.getElementById('modalOverlay');

                overlay.style.display = EditFormJob.style.display === 'none' ? 'block' : 'none';
                EditFormJob.style.display = EditFormJob.style.display === 'none' ? 'block' : 'none';

            }


        });

        const closebtn1 = document.getElementById('btnclose1');
        const EditFormJob = document.getElementById('FormEditJob');

        closebtn1.addEventListener('click', function(){
            overlay.style.display = EditFormJob.style.display === 'block' ? 'none' : 'block';
            EditFormJob.style.display = EditFormJob.style.display === 'block' ? 'none' : 'block';
        })


        // Form Delete Job
        document.addEventListener('click' , function(e) {
            if(e.target.classList.contains('BtnDeleteJob')){
                const JobData = {
                    postid: e.target.dataset.id,
                    postitle: e.target.dataset.title
                };

                document.querySelector('#FormDeleteJob [name="PostId"]').value = JobData.postid;
                document.querySelector('#FormDeleteJob [name="PostTitle"]').value = JobData.postitle;
                
                const DeleteFormJob = document.getElementById('FormDeleteJob');
                overlay.style.display = DeleteFormJob.style.display === 'none' ? 'block' : 'none';
                DeleteFormJob.style.display = DeleteFormJob.style.display === 'none' ? 'block' : 'none';

            
            }
        })


        const closebtn2 = document.getElementById('btnclose2');
        const DeleteFormJob = document.getElementById('FormDeleteJob');

        closebtn2.addEventListener('click', function(){
            overlay.style.display = DeleteFormJob.style.display === 'none' ? 'block' : 'none';
            DeleteFormJob.style.display = DeleteFormJob.style.display === 'none' ? 'block' : 'none';
        })


        

    </script>
    <style>
        #modalOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .Form{
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            max-height: 90vh;
            max-height: 75vh;
            overflow-y: auto;
        }

        .btn-close{
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .card-jobs{
            border: 2px;
            border-radius: 8px;
            transition: border-color 0.2s ease, transform 0.5s ease-in-out ,box-shadow 0.2s ease-in-out;
        }
        .card-jobs:hover{
            border-color: #10367D;
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.5);

        }
    </style>
</body>
</html>

