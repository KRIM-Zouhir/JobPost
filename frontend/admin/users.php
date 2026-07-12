<?php 
    include './frontend/header.php';
    include './backend/auth.php';
    include './backend/connect.php';
    include './backend/search.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body class="bg-black">
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
            $users = get_users($db, $start ,$rows_per_page);

    ?>
    <div class="p-5 mt-5 text-white">
        <h3>Users</h3>
        <form method="GET" action="/admin/users" id="FormSearch">
            <input type="text" name="search" value="<?php if(isset($_GET['search'])){ echo $_GET['search'];} ?>" placeholder="Type ...">
            <input type="submit" id="BtnSearch" value="Search">
        </form>
        <br><br>

        <?php 
            if(!isset($_GET['search'])){
                if(!empty($users)){
                    foreach($users as $user){
                        echo "<br><br>";
        
                        echo htmlentities($user['user_id']) . "<br>";
                        echo htmlentities($user['user_name']) . "<br>";
                        echo htmlentities($user['user_email']) . "<br>";
                        echo '<button class="BtnChangePwd" data-userid="'. htmlentities($user['user_id']) .'" >Change Password</button>' . "<br>";
                        echo htmlentities($user['user_role']) . "<br>";
                        echo htmlentities($user['is_verified']) . "<br>";
                        echo htmlentities($user['verification_token']) . "<br>";
                        echo htmlentities($user['token_expires_at']) . "<br>";
                        echo htmlentities($user['user_date']) . "<br>";
                        echo '<button type="button" class="BtnEditInfo" 
                              data-userid="'. htmlentities($user['user_id']) .'" 
                              data-username="'. htmlentities($user['user_name']) .'" 
                              data-useremail="'. htmlentities($user['user_email']) .'" 
                              data-userrole="'. htmlentities($user['user_role']) .'" 
                              data-verified="'. htmlentities($user['is_verified']) .'"  
                              data-token="'. htmlentities($user['verification_token']) .'"
                              data-token_expires="'. htmlentities($user['token_expires_at']) .'"
                              data-userdate="'. htmlentities($user['user_date']) .'" 
                              >
                              Edit Infos 
                              </button>
                        ';
        
                        echo "<br>";
                    }
                }else{echo "No User found";}
            }else{
                $search_value = htmlentities($_GET['search']) ?? '';
                $users = search_posts($db, $search_value, $start, $rows_per_page);
                if(!empty($users)){
                    foreach($users as $user){
                        echo "<br><br>";
        
                        echo htmlentities($user['user_id']) . "<br>";
                        echo htmlentities($user['user_name']) . "<br>";
                        echo htmlentities($user['user_email']) . "<br>";
                        echo '<button class="BtnChangePwd" data-userid="'. htmlentities($user['user_id']) .'" >Change Password</button>' . "<br>";
                        echo htmlentities($user['user_role']) . "<br>";
                        echo htmlentities($user['is_verified']) . "<br>";
                        echo htmlentities($user['verification_token']) . "<br>";
                        echo htmlentities($user['token_expires_at']) . "<br>";
                        echo htmlentities($user['user_date']) . "<br>";
                        echo '<button type="button" class="BtnEditInfo" 
                              data-userid="'. htmlentities($user['user_id']) .'" 
                              data-username="'. htmlentities($user['user_name']) .'" 
                              data-useremail="'. htmlentities($user['user_email']) .'" 
                              data-userrole="'. htmlentities($user['user_role']) .'" 
                              data-verified="'. htmlentities($user['is_verified']) .'"  
                              data-token="'. htmlentities($user['verification_token']) .'"
                              data-token_expires="'. htmlentities($user['token_expires_at']) .'"
                              data-userdate="'. htmlentities($user['user_date']) .'" 
                              >
                              Edit Infos 
                              </button>
                        ';
        
                        echo "<br>";
                    }
                }else{echo "No User found";}

            }
         ?>


        <form method="POST" action="../../backend/auth.php" id="FormEditInfos" style="display: none;">
            <input type="hidden" name="form_type" value="edit_info">
            <input type="hidden" name="user_id">

            <input type="text" name="user_name">
            <br>
            <input type="text" name="user_email">
            <br>
            <input type="text" name="user_role">
            <br>
            <select name="user_verified" placeholder="Is Verified">
                <option value="1">Verify</option>
                <option value="0">Unverify</option>
            </select>
            <!-- <input type="text" name="user_verified"> -->
            <br>
            <input type="text" name="user_token">
            <br>
            <input type="datetime-local" name="user_tokenexpire">
            <br>
            <input type="datetime-local" name="user_date">
            <br>
            <input type="submit" name="submit" value="Update">
        </form>


        <form method="POST" action="/backend/auth.php" id="FormChangePwd" style="display: none;">
            <input type="hidden" name="form_type" value="changepwd">
            <input type="hidden" name="user_id">
            <input type="text" name="new_pwd" placeholder="New Password">
            <br>
            <input type="submit" value="Change">
        </form>

    </div>

    <br><br>

    <!-- Pagination -->
    <?php 
        global $pages;

        if(isset($_GET['page-nr']) && !isset($_GET['search'])){
            $search_value =  $_GET['search'] ?? '';
            $pages = calcul($db , $table = "users" , $rows_per_page);

            $uri_search = '';
            $uri_page_nr = '/admin/users?page-nr=';

        }elseif(isset($_GET['search'])){
            $search_value = htmlentities($_GET['search']);
            $pages = calcul_search($db, $table="users", $rows_per_page , "username" , '%' . $search_value . '%');

            $uri_search = '/admin/users?search=';
            $uri_page_nr = '&page-nr=';

        }else{
            $search_value =  $_GET['search'] ?? '';
            $pages = calcul($db , $table = "users" , $rows_per_page);

            $uri_search = '';
            $uri_page_nr = '/admin/users?page-nr=';

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

    <script>
        document.addEventListener('click', function(e){
            if(e.target.classList.contains('BtnChangePwd')){
                $user_id = e.target.dataset.userid;

                document.querySelector('#FormChangePwd [name="user_id"]').value = $user_id;

                const form = document.getElementById('FormChangePwd') 
                form.style.display = form.style.display === 'none' ? 'block' : 'none';


            }
        // })


        // document.addEventListener('click', function(e){
            if(e.target.classList.contains('BtnEditInfo')){
                const userData={
                    userid: e.target.dataset.userid,
                    username: e.target.dataset.username,
                    useremail: e.target.dataset.useremail,
                    userrole: e.target.dataset.userrole,
                    userverified: e.target.dataset.verified,
                    usertoken: e.target.dataset.token,
                    usertokenexpire: e.target.dataset.token_expires,
                    userdate: e.target.dataset.userdate
                };
                
                document.querySelector('#FormEditInfos [name="user_id"]').value = userData.userid;
                document.querySelector('#FormEditInfos [name="user_name"]').value = userData.username;
                document.querySelector('#FormEditInfos [name="user_email"]').value = userData.useremail;
                document.querySelector('#FormEditInfos [name="user_role"]').value = userData.userrole;
                document.querySelector('#FormEditInfos [name="user_verified"]').value = userData.userverified;
                document.querySelector('#FormEditInfos [name="user_token"]').value = userData.usertoken;
                document.querySelector('#FormEditInfos [name="user_tokenexpire"]').value = userData.usertokenexpire;
                document.querySelector('#FormEditInfos [name="user_date"]').value = userData.userdate;

                const FormEditInfos = document.getElementById("FormEditInfos");
                FormEditInfos.style.display = FormEditInfos.style.display === 'none' ? 'block' : 'none';

            }

        })



    </script>
    
</body>
</html>