<?php

    session_start();
    if(isset($_COOKIE[session_name()])):
        setcookie(session_name(), '', time()-7000000, '/');
    endif;
    session_destroy();
    header('Location: /home');
    exit;

?>