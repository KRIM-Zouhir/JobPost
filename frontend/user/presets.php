<?php 
    include './frontend/header.php';
    include './backend/helper.php';
    include './backend/preset.php';
    include_once './frontend/helpers/session-init.php';

    if($role == "user") :
        $start= 0;
        $rows_per_page = 10;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presets</title>
</head>
<body class="bg-blue">
    <div class="p-5 mt-5">

        <div class="d-flex align-items-center justify-content-between">
            <h3 class="damion-regular fs-2 text-white text-center pb-2">Presets</h3>
    
            <button class="btn bg-white text-blue" id="BtnAddPreset">+ Add</button>
        </div>


        
        <div id="modalOverlay" style="display: none;"></div>
        <div class="d-flex align-items-center justify-content-center" >
            <div class="card Form p-5" id="FormPreset" style="display: none;">
                <button class="btn btn-close" id="btnclose" type="button" aria-label="Close">
                </button>

                <form class="d-flex flex-column justify-content-center align-items-center quicksand-regular" method="POST" action="../../backend/preset.php"  enctype="multipart/form-data" >
                    <input type="hidden" name="form_type" value="form_preset">
                    <input type="hidden" name="userid" value="<?php echo $id; ?>">
                    

                    <div class="form-outline w-75  mb-3" data-mdb-input-init>
                        <label class="form-label" for="presetname">Preset Name</label>
                        <input class="form-control shadow" type="text" name="presetname" id="presetname" style="font-size: 14px;" required>  
                    </div>
                    <div class="pb-5">
                        <label for="cvfilename" >Drop your CV *</label>
                        <label for="images" class="drop-container" id="dropcontainer">
                            <span class="drop-title">Drop files here</span>
                            or
                            <input type="file" id="images"  name="cvfilename" required>
                        </label>
                    </div>

                    <div class="pb-5">
                        <label for="coverfilename">Drop your Cover letter</label>
                        <label for="images" class="drop-container" id="dropcontainer">
                            <span class="drop-title">Drop files here</span>
                            or
                            <input type="file" id="images" name="coverfilename">
                        </label>
                    </div>

                    <input class="btn bg-blue text-white" type="submit" value="Add">
                </form>
            </div>
        </div> 


    
        <div class="row g-4">
            <?php
                $fetch = get_presets($db, $id, $start, $rows_per_page);
                if(!empty($fetch)){
                    foreach($fetch as $preset){
                        $user_id = $preset['user_id'];
            ?>
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow">
                    <div class="card-body d-flex flex-column justify-content-center gap-2">
                        <h5 class="card-title fw-bold">
                            <?php echo htmlspecialchars($preset['preset_name']); ?>
                        </h5>

                        <a href="<?php echo "/backend/uploads/presets_" . $id . "/name_" . $preset['id'] . "/CV.pdf"; ?>">
                            <button class="btn bg-blue text-white"><i class="bi bi-eye shadow"> </i>View CV</button>
                        </a>

                        <?php if(!empty($preset['cover_name'])) : ?>
                            <a href="<?php echo "/backend/uploads/presets_" . $id . "/name_" . $preset['id'] . "/Cover.pdf"; ?>"    >
                                <button class="btn bg-blue text-white"><i class="bi bi-eye shadow"> </i>View Cover</button>
                            </a>
                        <?php else : ?>
                            <a >
                                <button class="btn bg-blue text-white" disabled><i class="bi bi-eye shadow"> </i>No Cover</button>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer">
                        <button class="btn BtnEditPreset bg-success text-white" 
                                type="button"
                                data-presetid="<?php echo htmlentities($preset['id']); ?>"
                                data-userid="<?php echo htmlentities($preset['user_id']); ?>"
                                data-presetname="<?php echo htmlentities($preset['preset_name']); ?>"
                                data-cvname="<?php echo htmlentities($preset['cv_name']); ?>"
                                data-covername="<?php echo $preset['cover_name']; ?>"
                        >
                            Edit
                        </button>
                        

                        <button class="btn BtnDeletePreset bg-danger text-white" type="button"
                                data-presetid="<?php echo htmlentities($preset['id']); ?>"
                        >
                            Delete
                        </button>

                    </div>
                </div>
            </div>
                        
            <?php
                    }
                }
            
            ?>
        </div>

        <div id="modalOverlay" style="display: none;"></div>
        <div class="d-flex align-items-center justify-content-center" >
            <div class="card Form p-5" id="FormEditPreset" style="display: none;">
                <button class="btn btn-close" id="btnclose1" type="button" aria-label="Close">
                </button>

                <form  class="d-flex flex-column justify-content-center align-items-center quicksand-regular" method="POST" action="../../backend/preset.php" enctype="multipart/form-data">
                    <input type="hidden" name="form_type" value="form_edit">
                    <input type="hidden" name="presetid">
                    <input type="hidden" name="userid">

                    <h4 class="damion-regular fs-1 text-blue pb-5">Edit Preset</h4>


                    
                    <div class="form-outline w-75  mb-3" data-mdb-input-init>
                        <label class="form-label" for="presetname">Preset Name</label>
                        <input class="form-control shadow" type="text" name="presetname" id="presetname" style="font-size: 14px;" required>  
                    </div>

                    <div class="form-outline w-75  mb-3" data-mdb-input-init>
                        <label class="form-label" for="cv_nameold">CV</label>
                        <div class="d-flex align-items-center">
                            <input class="form-control shadow" type="text" name="cv_nameold" disabled>
                            <a href="<?php echo "/backend/uploads/presets_" . $id . "/name_" . $preset['id'] . "/CV.pdf"; ?>"    >
                                <button class="btn stroke-blue text-blue"><i class="bi bi-eye shadow"> </i></button>
                            </a>
                        </div>
                    </div>
                        
                    <div class="form-outline w-75  mb-5" data-mdb-input-init>
                        <input class="form-control" type="file" name="cv_namenew">
                    </div>


                    <div class="form-outline w-75 mb-3" data-mdb-input-init>
                        <label class="form-label" for="cover_nameold">Cover Letter</label>
                        <div class="d-flex align-items-center">
                            <input class="form-control shadow" type="text" name="cover_nameold" disabled>
                            <a href="<?php echo "/backend/uploads/presets_" . $id . "/name_" . $preset['id'] . "/Cover.pdf"; ?>"   name="cover-class"  >
                                <button class="btn stroke-blue text-blue"><i class="bi bi-eye shadow"> </i></button>   
                            </a>
                        </div>
                    </div>
                        
                    <div class="form-outline w-75  mb-5" data-mdb-input-init>
                        <input class="form-control" type="file" name="cover_namenew" >
                    </div>

                    <input class="btn bg-blue text-white" type="submit" value="Edit">
                </form>
            </div>
        </div>

        <div id="modalOverlay" style="display: none;"></div>
        <div class="d-flex align-items-center justify-content-center" >
            <div class="card Form p-5" id="FormDeletePreset" style="display: none;">
                <button class="btn btn-close" id="btnclose2" type="button" aria-label="Close">
                </button>
                <form class="d-flex flex-column justify-content-center align-items-center quicksand-regular" method="POST" action="../../backend/preset.php">
                    <input type="hidden" name="form_type" value="form_delete">
                    <input type="hidden" name="presetid">

                    <h4 class="damion-regular fs-1 text-blue pb-5">Delete Preset</h4>

                    <div class="d-flex align-items-center gap-1 mb-5">
                        <input class="checkbox" type="checkbox" name="checkbox_delete" required>
                        <label for="checkbox_delete" style="font-size: 15px">Are you sure you want to delete this preset?</label>
                    </div>


                    <input class="btn bg-danger text-white" type="submit" value="Delete">

                </form>
            </div>
        </div>
    </div>




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

        .btn-close{
            position: absolute;
            top: 10px;
            right: 10px;
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


    <script>
        const BtnAddPreset = document.getElementById('BtnAddPreset');
        const FormPreset = document.getElementById('FormPreset');
        const ModalOverlay = document.getElementById('modalOverlay');
        const FormEditPreset = document.getElementById('FormEditPreset');
        const FormDeletePreset = document.getElementById('FormDeletePreset');



        BtnAddPreset.addEventListener('click', function(){
            ModalOverlay.style.display = FormPreset.style.display === 'none' ? 'block' : 'none' ;
            FormPreset.style.display = FormPreset.style.display === 'none' ? 'block' : 'none' ;
        })

        const btnclose = document.getElementById('btnclose');
        btnclose.addEventListener('click', function(){
            ModalOverlay.style.display = FormPreset.style.display === 'none' ? 'block' : 'none' ;
            FormPreset.style.display = FormPreset.style.display === 'none' ? 'block' : 'none' ;
        })


        const btnclose1 = document.getElementById('btnclose1');
        btnclose1.addEventListener('click', function(){
            ModalOverlay.style.display = FormEditPreset.style.display === 'none' ? 'block' : 'none' ;
            FormEditPreset.style.display = FormEditPreset.style.display === 'none' ? 'block' : 'none' ;
        })

        const btnclose2 = document.getElementById('btnclose2');
        btnclose2.addEventListener('click', function(){
            ModalOverlay.style.display = FormDeletePreset.style.display === 'none' ? 'block' : 'none' ;
            FormDeletePreset.style.display = FormDeletePreset.style.display === 'none' ? 'block' : 'none' ;
        })


        document.addEventListener('click', function(e){
            if(e.target.classList.contains('BtnEditPreset')){
                const FormEditPreset = document.getElementById('FormEditPreset');
                const ModalOverlay = document.getElementById('modalOverlay');


                const edit_preset = {
                    presetid: e.target.dataset.presetid,
                    userid: e.target.dataset.userid,
                    presetname: e.target.dataset.presetname,
                    cvname: e.target.dataset.cvname,
                    covername: e.target.dataset.covername
                };


                document.querySelector('#FormEditPreset [name="presetid"]').value = edit_preset.presetid;
                document.querySelector('#FormEditPreset [name="userid"]').value = edit_preset.userid;
                document.querySelector('#FormEditPreset [name="presetname"]').value = edit_preset.presetname;
                document.querySelector('#FormEditPreset [name="cv_nameold"]').value = edit_preset.cvname;
                edit_preset.covername === "" ? document.querySelector('#FormEditPreset [name="cover-class"]').style.display = 'none' : document.querySelector('#FormEditPreset [name="cover-class"]').style.display = 'block';
                edit_preset.covername === "" ? document.querySelector('#FormEditPreset [name="cover_nameold"]').value = "No cover letter uploaded" : document.querySelector('#FormEditPreset [name="cover_nameold"]').value = edit_preset.covername;
                // if(edit_preset.covername === ""){
                //     document.querySelector('#FormEditPreset [name="presetid"]').value = edit_preset.presetid;
                //     document.querySelector('#FormEditPreset [name="userid"]').value = edit_preset.userid;
                //     document.querySelector('#FormEditPreset [name="presetname"]').value = edit_preset.presetname;
                //     document.querySelector('#FormEditPreset [name="cv_nameold"]').value = edit_preset.cvname;
                //     document.querySelector('#FormEditPreset [name="cover-class"]').style.display = 'none';
                //     document.querySelector('#FormEditPreset [name="cover_nameold"]').value = "No cover letter uploaded";
                // }else{
                //     document.querySelector('#FormEditPreset [name="presetid"]').value = edit_preset.presetid;
                //     document.querySelector('#FormEditPreset [name="userid"]').value = edit_preset.userid;
                //     document.querySelector('#FormEditPreset [name="presetname"]').value = edit_preset.presetname;
                //     document.querySelector('#FormEditPreset [name="cv_nameold"]').value = edit_preset.cvname;
                //     document.querySelector('#FormEditPreset [name="cover_nameold"]').value = edit_preset.covername;
                // }

                
                ModalOverlay.style.display =  FormEditPreset.style.display === 'none' ? 'block' : 'none' ;
                FormEditPreset.style.display =  FormEditPreset.style.display === 'none' ? 'block' : 'none' ;

            }
        })

        document.addEventListener('click', function(e){
            if(e.target.classList.contains('BtnDeletePreset')){
                const FormDeletePreset = document.getElementById('FormDeletePreset');
                const ModalOverlay = document.getElementById('modalOverlay');

                // const delete_preset =  e.target.dataset.userid ;

                document.querySelector('#FormDeletePreset [name="presetid"]').value = e.target.dataset.presetid;
                
                ModalOverlay.style.display =  FormDeletePreset.style.display === 'none' ? 'block' : 'none' ;
                FormDeletePreset.style.display =  FormDeletePreset.style.display === 'none' ? 'block' : 'none' ;

            }
        })


    </script>
    
</body>
</html>
<?php 
    else :  
        header("Location: /login");
          
    endif; 
?>