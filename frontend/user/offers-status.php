<?php 
    include './frontend/header.php';
    include './backend/connect.php';
    include './backend/apply.php';
    include './backend/post.php';
    include './backend/search.php';
    include_once './frontend/helpers/session-init.php';



    if($role == "user"){
        $start = 0;
        $rows_per_page = 10;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers status</title>
</head>
<body class="bg-blue">


    <div class="p-5 mt-5">
        <div class="bg-blue mt-5 d-flex justify-content-between">
            <h3 class="damion-regular fs-2 text-white text-center pb-2">Offers Status</h3>
            <form method="GET" action="/offers-status" id="FormSearch">
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

        <div class="row g-4">
            <?php  
                if(!isset($_GET['search'])){
                    $applications = get_applications_foruser($db, $start, $rows_per_page, $id );
                    if(!empty($applications)){
                        foreach($applications as $application){
            ?>
                        
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow">
                        
                        <div class="card-body">
                                    
                            <h6 class="card-subtitle mb-1">
                                <?php echo htmlspecialchars($application['post_id']); ?>
                            </h6>
                            <h5 class="card-title fw-bold">
                                <?php echo htmlspecialchars($application['post_title']); ?>
                            </h5>


            <?php
                            $fetch = getpsotbyid($db, $application['post_id']);
                            if(!empty($fetch)){
            ?>
                                <h6 class="card-subtitle mb-1">
                                    <?php echo htmlspecialchars($fetch['company']); ?>
                                </h6>

                                <p class="mb-1">
                                    <strong>Location:</strong>
                                    <?php echo htmlspecialchars($fetch['location']); ?>
                                </p>
            <?php
                            }
            ?>
                                <p class="mb-1">
                                    <?php echo htmlspecialchars($application['status']); ?>
                                </p>
                                <p class="mb-1">
                                    <?php echo htmlspecialchars($application['app_date']); ?>
                                </p>
                                
                                <a href="/jobs/<?php echo $application['post_id']; ?>">More details</a>
            <?php
                }}else{
                    $search_value =  htmlentities($_GET['search']) ?? '';
                    $applications = search_offers($db , $id,'%' . $search_value  . '%', $start , $rows_per_page);
                    if(!empty($applications)){
                        foreach($applications as $application){
                            echo $application['post_id'] . "<br>";
                            echo $application['post_title'] . "<br>";
                            $fetch = getpsotbyid($db, $application['post_id']);
                            
                            if(!empty($fetch)){
                                echo $fetch['company'] . "<br>";
                                echo $fetch['location'] . "<br>";
                            }

                            echo $application['status'] . "<br>";
                            echo $application['app_date'] . "<br>";

                            echo '<a href="/offers-status/' . $application['post_id']. '"><button>More details</button></a>';
                            }
                    }else{
                        echo "No application found";
                    }
                }
            ?>
        </div>
                    </div>
                </div>
    </div>

    <!-- Pagination -->
    <?php 
        global $pages;

        if(isset($_GET['page-nr']) && !isset($_GET['search'])){
            $search_value =  $_GET['search'] ?? '';
            $pages = calcul_offers($db , $id , $rows_per_page);

            $uri_search = '';
            $uri_page_nr = '/offers-status?page-nr=';

        }elseif(isset($_GET['search'])){
            $search_value =  $_GET['search'];
            $pages = calcul_search_offers($db, $id, $rows_per_page , "post_title" , '%' . $search_value . '%');

            $uri_search = '/offers-status?search=';
            $uri_page_nr = '&page-nr=';

        }else{
            $search_value =  $_GET['search'] ?? '';
            $pages = calcul_offers($db , $id , $rows_per_page);

            $uri_search = '';
            $uri_page_nr = '/offers-status?page-nr=';

        }
    
    ?>

    <div class="text-center">
        <div class="text-white quicksand-regular mb-1">
                <?php   if(isset($_GET['page-nr'])){ 
                            echo $_GET['page-nr'];}
                        else{ 
                            echo "1"; } ?> / <?php echo $pages;?>
            </div>

            <div class="pagination d-flex align-items-center justify-content-center gap-2">
                <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?>1" class="btn bg-white text-blue">First</a>

                <?php if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){?>
                    <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $_GET['page-nr'] - 1; ?>" class="btn bg-white text-blue"><i class="bi bi-caret-left-fill"></i></a>
                <?php  }else{?>
                    <a href="" class="btn bg-white  text-blue"><i class="bi bi-caret-left-fill"></i></a>
                <?php } ?>

                

                <div class="page-numbers">
                <?php  
                        if(empty($pages)){
                ?>
                            <a href="">No pages</a>
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
                                <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $i ?>" class="btn stroke-white text-white"><?php echo $i ?></a>
                <?php
                            }else{
                ?>
                            <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $i ?>" class="btn bg-white text-blue"><?php echo $i ?></a>
                <?php  
                            }}      
                ?>
                </div>



                <?php 
                    if(!isset($_GET['page-nr'])){
                        if($pages > 1){?>
                            <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?>2" class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php   }elseif($pages <= 1 ){ ?>
                            <a href="" class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php   }
                
                    }else{
                            if($_GET['page-nr'] >= $pages):?>
                        <a href="" class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php       else: ?> 
                        <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $_GET['page-nr'] + 1 ?>" class="btn bg-white text-blue"><i class="bi bi-caret-right-fill"></i></a>
                <?php       endif; ?>
            
                <?php 
                    } ?>

                
                

                <a href="<?php echo $uri_search . $search_value . $uri_page_nr; ?><?php echo $pages;?>" class="btn bg-white text-blue">Last</a>
            </div>
        </div>
    </div>

    
    <script>
        const clearbtn = document.getElementById('clearbtn');
        const overlay = document.getElementById('modalOverlay');

        clearbtn.addEventListener('click', function(){
            document.getElementById('searchinput').value = '';

        })
    </script>


    <style>
        .search-icon {
            height: 13px;
            width: 13px;
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #888;
        }
        
        .search-icon:hover {
            color: #000;
        }
        
        .clear-icon {
            
            position: absolute;
            top: 50%;
            right: 45px;
            transform: translateY(-50%);
            color: #888;
        }
        
        .clear-icon:hover {
            color: #000;
        }

        .clear-btn {
            position: absolute;
            top: 50%;
            right: 5px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #0d0c0cff;
            padding: 0;
        }
        .search-btn {
            position: absolute;
            top: 50%;
            right: 50px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            padding: 0;
        }
        .search-btn:hover {
            color: #000;
        }

        .search-input {
            height: 40px;
            width: 600px;
            border-radius: 30px;
            padding-left: 15px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .search-container {
            position: relative;
        }
    </style>

</body>
</html>
<?php 
    }else{
        header("Location: /login");
    }
?>