<?php 
    include './backend/connect.php';
    include './frontend/header.php';
    include './backend/apply.php';
    include './backend/search.php';
    include './backend/post.php';
    include_once './backend/helper.php';
    include_once './frontend/helpers/session-init.php';

    [$id , $role] = sessionstart(); 
    if($id === null && $role === null){
        header('Location: /login');
    }
    if(!empty($id) && $role === "user"):
        header("Location: /home");

    elseif(!empty($id) && $role === "admin"):
        $start = 0 ;
        $rows_per_page = 9 ;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body class="bg-blue">

    <div class="p-5 mt-5 text-white">


        <div class="d-flex align-items-center justify-content-between">
            <h3 class="damion-regular fs-2">Applications</h3>
            <form method="GET" action="/admin/applications">
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
        </div>

        <div class="row g-4 mt-3">
            <?php 
                if(!isset($_GET['search'])){
                    $applications = get_applications($db, $start , $rows_per_page);
                }else{
                    $search_value =  htmlentities($_GET['search']) ?? '';
                    $applications = search_applications($db, '%' . $search_value . '%', $start , $rows_per_page);
                }
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
                                        <?php 
                                        echo id_to_user($db, $application['user_id']); ?>
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

        


    </div>

    


    <!-- Pagination -->
    <div class="bg-blue p-5">

        <?php 
            global $pages;

            if(isset($_GET['page-nr']) && !isset($_GET['search'])){
                $search_value =  $_GET['search'] ?? '';
                $pages = calcul($db , $table = "applications" , $rows_per_page);

                $uri_search = '';
                $uri_page_nr = '/admin/applications?page-nr=';

            }elseif(isset($_GET['search'])){
                $search_value =  htmlentities($_GET['search']);
                $pages = calcul_search($db, $table="applications", $rows_per_page , "post_title", '%' . $search_value . '%');

                $uri_search = '/admin/applications?search=';
                $uri_page_nr = '&page-nr=';

            }else{
                $search_value =  $_GET['search']?? '';
                $pages = calcul($db , $table = "applications" , $rows_per_page);

                $uri_search = '';
                $uri_page_nr = '/admin/applications?page-nr=';

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

    <?php endif; ?>

</body>
</html>