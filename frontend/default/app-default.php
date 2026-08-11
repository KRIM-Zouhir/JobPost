<?php 

    include './frontend/header.php';
    include './backend/apply.php';
    include './backend/post.php';
    [$id , $role] = sessionstart(); 
    if($id === null && $role === null){
        header('Location: /login');
    }
    if($role === "admin"):
        $jobID = $_GET['job_id'] ?? null;
        $start = 0 ;
        $rows_per_page = 9 ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
</head>
<body class="bg-blue">

    <div class="p-5 mt-5">
        <h3 class="damion-regular text-white fs-2 text-center ">
            Applications of <?php echo $jobID ?>
        </h3>


        <div class="row g-4 mt-3">
            <?php 
                $applications = get_application_byid($db ,$start, $rows_per_page,  $jobID);
                if(!empty($applications)){
                    foreach($applications as $application){
            ?>
                        <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow">
                                    
                                    <div class="card-header d-flex flex-column mb-2">
                                            <?php
                                                if($application['status'] == "accepted"):
                                            ?>
                                                    <button class="btn bg-success text-white mt-3">
                                                        Accepted
                                                    </button>
                                            <?php
                                                elseif($application['status'] == "pending"):
                                            ?>
                                                    <button class="btn bg-light-gray  text-white mt-3">
                                                        Pending
                                                    </button>
                                            <?php
                                                elseif($application['status'] == "rejected"):
                                            ?>
                                                    <button class="btn bg-danger text-white mt-3">
                                                        Rejected
                                                    </button>

                                            <?php
                                                endif;
                                            ?>
                                        
                                    </div>
                                    
                                    <div class="card-body d-flex flex-column justify-content-center gap-1">
                                        <h6 class="card-subtitle">

                                            <?php   echo htmlspecialchars(id_to_user($db, $application['user_id']));
                                            ?>
                                        </h6>

                                        <h5 class="card-title fw-bold">
                                            <?php echo htmlspecialchars($application['post_title']); ?>
                                        </h5>

                                        <p class="mb-1">
                                            <strong>Job:</strong>
                                            <?php echo htmlspecialchars($application['post_id']); ?>
                                        </p>
                                        
                                        <p class="mb-3">
                                            <strong>Date:</strong>
                                            <?php echo htmlspecialchars(date("M d, Y / H:i A", strtotime($application['app_date']))); ?>
                                        </p>
                                        <a href="<?php echo "/backend/uploads/post_" . $application['post_id'] . "/" . $application['cv_filename']; ?>">
                                            <button class="btn bg-blue text-white"><i class="bi bi-eye shadow"> </i>View CV</button>
                                        </a>
                                        <?php
                                            if(!empty($application['cover_note'])):
                                        ?>
                                            <a href="<?php echo "/backend/uploads/post_" . $application['post_id'] . "/" . $application['cover_note']; ?>">
                                                <button class="btn bg-blue text-white"><i class="bi bi-eye shadow"> </i>View Cover</button>
                                            </a>
                                        <?php
                                            else:
                                        ?>
                                            <a>
                                                <button class="btn bg-blue text-white" disabled><i class="bi bi-eye shadow"> </i>No Cover</button>
                                            </a>
                                        <?php
                                            endif; 
                                        ?>


                                    </div>

                                    <div class="card-footer d-flex flex-column justify-content-left gap-1">
                                        <?php
                                            if($application['status'] == "accepted"):
                                        ?>
                                            <a>
                                                <input class="btn stroke-success text-success" type="submit" value="Accept" disabled>
                                            </a>
                                        <?php
                                            else:
                                        ?>
                                            <form method="POST" action="../../backend/apply.php" >
                                                <input type="hidden" name="form_type" value="accept">
                                                <input type="hidden" name="redirect_to" value="/admin/applications/<?= $jobID ?>">
                                                <input type="hidden" name="id" value="<?php echo $application['app_id']; ?>">
                                                <input class="btn bg-success text-white" type="submit" value="Accept" >
                                            </form>
                                        <?php
            
                                            endif;
                                            if($application['status'] == "pending"):
                                        ?>
                                                <a>
                                                    <input class="btn stroke-light-gray text-light-gray" type="submit" value="Pending" disabled>
                                                </a>
                                        <?php
                                        
                                            else:
                                        ?>
                                                <form method="POST" action="../../backend/apply.php" >
                                                    <input type="hidden" name="form_type" value="pending">
                                                    <input type="hidden" name="redirect_to" value="/admin/applications/<?= $jobID ?>">
                                                    <input type="hidden" name="id" value="<?php echo $application['app_id']; ?>">
                                                    
                                                    <input class="btn bg-light-gray text-white" type="submit" value="Pending">
                                                </form>
                                        <?php
                                            endif;
                                            if($application['status'] == "rejected"):
                                        ?>
                                                <a>
                                                    <input class="btn stroke-danger text-danger" type="submit" value="Deny" disabled>
                                                </a>
                                        <?php
                                            else:
                                        ?>
                                            <form method="POST" action="../../backend/apply.php" >
                                                <input type="hidden" name="form_type" value="deny">
                                                <input type="hidden" name="redirect_to" value="/admin/applications/<?= $jobID ?>">
                                                <input type="hidden" name="id" value="<?php echo $application['app_id']; ?>">
                                                <input class="btn bg-danger text-white" type="submit" value="Deny">
                                            </form>
                                        <?php
                                            endif;
                                        ?>

                                    </div>

                                </div>
                        </div>

            <?php
                }}else{
            ?>
                    <h6 class="quicksand-regular text-white text-center mt-5">
                        No applications found.
                    </h6>
            <?php
                }
            ?>
        </div>

    </div>
    
</body>
</html>


<?php 
    endif; 
?>