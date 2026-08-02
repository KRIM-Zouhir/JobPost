<?php 
    include './backend/connect.php';
    include './frontend/header.php';
    include './backend/apply.php';
    include './backend/post.php';
    include './backend/search.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body class="bg-blue">
    <?php
        [$id , $role] = sessionstart(); 
        if($id === null && $role === null){
            header('Location: /login');
        }
        if($role === "user"):
            header("Location: /home");
        elseif($role === "admin"):
            $start = 0 ; 
            $rows_per_page = 10 ;
            $applications = get_applications($db, $start , $rows_per_page);

    ?>

    <div class="p-5 mt-5 text-white">
        <h3>Applications</h3>
        <form method="GET" action="/admin/applications">
            <input type="text" name="search" id="search" placeholder="Type ...">
            <input type="submit" value="Search">
        </form>
        <br><br>
         <?php 
            if(!isset($_GET['search'])){
                if(empty($applications)) {echo "No application exist yet";} 
                foreach($applications as $application){
                    echo $application['app_id'] . "<br>";
                    $user_id =  $application['user_id'];
                    echo id_to_user($db , $user_id) . "<br>";
                    echo $application['post_id'] . "<br>";
                    echo "CV :" . "<br>";
                    echo '<a href="' . "/backend/uploads/" . "post_" . $application['post_id'] . "/CV" . "_" . $application['user_id'] . "_" . $application['post_id'] . ".pdf" .'"><button>Open</button></a>' . "<br>";
                    echo "Cover :". "<br>";
                    echo '<a href="' . "/backend/uploads/" . "post_" . $application['post_id'] . "/Cover" . "_" . $application['user_id'] . "_" . $application['post_id'] . ".pdf" .'"><button>Open</button></a>' . "<br>";
                    echo $application['status'] . "<br>";
                    echo $application['app_date'] . "<br>";
    
                    if($application['status'] == "accepted"){
                        echo '<input type="submit" value="Accept" disabled>';
                    }
                    else{
                        echo '<form method="POST" action="../../backend/apply.php" >';
                            echo '<input type="hidden" name="form_type" value="accept">';
                            echo '<input type="hidden" name="id" value="' . $application['app_id'] . '">';
                            echo '<input type="submit" value="Accept" >';
                        echo '</form>';
    
                    }
                    if($application['status'] == "pending"){
                        echo '<input type="submit" value="Pending" disabled>';
                    }else{
                        echo '<form method="POST" action="../../backend/apply.php" >';
                            echo '<input type="hidden" name="form_type" value="pending">';
                            echo '<input type="hidden" name="id" value="' . $application['app_id'] . '">';
                            echo '<input type="submit" value="Pending">';
                        echo '</form>';
                    }
    
                    if($application['status'] == "rejected"){
                        echo '<input type="submit" value="Deny" disabled>';
                    }else{
                        echo '<form method="POST" action="../../backend/apply.php" >';
                            echo '<input type="hidden" name="form_type" value="deny">';
                            echo '<input type="hidden" name="id" value="' . $application['app_id'] . '">';
                            echo '<input type="submit" value="Deny">';
                        echo '</form>';
    
                    }
                    echo "<br><br> ";
    
                }
            }else{
                $search_value =  htmlentities($_GET['search']) ?? '';
                $search_applications = search_applications($db, '%' . $search_value . '%', $start , $rows_per_page);

                foreach($search_applications as $application){
                    echo $application['app_id'] . "<br>";
                    $user_id =  $application['user_id'];
                    echo id_to_user($db , $user_id) . "<br>";
                    echo $application['post_id'] . "<br>";
                    echo "CV :" . "<br>";
                    echo '<a href="' . "/backend/uploads/" . "post_" . $application['post_id'] . "/CV" . "_" . $application['user_id'] . "_" . $application['post_id'] . ".pdf" .'"><button>Open</button></a>' . "<br>";
                    echo "Cover :". "<br>";
                    echo '<a href="' . "/backend/uploads/" . "post_" . $application['post_id'] . "/Cover" . "_" . $application['user_id'] . "_" . $application['post_id'] . ".pdf" .'"><button>Open</button></a>' . "<br>";
                    echo $application['status'] . "<br>";
                    echo $application['app_date'] . "<br>";
    
                    if($application['status'] == "accepted"){
                        echo '<input type="submit" value="Accept" disabled>';
                    }
                    else{
                        echo '<form method="POST" action="../../backend/apply.php" >';
                            echo '<input type="hidden" name="form_type" value="accept">';
                            echo '<input type="hidden" name="id" value="' . $application['app_id'] . '">';
                            echo '<input type="submit" value="Accept" >';
                        echo '</form>';
    
                    }
                    if($application['status'] == "pending"){
                        echo '<input type="submit" value="Pending" disabled>';
                    }else{
                        echo '<form method="POST" action="../../backend/apply.php" >';
                            echo '<input type="hidden" name="form_type" value="pending">';
                            echo '<input type="hidden" name="id" value="' . $application['app_id'] . '">';
                            echo '<input type="submit" value="Pending">';
                        echo '</form>';
                    }
    
                    if($application['status'] == "rejected"){
                        echo '<input type="submit" value="Deny" disabled>';
                    }else{
                        echo '<form method="POST" action="../../backend/apply.php" >';
                            echo '<input type="hidden" name="form_type" value="deny">';
                            echo '<input type="hidden" name="id" value="' . $application['app_id'] . '">';
                            echo '<input type="submit" value="Deny">';
                        echo '</form>';
    
                    }
                    echo "<br><br> ";
                }



            }
            
        ?>

        


    </div>

    


   <!-- Pagination -->

    <?php 
        global $pages;

        if(isset($_GET['page-nr']) && !isset($_GET['search'])){
            $search_value =  htmlentities($_GET['search']) ?? '';
            $pages = calcul($db , $table = "posts" , $rows_per_page);

            $uri_search = '';
            $uri_page_nr = '/admin/applications?page-nr=';

        }elseif(isset($_GET['search'])){
            $search_value =  htmlentities($_GET['search']);
            $pages = calcul_search($db, $table="applications", $rows_per_page , "status", '%' . $search_value . '%');

            $uri_search = '/admin/applications?search=';
            $uri_page_nr = '&page-nr=';

        }else{
            $search_value =  htmlentities($_GET['search'])?? '';
            $pages = calcul($db , $table = "applications" , $rows_per_page);

            $uri_search = '';
            $uri_page_nr = '/admin/applications?page-nr=';

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
    <?php endif; ?>

</body>
</html>