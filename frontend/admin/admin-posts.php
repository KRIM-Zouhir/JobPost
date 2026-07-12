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
<body class="bg-black">
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
            $rows_per_page = 10;
            $alljobs = getpost($db , $start, $rows_per_page);

           
    ?>   

    <div class="p-5 mt-5 text-white">
        <h3>Admin Posts</h3>
        <form method="GET" action="/admin/admin-posts" id="FormSearch">
            <input type="text" name="search" value="<?php if(isset($_GET['search'])){ echo $_GET['search'];} ?>" placeholder="Type ...">
            <input type="submit" id="BtnSearch" value="Search" class="btn btn-dark">
        </form>
        <br>

        <!-- FORM NEW JOB -->
        <button id="BtnNewJob" class="btn btn-dark">Post a new job</button>
        <br><br>
        <form method="POST" action="../../backend/post.php" id="FormNewPost" style="display: none;">
            <input type="hidden" name="form_type" value="NewJob"> 
            <input type="hidden" name="redirect_to" value="/admin/admin-posts"> 
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
        

        <?php 
            if(!isset($_GET['search'])){
                if(!empty($alljobs)){
                    foreach($alljobs as $job){
                        $admin_id = $job['admin_id'];
                        echo $job['postid'] . "<br>";
        
        
                        echo id_to_user($db , $admin_id) . "<br>";
                        echo $job['title'] . "<br>";
                        echo $job['company'] . "<br>";
                        echo $job['location'] . "<br>";
                        echo $job['type'] . "<br>";
                        echo $job['description'] . "<br>";
                        echo $job['salary'] . "<br>";
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
        
                        echo '<a href="/admin/applications/'. $job['postid'] . '"><button type="button" class="BtnViewAppJob"  
                        data-id="'. htmlentities($job['postid']) . '"
                        > 
                        View Applications</button></a>';
        
        
                        echo "<br><br> ";
                        echo "<br><br> ";
                    }
                }else{echo "No Post Found!"; }

            }else{
                $search_value =  htmlentities($_GET['search']) ?? '';
                $allsearch  = search_posts($db, '%' . $search_value . '%', $start , $rows_per_page);
                if(!empty($allsearch)){
                    foreach($allsearch as $job){
                        $admin_id = $job['admin_id'];
                        echo $job['postid'] . "<br>";
        
        
                        echo id_to_user($db , $admin_id) . "<br>";
                        echo $job['title'] . "<br>";
                        echo $job['company'] . "<br>";
                        echo $job['location'] . "<br>";
                        echo $job['type'] . "<br>";
                        echo $job['description'] . "<br>";
                        echo $job['salary'] . "<br>";
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
        
                        echo '<a href="/admin/applications/'. $job['postid'] . '"><button type="button" class="BtnViewAppJob"  
                        data-id="'. htmlentities($job['postid']) . '"
                        > 
                        View Applications </button></a>';
        
        
                        echo "<br><br> ";
                        echo "<br><br> ";
                        }
                }else{echo "No Post Found!"; }

            }
        ?>

        
        <!-- FORM EDIT JOBS -->
        <form method="POST" action="../../backend/post.php" id="FormEditJob" style="display: none;">
            <input type="hidden" name="form_type" value="EditJob"> 

            <input type="hidden" name="PostId">
            <input type="hidden" name="redirect_to" value="/admin/admin-posts"> 

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
            <input type="hidden" name="redirect_to" value="/admin/admin-posts"> 


            <input type="hidden" name="PostId">
            <input type="hidden" name="PostTitle">
            <input type="text" name="ConfirmDelete" placeholder="Write CONFIRM to delete">
            <br>
            <input type="submit" value="Delete">
        </form>
    </div>

    <!-- Pagination -->

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
    

    <?php 
        else:
            header('Location: /home');
        endif; 
    ?>
        
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
                EditFormJob.style.display =  EditFormJob.style.display === 'none' ? 'block' : 'none' ;

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

