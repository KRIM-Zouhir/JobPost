<?php 
    include './frontend/header.php';
    include './backend/auth.php';
    include './backend/connect.php';
    include './backend/search.php';
    include_once './frontend/helpers/session-init.php';

    if($id === null && $role === null){
        header('Location: /login');
    }
    if($role === "user"):
        header("Location: /home");
    
    elseif($role === "admin"):
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
            <form method="GET" action="/admin/users">
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
                    $users = get_users($db, $start ,$rows_per_page);
                }else{
                    $search_value = htmlentities($_GET['search']) ?? '';
                    $users = search_posts($db, $search_value, $start, $rows_per_page);
                }
                if(!empty($users)){
                    foreach($users as $user){
            ?>
                <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow">
                            <div class="card-header">

                                    <p class="card-subtitle ">
                                        <?php echo htmlspecialchars($user['user_id']); ?>
                                    </p>
                                    <p class="fw-bold mb-1">
                                        <?php echo htmlspecialchars(strtoupper($user['user_role'])) ; ?>
                                    </p>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center gap-1">


                                    <h6 class="card-title fw-bold">
                                        <?php echo htmlspecialchars($user['user_name']); ?>
                                    </h6>

                                    <h6 class="card-subtitle">
                                        <?php echo htmlspecialchars($user['user_email']); ?>
                                    </h6>


                                    <?php 
                                        if($user['is_verified'] == 0):
                                    ?>
                                            <p class="fw-bold text-danger mb-1">
                                                Not Verified
                                            </p>
                                    <?php
                                        else:
                                    ?>
                                            <p class="fw-bold text-success mb-1">
                                                Verified
                                            </p>
                                    <?php
                                        endif;
                                    ?>

                                    <p class="mb-1">
                                        <strong>Token:</strong>
                                        <?php echo htmlspecialchars($user['verification_token']); ?>
                                    </p>

                                    <p class="mb-1">
                                        <strong>Token Date:</strong>
                                        <?php echo htmlspecialchars(date("M d, Y H:i A", strtotime($user['token_expires_at']))); ?>
                                    </p>

                                    <p class="mb-1">
                                        <strong>Created acc:</strong>
                                        <?php echo htmlspecialchars(date("M d, Y H:i A", strtotime($user['user_date']))); ?>
                                    </p>
                            </div>

                            <div class="card-footer">
                                    <button type="button" class="btn bg-blue text-white BtnEditInfo" 
                                        data-userid="<?php htmlentities($user['user_id']) ?>" 
                                        data-username="<?php htmlentities($user['user_name']) ?>" 
                                        data-useremail="<?php htmlentities($user['user_email']) ?>" 
                                        data-userrole="<?php htmlentities($user['user_role']) ?>" 
                                        data-verified="<?php htmlentities($user['is_verified']) ?>"  
                                        data-token="<?php htmlentities($user['verification_token']) ?>"
                                        data-token_expires="<?php htmlentities($user['token_expires_at']) ?>"
                                        data-userdate="<?php htmlentities($user['user_date']) ?>" 
                                        >Edit Infos
                                    </button>

                                    <button type="button" class="btn btn-danger text-white BtnChangePwd" 
                                            data-userid="<?php htmlentities($user['user_id']) ?>"
                                            >Change Password
                                    </button>
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
    <div class="bg-blue p-5">
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

<?php endif; ?>