<?php 
        include './frontend/header.php' ;
        include './backend/auth.php';
        include './backend/connect.php';
        include './backend/post.php';
        // include './frontend/job.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body class="bg-black">


    <div class="p-5 mt-5 text-white">
        <?php if(isset($_SESSION['message'])) : ?>
            <div class="alert alert-<?php echo $_SESSION['message_type'];?>">
        <?php echo $_SESSION['message']; ?>
            </div>
        <?php 
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            endif;
        ?>
        <?php  
            // Admin profile view
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

        <?php endif; ?>
        
        <h3>PROFILE</h3>
        

        <br>
        <?php 
            [$id , $role] = sessionstart(); 
            if($id === null && $role === null){
                header('Location: /login');
            }

            if($role == "user"):
                echo $role . "<br>";
                profile_info($db , $id);  
        ?>

        <br>
        <a href="/jobs">
            <button>Browse more jobs</button>
        </a>
    

        <?php  
            // Admin profile view
            elseif($role == "admin"):
                echo $role . "<br>";
                profile_info($db, $id);  
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
        <br>
        <button id="GetBtnJob">See actual jobs</button>
        <form id="FormGetJobs" style="display: none;">
            <?php 
                $alljobs = getpost($db ,$start=0 , $rows_per_page=3);
                if($alljobs === null) {echo "No jobs offers";}
                else{
                    foreach($alljobs as $job){
                        $postid = $job['postid'];
                        $admin_id = $job['admin_id'];


                        echo id_to_user($db , $admin_id) . "<br>";
                        echo $job['title'] . "<br>";
                        echo $job['company'] . "<br>";
                        echo $job['location'] . "<br>";
                        echo $job['type'] . "<br>";
                        echo $job['description'] . "<br>";
                        echo $job['salary'] . "<br>";
                        echo $job['place'] . "<br>";
                        if($job['is_active'] === "1"){ echo "Active";}
                        echo "<br> ";

                        echo '<button type="button" class="BtnEditJob" 
                        data-id="'. htmlentities($job['postid']). '"
                        data-title="' . htmlentities($job['title']) . '" 
                        data-company= "' . htmlentities($job['company']) . '" 
                        data-location= "' . htmlentities($job['location']) . '" 
                        data-type="' . htmlentities($job['type']) .'"
                        data-description="'. htmlentities($job['description']) .'"
                        data-salary="'. htmlentities($job['salary'] ).'"
                        >
                        Edit Post   </button>';

                        echo '<button type="button" class="BtnDeleteJob"  
                        data-id="'. htmlentities($job['postid']) . '"
                        data-title="'. htmlentities($job['title']) . '"
                        > 
                        Delete Post </button>';


                        echo "<br><br> ";
                    }
                }
            
            ?>

        <a href="/admin/admin-posts">
            <input type="button" value="Show More">
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


    
        <br><br><br>
        <a href="/logout">
            <button>Logout</button>
        </a>
        <br>
    </div>
    
    <script>
        // Form New Job
        const NewBtnJob = document.getElementById('BtnNewJob');
        const NewFormJob = document.getElementById('FormNewPost');

        NewBtnJob.addEventListener('click' , function(){
            if (NewFormJob.style.display === 'block') {
                NewFormJob.style.display = 'none';
            } else {
                NewFormJob.style.display = 'block';
            }
        });


        // Form Display Job
        const GetBtnJob = document.getElementById('GetBtnJob');
        const GetFormJob = document.getElementById('FormGetJobs');

        GetBtnJob.addEventListener('click' , function(){
            if (GetFormJob.style.display === 'block') {
                GetFormJob.style.display = 'none';
            } else {
                GetFormJob.style.display = 'block';
            }
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