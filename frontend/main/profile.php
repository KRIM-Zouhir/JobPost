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
        <div class="d-flex flex-column menu-side gap-2 mt-5 mb-5" id="MenuLeftSideForm" >
            <?php  
                if($role == "admin"):
            ?>
                <a href="/admin/admin-posts">
                    <button class="btn stroke-blue text-blue" type="button">Posts</button>
                </a>
                <a href="/admin/users">
                    <button class="btn stroke-blue text-blue" type="button">Users</button>
                </a>
                <a href="/admin/applications">
                    <button  class="btn stroke-blue text-blue" type="button">Applications</button>
                </a>

            <?php 
                endif; 
            ?>
        </div>

        <!-- MAIN CONTENT -->
        <div class="p-5 mt-5 mb-5 flex-grow-1">
        
            <h3 class="damion-regular fs-2 text-white text-center pb-2">Profile</h3>
    
            <?php 
                if($role == "user"):
                    [$user , $email , $role] = profile_info($db, $id);  
            ?>
    
                    <div class="card shadow p-3 h-100">
    
                        <div class="card-body text-gray">
    
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
    
                            <button class="btn bg-blue text-white mt-3  " id="GetBtnJob">See actual jobs</button>
    
                            <a href="/logout">
                                <button class="btn bg-danger text-white mt-3">Logout</button>
                            </a>
                        </div>
                    </div>
        
            <?php  
                elseif($role == "admin"):
                    [$user , $email , $role] = profile_info($db, $id);  
            ?>
    
                    <div class="card shadow p-3 h-100">
    
                        <div class="card-body text-gray">
    
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
    
                            <button class="btn stroke-blue text-blue mt-3" id="BtnNewJob" type="button">New Job</button>
    
    
                            <a href="/logout">
                                <button class="btn bg-danger text-white mt-3">Logout</button>
                            </a>
                        </div>
                    </div>
    
                    <div id="modalOverlay" style="display:none;"></div>
                    <div class="d-flex align-items-center justify-content-center" >
                        <div class="card p-5 w-25 Form" id="FormNewPost">
            
                            <button class="btn btn-close" id="btnclose" type="button" aria-label="Close">
                            </button>
                            
                            <!-- FORM NEW JOB -->
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

            <?php endif; ?>
                
    
    
            <!-- FORM DISPLAY JOBS -->
            
            <form id="FormGetJobs" style="display: none;">
                
                <div class="row g-4 mt-5">
                    <?php 
                        $alljobs = getpost($db ,$start=0 , $rows_per_page=3);
                        if(!empty($alljobs)){
                            foreach($alljobs as $job){
                                $postid = $job['postid'];
                                $admin_id = $job['admin_id'];
                    ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-jobs h-100">
                                
                                <div class="card-body">
                                    
                                    <h5>
                                        <?php echo id_to_user($db , $admin_id);?>
                                    </h5>
    
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
    
                                    <p class="fw-bold">
                                        <?php if($job['is_active'] === "1")echo "Active"; ?> 
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
                                        <button class="btn stroke-success text-success BtnEditJob"
                                                data-id="<?php echo  htmlentities($job['postid']) ?>"
                                                data-title="<?php echo  htmlentities($job['title']) ?>" 
                                                data-company= "<?php echo  htmlentities($job['company']) ?>" 
                                                data-location= "<?php echo  htmlentities($job['location']) ?>" 
                                                data-type="<?php echo  htmlentities($job['type']) ?>"
                                                data-description="<?php echo  htmlentities($job['description']) ?>"
                                                data-salary="<?php echo  htmlentities($job['salary']) ?>">
                                            Edit Post
                                        </button>
    
    
                                        <button class="btn bg-danger text-white BtnDeleteJob"
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
                    <input class="btn stroke-white text-white mt-3" type="button" value="Show More">
                </a>
            </form>
    
    
            <!-- FORM EDIT JOBS -->
             
            <div id="modalOverlay" style="display:none;"></div>
            <div class="d-flex align-items-center justify-content-center" >
                <div class="card p-5" id="FormJob" style="display:none;">
    
                    <button class="btn btn-close mt-5" id="btnclose" type="button" aria-label="Close">
                        <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                    
                    <form class="d-flex flex-column justify-content-center align-items-center quicksand-regular" method="POST" action="../../backend/post.php" id="FormEditJob" style="display:none;">
                        <input type="hidden" name="form_type" value="EditJob"> 
                        <input type="hidden" name="redirect_to" value="/profile"> 
                        <input type="hidden" name="PostId">
                        
                        <input type="text" name="Title" placeholder="Job Title">
                        <br>
                        <input type="text" name="Company" placeholder="Company Name">
                        <br>
                        <input type="text" name="Location" placeholder="Job Location">
                        <br>
                        <select name="JobType" id="JobType" placeholder="Job Contract">
                            <option value="full-time">Full Time</option>
                            <option value="part-time">Part Time</option>
                            <option value="temp">Temporary</option>
                            <option value="internship">Internship</option>
                        </select>
                        <br>
                        <input type="text" name="Description" placeholder="Job Description">
                        <br>
                        <input type="text" name="Salary" placeholder="Job Salary">
                        <br>
                        <select name="JobPlace" id="JobPlace" placeholder="Job Place">
                            <option value="Presential">Presential</option>
                            <option value="Telework">Telework</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                        <br>
                        <input type="submit" value="Edit">
                    </form>
                </div>
            </div>
    
    
    
            <!-- FORM CONFIRM DELETE -->
            <form method="POST" action="../../backend/post.php" id="FormDeleteJob" style="display: none;" >
                <input type="hidden" name="form_type" value="DeleteJob"> 
                <input type="hidden" name="redirect_to" value="/profile"> 
    
    
                <input type="hidden" name="PostId">
                <input type="hidden" name="PostTitle">
                <input type="text" name="ConfirmDelete" placeholder="Write CONFIRM to delete">
                <br>
                <input type="submit" value="Delete">
            </form>
    
    
    
        </div>
    </div>

    <button class="btn ms-2 stroke-white text-white mb-2" id="MenuLeftSide" type="button" style="position:absolute; top:10%;">
        <i class="bi bi-list"></i>
    </button>
    
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


        // Form Display Job
        const GetBtnJob = document.getElementById('GetBtnJob');
        const GetFormJob = document.getElementById('FormGetJobs');
        if(GetBtnJob){
            GetBtnJob.addEventListener('click' , function(){
                GetFormJob.style.display = GetFormJob.style.display === 'none' ? 'block' : 'none';
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
                formdisplay(EditFormJob);
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
                formdisplay(DeleteFormJob);

            
            }
        })

        

        function formdisplay(Form){
            if (Form.style.display === 'block') {
                Form.style.display = 'none';
            } else {
                Form.style.display = 'block';
            }
        }




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
            display: none;
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
        .menu-side.open {
            width: 200px;
            padding: 1rem;
        }


    </style>

</body>
</html>