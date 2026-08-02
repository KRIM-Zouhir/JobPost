<?php 
        include './frontend/header.php' ;
        include './backend/auth.php';
        include './backend/connect.php';
        include './backend/post.php';
        include_once './frontend/helpers/session-init.php';

        if($id === null && $role === null){
            header('Location: /login');
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


    <div class="p-5 mt-5 text-white">
        <div class="text-left">
            <?php  
                if($role == "admin"):
            ?>
                <a href="/admin/admin-posts">
                    <button>Posts</button>
                </a>

                <a href="/admin/users">
                    <button>Users</button>
                </a>

                <a href="/admin/applications">
                    <button>Applications</button>
                </a>
            <?php 
                endif; 
            ?>
        </div>
        
        <h3 class="damion-regular fs-2 text-center">Profile</h3>
        

        <br>
        <div>

        </div>
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

        
                        <a href="/jobs">
                            <button class="btn bg-blue text-white mt-3">Browse more jobs</button>
                        </a>

                        <button class="btn bg-blue text-white mt-3" id="GetBtnJob">See actual jobs</button>

                        <a href="/logout">
                            <button class="btn bg-danger text-white mt-3">Logout</button>
                        </a>
                    </div>
                </div>
    
        <?php  
            elseif($role == "admin"):
                echo $role . "<br>";
                [$user , $email , $role] = profile_info($db, $id);  
        ?>

                <br>
                <br>

                <!-- FORM NEW JOB -->
                <button id="BtnNewJob">Post a new job</button>
                <form method="POST" action="../../backend/post.php" id="FormNewPost" style="display: none;">
                    <input type="hidden" name="form_type" value="NewJob"> 
                    <input type="hidden" name="redirect_to" value="/profile"> 

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
                        <option value="presential">Presential</option>
                        <option value="telework">Telework</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                    <br>
                    <input type="submit" value="Create">
                </form>
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
                        <div class="card h-100 shadow">
                            
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
            <a href="/admin/admin-posts">
                <input class="btn stroke-white text-white mt-3" type="button" value="Show More">
            </a>
        </form>


        <!-- FORM EDIT JOBS -->
        <form method="POST" action="../../backend/post.php" id="FormEditJob" style="display: none;">
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

    
    <?php 
        include './frontend/footer.php';
    ?>
    <script>
        // Form New Job
        const NewBtnJob = document.getElementById('BtnNewJob');
        const NewFormJob = document.getElementById('FormNewPost');

        NewBtnJob.addEventListener('click' , function(){
            NewFormJob.style.display = NewFormJob.style.display === 'none' ? 'block' : 'none';
        });


        // Form Display Job
        const GetBtnJob = document.getElementById('GetBtnJob');
        const GetFormJob = document.getElementById('FormGetJobs');

        GetBtnJob.addEventListener('click' , function(){
            GetFormJob.style.display = GetFormJob.style.display === 'none' ? 'block' : 'none';
        });




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
       }
    )

        

        function formdisplay(Form){
            if (Form.style.display === 'block') {
                Form.style.display = 'none';
            } else {
                Form.style.display = 'block';
            }
        }




    </script>

</body>
</html>