<?php  
    include './frontend/header.php' ;
    include './backend/connect.php';  
    include './backend/post.php';
    include './backend/apply.php';
    include_once './frontend/helpers/session-init.php';

    $jobID = $_GET['job_id'] ?? null;
    $post_ids = user_applied($db, $id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job</title>
</head>
<body class="bg-blue">
    <div class="p-5 mt-5">

        <h3 class="damion-regular text-white fs-2 text-center ">
            Job Nb <?php echo $jobID ?>
        </h3>

            
        <?php 
            if($jobID){
                $jobinfo = getpsotbyid($db , $jobID);
                if(!empty($jobinfo)){
                    $post_id = $jobinfo['id'];
        ?>
            <div class="d-flex flex-column justify-content-center">
                <div class="card h-100 shadow">
                    
                    <div class="card-body">


                        <h5 class="card-title fw-bold">
                            <?php echo htmlspecialchars($jobinfo['title']); ?>
                        </h5>
    
                        <h6 class="card-subtitle mb-1">
                            <?php echo htmlspecialchars($jobinfo['company']); ?>
                        </h6>
    
                        <p class="mb-1">
                            <strong>Location:</strong>
                            <?php echo htmlspecialchars($jobinfo['location']); ?>
                        </p>
    
                        <p class="mb-1">
                            <strong>Type:</strong>
                            <?php echo htmlspecialchars($jobinfo['type']); ?>
                        </p>
    
                        <p class="card-text mb-1">
                            <?php echo htmlspecialchars($jobinfo['description']); ?>
                        </p>
    
                        <p class="fw-bold">
                            <?php  echo htmlspecialchars(number_format($jobinfo['salary']));  ?> $
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
                            <?php if ($alr_applied) { ?>
                                <button class="btn stroke-gray text-gray" disabled>
                                    Applied
                                </button>
                            <?php } else { ?>
                                <button class="btn bg-blue text-white BtnApplyJob"
                                        data-id="<?php echo $post_id; ?>"
                                        data-title="<?php echo $jobinfo['title'];?>">
                                    Apply
                                </button>
                            <?php } ?>
                    </div>
                </div>  
            </div>

        <?php
            }}

        ?>
    </div>

    

       <div id="modalOverlay" style="display: none;"></div>
    <div class="d-flex align-items-center justify-content-center">
        <div class="card p-5 Form" id="FormApplyJob"  style="display: none;">

            <button class="btn btn-close" id="btnclose" type="button" aria-label="Close">
            </button>
            
            <?php 
                if($id && $role){ ?>
                    <form class="d-flex flex-column justify-content-center align-items-center quicksand-regular" method="POST" action="../backend/apply.php" enctype="multipart/form-data">
                        <input type="hidden" name="form_type" value="apply">
                        <input type="hidden" name="user_id" value="<?php echo $id?>">
                        <input type="hidden" name="postid">
                        <input type="hidden" name="post_title">


                        <h4 class="damion-regular fs-1 text-blue mb-5">Apply</h4>

                        <div class="form-outline mb-3 w-100">
                            <label class="form-label" for="JobType">Select your preset</label>
                            <select class="form-select mb-2 text-blue shadow" name="JobType" id="JobType">
                                <option selected disabled hidden>Apply using your presets</option>
                                <?php 
                                    $fetch = get_presets($db, $id , 0 , 10);
                                    if(!empty($fetch)){
                                        foreach($fetch as $preset){
                                ?>
                                    <option value="<?php echo $preset['id'] ?>"
                                            data-cvname="<?php echo htmlspecialchars($preset['cv_name']) ?>"
                                            data-covername="<?php echo htmlspecialchars($preset['cover_name'] ?? '') ?>"
                                    ><?php echo $preset['preset_name'] ?>
                                    </option>
                                
                                <?php
                                    }}else{
                                ?>
                                    <option value="" disabled
                                    > No preset Found
                                    </option>

                                <?php
                                    }
                                ?>
                            </select>
                                    <input type="hidden" name="preset_id" id="preset_id" value="">
                        </div>

                        <div class="pb-5">

                            <label for="cvfile" id="drop-text" >Drop your CV *</label>

                            <label for="cvfile" class="drop-container" id="dropcontainer">
                                <span class="drop-title" id="drop-title">Drop files here</span>
                                or
                                <input type="file" id="cvfile"  name="cvfile" required>
                                <input class="form-control shadow " type="text" id="cvdisplay"  name="cvdisplay" value="" style="display: none; width:350px; max-width: 100%; padding: 5px; border-radius: 10px ; border: 1px solid #1d1d1d;" disabled>
                            </label>
                        </div>
                        
                        <div class="pb-5">
                            <label for="coverfile">Drop your Cover letter</label>
    
                            <label for="coverfile" class="drop-container" id="dropcontainer">
                                <span class="drop-title">Drop files here</span>
                                or
                                <input type="file" id="coverfile" name="coverfile">
                                <input class="form-control shadow " type="text" id="coverdisplay"  name="coverdisplay" value="" style="display: none; width:350px; max-width: 100%; padding: 5px; border-radius: 10px ; border: 1px solid #1d1d1d;" disabled>

                            </label>

                        </div>

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
    <script>
        const overlay = document.getElementById('modalOverlay');


         document.addEventListener('click', function(e){
            if(e.target.classList.contains('BtnApplyJob')){
                const postId = e.target.dataset.id;
                const posttitle = e.target.dataset.title;

                const postidInput = document.querySelector('#FormApplyJob [name="postid"]');
                const posttitleInput = document.querySelector('#FormApplyJob [name="post_title"]');

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


        
        const SelectPreset = document.getElementById('JobType');
        const presetIdInput = document.getElementById('preset_id');

        const CvInput = document.getElementById('cvfile');
        const CvDisplay = document.getElementById('cvdisplay');

        const CoverInput = document.getElementById('coverfile');
        const CoverDisplay = document.getElementById('coverdisplay');

        const DropTitle = document.getElementById('drop-title');
        const DropText = document.getElementById('drop-text');

        SelectPreset.addEventListener('change', function(){
            const selectedValue = this.value;

            if(this.selectedIndex === 0){
                presetIdInput.value = "";
                CvInput.required = true;
            }else{
                const selectedOption = this.options[this.selectedIndex];
                const cvName = selectedOption.dataset.cvname;
                const coverName = selectedOption.dataset.covername ?? 'No Cover';

                presetIdInput.value = selectedValue;

                CvInput.required = false;
                CvInput.disabled = true ;
                CvInput.style.display = 'none';

                CoverInput.required = false;
                CoverInput.disabled = true ;
                CoverInput.style.display = 'none';

                DropText.innerHTML = 'CV from Preset';
                DropTitle.innerHTML = 'CV Imported';

                CvDisplay.style.display = 'block';
                CvDisplay.value = cvName;

                CoverDisplay.style.display = 'block';
                CoverDisplay.value = coverName ;
                
            }
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
        .card-body:hover{
            color:#000;
        }
    </style>
    
</body>
</html>


<?php 
    include './frontend/footer.php';
?>
    