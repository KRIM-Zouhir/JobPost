<?php 
    include './frontend/header.php';
    include './backend/helper.php';
    include './backend/preset.php';

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
    <div class="p-5 mt-5 text-white">
        <h3>Presets</h3>

        <button id="BtnAddPreset">Add</button>

        <form method="POST" action="../../backend/preset.php" id="FormPreset" enctype="multipart/form-data" style="display: none;">
            <input type="hidden" name="form_type" value="form_preset">
            <input type="hidden" name="userid" value="<?php echo $id; ?>">
            <br>
            <input type="text" name="presetname" placeholder="Preset Name" required>
            <br><br>
            <input type="file" name="cvfilename" placeholder="CV" required>
            <br>
            <input type="file" name="coverfilename" placeholder="Cover">
            <br><br>
            <input type="submit" value="Add">
        </form>
        <br>

    
    <?php 
        $fetch = get_presets($db, $id, $start, $rows_per_page);
        if(!empty($fetch)){
            foreach($fetch as $preset){
                echo "<br>";
                $user_id = $preset['user_id'] . "<br>";
                echo $preset['preset_name'] . "<br>";
                echo $preset['cv_name'] . "<br>";
                echo '<a href="'. "/backend/uploads/presets_" . $id . "/name_" . $preset['id'] . "/CV.pdf" . '"><button>Open</button></a>' . "<br>";
                if(!empty($preset['cover_name'])){
                    echo htmlentities($preset['cover_name']) . "<br>";
                    echo '<a href="'. "/backend/uploads/presets_" . $id . "/name_" . $preset['id'] . "/Cover.pdf" . '"><button>Open</button></a>' . "<br>";
                }
                
                echo '<button class="BtnEditPreset" 
                data-presetid="' . htmlentities($preset['id']) .'"
                data-userid="' . htmlentities($preset['user_id']) .'"
                data-presetname="' . htmlentities($preset['preset_name']) .'"
                data-cvname="' . htmlentities($preset['cv_name']) .'"
                data-covername="' . $preset['cover_name'] .'"
                >Edit</button>';
                
                echo '<button class="BtnDeletePreset"
                data-presetid="' . htmlentities($preset['id']) .'"
                >Delete</button>';
            }
        }
    
    ?>


        <form method="POST" action="../../backend/preset.php" id="FormEditPreset" enctype="multipart/form-data" style="display: none;">
            <input type="hidden" name="form_type" value="form_edit">
            <input type="hidden" name="presetid">
            <input type="hidden" name="userid">
            <br>
            <input type="text" name="presetname" placeholder="Preset Name">
            <br>
            <input type="text" name="cv_nameold" disabled>
            <input type="file" name="cv_namenew">
            <a href="">
                <button></button>
            </a>
            <br>
            <input type="text" name="cover_nameold" disabled>
            <input type="file" name="cover_namenew">
            <br>
            <input type="submit" value="Submit">
        </form>


        <form method="POST" action="../../backend/preset.php" id="FormDeletePreset" style="display: none;">
            <input type="hidden" name="form_type" value="form_delete">
            <input type="hidden" name="presetid">
            <label class="text-white">
                <input type="checkbox" name="checkbox_delete"> Are you sure ?
            </label>
            <br>
            <input type="submit" value="Submit">

        </form>



    </div>


    <script>
        const BtnAddPreset = document.getElementById('BtnAddPreset');
        const FormPreset = document.getElementById('FormPreset');

        BtnAddPreset.addEventListener('click', function(){
            FormPreset.style.display = FormPreset.style.display === 'none' ? 'block' : 'none' ;
        })



        document.addEventListener('click', function(e){
            if(e.target.classList.contains('BtnEditPreset')){
                const FormEditPreset = document.getElementById('FormEditPreset');

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
                document.querySelector('#FormEditPreset [name="cv_nameold"]').herf = edit_preset.cvname;
                document.querySelector('#FormEditPreset [name="cover_nameold"]').value = edit_preset.covername;
                
                FormEditPreset.style.display =  FormEditPreset.style.display === 'none' ? 'block' : 'none' ;

            }
        })

        document.addEventListener('click', function(e){
            if(e.target.classList.contains('BtnDeletePreset')){
                const FormDeletePreset = document.getElementById('FormDeletePreset');
                // const delete_preset =  e.target.dataset.userid ;

                document.querySelector('#FormDeletePreset [name="presetid"]').value = e.target.dataset.presetid;
                
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