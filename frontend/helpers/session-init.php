<?php
    function sessionstart(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        $id = $_SESSION['user_id'] ?? null;
        $role = $_SESSION['role'] ?? null; 
        return [$id, $role];
    }

    [$id, $role] = sessionstart();
?>