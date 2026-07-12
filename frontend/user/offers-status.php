<?php 
    include './frontend/header.php';
    include './backend/connect.php';
    include './backend/apply.php';
    include './backend/post.php';
    include './backend/search.php';


    if($role == "user") :
        $start = 0;
        $rows_per_page = 10;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers status</title>
</head>
<body class="bg-black">
    <div class="p-5 mt-5 text-white">
        <h3>Offers status</h3>
        <form method="GET" action="/offers-status" id="FormSearch">
            <input type="text" name="search" value="<?php if(isset($_GET['search'])){ echo $_GET['search'];} ?>" placeholder="Type ...">
            <input type="submit" id="BtnSearch" value="Search">
        </form>
            <br>
            <?php  
            if(!isset($_GET['search'])){
                $applications = get_applications_foruser($db, $start, $rows_per_page, $id );
                if(!empty($applications)){
                    foreach($applications as $application){
                        // $postid = $application['post_id'];
                        echo $application['post_id'] . "<br>";
                        echo $application['post_title'] . "<br>";
                        $fetch = getpsotbyid($db, $application['post_id']);
                        if(!empty($fetch)){
                            echo $fetch['company'] . "<br>";
                            echo $fetch['location'] . "<br>";
                        }
                        echo $application['status'] . "<br>";
                        echo $application['app_date'] . "<br>";

                        echo '<a href="/jobs/' . $application['post_id']. '"><button>More details</button></a>';
                    }
                }
            }else{
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

                        echo '<a href="/jobs/' . $application['post_id']. '"><button>More details</button></a>';
                        }
                }else{
                    echo "No application found";
                }
            }
            ?>

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
    
</body>
</html>
<?php 
    else :  
        header("Location: /login");
    
    endif; 
?>