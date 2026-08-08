<?php 
        include './frontend/header.php' ;
        include './backend/auth.php';
        include './backend/connect.php';
        include './backend/post.php';
        include_once './frontend/helpers/session-init.php';

        if($id === null && $role === null){
            header('Location: /login');
            exit;
        }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body class="bg-blue">


    <div class="d-flex align-items-center">

        <!-- MENU SIDE ADMIN -->
        <?php  
            if($role == "admin"):
        ?>
        
        <button class="btn ms-2 stroke-white text-white mb-2" id="MenuLeftSide" type="button" style="position:absolute; top:10%;">
            <i class="bi bi-list"></i>
        </button>

        <div class="d-flex flex-column menu-side gap-2 mt-5 mb-5" id="MenuLeftSideForm" >
                <a href="/admin/admin-posts">
                    <button class="btn menu-btns" type="button">Posts</button>
                </a>
                <a href="/admin/users">
                    <button class="btn menu-btns" type="button">Users</button>
                </a>
                <a href="/admin/applications">
                    <button  class="btn menu-btns" type="button">Applications</button>
                </a>

        </div>
        <?php 
            endif; 
        ?>

        <!-- MAIN CONTENT -->
        <div class="p-5 mt-5 mb-5 flex-grow-1">
        
            <h3 class="damion-regular fs-2 text-white text-center pb-2">Profile</h3>
                <?php
                    [$user , $email , $role] = profile_info($db, $id);  
                ?>
    
                    <div class="card shadow h-100">

                        <div class="card-header p-3">
                            <div class="d-flex">
                                <i class="bi bi-person-fill" ></i>
                                <h5 class="ps-3">
                                    Account Info
                                </h5>
                            </div>
                        </div>


                        <div class="card-body p-3">
    
                            <h5 class="card-title fw-bold">
                                <?php echo htmlspecialchars($user); ?>
                            </h5>
        
                            <h6 class="card-subtitle mb-1">
                                <?php echo htmlspecialchars($email); ?>
                            </h6>
        
                            <p class="mb-1 ">
                                <strong>Role :</strong>
                                <?php echo htmlspecialchars($role); ?>
                            </p>
                        </div>
                    
                        <div class="card-footer border-0 d-flex justify-content-left gap-2 mb-2">
    
                            <button class="btn bg-blue text-white mt-3" id="GetBtnJob" type="button">See actual jobs</button>
                <?php
                    if($role == "admin"):
                        [$user , $email , $role] = profile_info($db, $id);  
                ?>
                            <button class="btn stroke-blue text-blue mt-3" id="BtnNewJob" type="button">New Job</button>
                <?php
                    endif;
                ?>
                            <a href="/logout">
                                <button class="btn bg-danger text-white mt-3">Logout</button>
                            </a>
                        </div>
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

                
    
    
            <!-- FORM DISPLAY JOBS -->
            
            <form class="display-jobs" id="FormGetJobs">
                
                <h3 class="damion-regular fs-2 text-white text-center pt-5">Actual Jobs</h3>
                
                <div class="row g-4">
                    <?php
                        $alljobs = getpost($db ,$start=0 , $rows_per_page=3);
                        if(!empty($alljobs)){
                            foreach($alljobs as $job){
                                $postid = $job['postid'];
                                $admin_id = $job['admin_id'];
                    ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-jobs h-100">
                                <div class="card-header">

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
                                    
                                    <?php 
                                        endif;
                                    ?>
                                    
                                </div>
                            </div> 
                            
                        </div>
                
    
                    <?php
                            }
                        }else{
                            echo "No Jobs Found!";
                        }
                    
                    ?>
                </div>
                
                <a href="/jobs">
                    <input class="btn bg-white text-blue mt-3" type="button" value="Show More">
                </a>
            </form>
    
    
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
    
    
    
        </div>
    </div>

    <?php 
        include './frontend/footer.php';
    ?>


    <script>
        const MenuLeftSide = document.getElementById('MenuLeftSide');
        const MenuLeftSideForm = document.getElementById('MenuLeftSideForm');
        if(MenuLeftSide){
            MenuLeftSide.addEventListener('click' , function(){
                MenuLeftSideForm.classList.toggle('open');

            });
        }

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

        const closebtn1 = document.getElementById('btnclose1');
        const EditFormJob = document.getElementById('FormEditJob');

        closebtn1.addEventListener('click', function(){
            overlay.style.display = EditFormJob.style.display === 'block' ? 'none' : 'block';
            EditFormJob.style.display = EditFormJob.style.display === 'block' ? 'none' : 'block';
        })

        const closebtn2 = document.getElementById('btnclose2');
        const DeleteFormJob = document.getElementById('FormDeleteJob');

        closebtn2.addEventListener('click', function(){
            overlay.style.display = DeleteFormJob.style.display === 'none' ? 'block' : 'none';
            DeleteFormJob.style.display = DeleteFormJob.style.display === 'none' ? 'block' : 'none';
        })


        // Form Display Job
        const GetBtnJob = document.getElementById('GetBtnJob');
        const GetFormJob = document.getElementById('FormGetJobs');
        if(GetBtnJob){
            GetBtnJob.addEventListener('click' , function(){
                GetFormJob.classList.toggle('open');
            });
        }




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




    </script>

    <style>
        .card-jobs{
            border: 2px;
            border-radius: 8px;
            transition: border-color 0.2s ease, transform 0.2s ease-in-out ,box-shadow 0.2s ease-in-out;
        }
        .card-jobs:hover{
            border-color: #10367D;
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.5);

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


        .menu-side{
            overflow: hidden;    
            width: 0;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 0;
            transition: width 0.3s ease-in-out,box-shadow 0.2s ease-in-out, padding 0.3s ease-in-out;
        }
        .menu-side:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }
        .menu-side.open{
            width: 250px;
            padding: 1rem;
        }

        .display-jobs{
            padding : 1rem;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        
        .display-jobs.open{
            max-height: 100%;
            opacity: 1;
        }

        .menu-btns{
            background-color: #10367D;
            color: #F4F3F1;
            transition: background-color 0.3s ease-in-out;

        }

        .menu-btns:hover{
            
            border: 2px solid #10367D;
            border-color: #10367D;
            color:#10367D;
        }

    </style>

</body>
</html>